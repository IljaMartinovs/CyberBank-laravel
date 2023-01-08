<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CodeCard;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BalanceTransferController extends Controller
{
    public function show(): View
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        $accountNumbers = $accounts->pluck('number')->toArray();
        $transactions = Transaction::whereIn('from_account', $accountNumbers)->get();

        return \view('balance-transfer', [
            'accounts' => $accounts,
            'transactions' => $transactions->all()
        ]);
    }

    public function transfer(Request $request): RedirectResponse
    {
        $codeCard = DB::table('users_code_cards')
            ->where('user_id', '=', auth()->id())
            ->where('code_number', '=', $request->input('code_number'))
            ->first();


        //VALIDATION

        //check if codes match
        Validator::extend('code_matches', function () use ($request, $codeCard) {
            return $codeCard->code === $request->input('code');
        }, 'The code does not match.');

        //check if account number to_account exist
        Validator::extend('account_exists', function ($attribute, $value, $parameters, $validator) {
            return DB::table('accounts')->where('number', $value)->exists();
        }, 'The selected account number is invalid.');

        $request->validate([
            'amount' => 'required',
            'to_account' => 'required|account_exists',
            'code' => 'required|code_matches'
        ]);


        $currencies = Cache::get('currencies');
        $amount = $request->get('amount') * 100;

        //FROM ACCOUNT
        $fromAccount = Account::findOrFail($request->get('from_account'));
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|max:' . $fromAccount->money,
        ]);

        if ($validator->fails()) {
            return redirect('balance-transfer')
                ->withErrors($validator)
                ->withInput();
        }
        $fromAccountCurrency = $fromAccount->currency;

        if($fromAccount->user_id !== Auth::id()){
            abort(403);
        }

        //TO ACCOUNT
        $toAccount =  Account::where('number', $request->get('to_account'))->firstOrFail();
        $toAccountCurrency = $toAccount->currency;

        //CHECK CURRENCIES
        if ($toAccountCurrency !== $fromAccountCurrency) {
            foreach ($currencies as $currency) {
                if ($currency['name'] === $toAccountCurrency) {
                    $toExchangeRate = $currency['rate'];
                }
                if ($currency['name'] === $fromAccountCurrency) {
                    $fromExchangeRate = $currency['rate'];
                }
            }
            if (!isset($fromExchangeRate)) {
                $fromExchangeRate = 1;
            }
            if (!isset($toExchangeRate)) {
                $toExchangeRate = 1;
            }
            // Calculate the exchange rate between the two currencies
            $exchangeRate = $toExchangeRate / $fromExchangeRate;
            $amount *= $exchangeRate;
        }

        $fromAccount->update([
            'money' => $fromAccount->money - $request->get('amount') * 100
        ]);

        $toAccount->update([
            'money' => $toAccount->money + $amount
        ]);

        //WHO SENT
        Transaction::create([
            'from_account' => $fromAccount->number,
            'to_account'=> $toAccount->number,
            'money' => $request->get('amount') * 100,
            'currency' => $fromAccountCurrency,
            'description' => 'SENT'
        ]);

        //WHO RECEIVED
        Transaction::create([
            'from_account' => $toAccount->number,
            'to_account'=> $fromAccount->number,
            'money' => $amount,
            'currency' => $toAccountCurrency,
            'description' => 'RECEIVED'
        ]);

        return redirect()->back();
    }
}
