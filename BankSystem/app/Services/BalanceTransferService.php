<?php

namespace App\Services;

use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BalanceTransferService
{

    public function transfer(Request $request): void
    {
        $fromAccount = Account::findOrFail($request->get('from_account'));

        $currencies = Cache::get('currencies');
        $amount = $request->get('amount') * 100;
        $toAccount = Account::where('number', $request->get('to_account'))->firstOrFail();

        $toUser = User::find($toAccount->user_id);


        //CHECK CURRENCIES
        $toExchangeRate = $fromExchangeRate = 1;
        foreach ($currencies as $currency) {
            if ($currency['name'] === $toAccount->currency) {
                $toExchangeRate = $currency['rate'];
            }
            if ($currency['name'] === $fromAccount->currency) {
                $fromExchangeRate = $currency['rate'];
            }
        }
        $exchangeRate = $toAccount->currency === $fromAccount->currency ? 1 : $toExchangeRate / $fromExchangeRate;
        $amount *= $exchangeRate;

        //UPDATE MONEY
        $fromAccount->money -= $request->get('amount') * 100;
        $fromAccount->save();

        $toAccount->money += $amount;
        $toAccount->save();

        //MAKE TRANSACTIONS
        Transaction::create([
            'sender_name' => Auth::user()->name,
            'from_account' => $fromAccount->number,
            'received_name' => $toUser->name,
            'to_account' => $toAccount->number,
            'money' => $request->get('amount') * 100,
            'currency' => $fromAccount->currency,
            'details' => $request->input('details'),
            'description' => 'SENT'
        ]);

        Transaction::create([
            'sender_name' => $toUser->name,
            'from_account' => $toAccount->number,
            'received_name' => Auth::user()->name,
            'to_account' => $fromAccount->number,
            'money' => $amount,
            'currency' => $toAccount->currency,
            'details' => $request->input('details'),
            'description' => 'RECEIVED'
        ]);
    }
}
