<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AccountController extends Controller
{
    protected string $redirectTo = RouteServiceProvider::HOME;

    protected function create(Request $request): RedirectResponse
    {
        try {
            $currency = $request['currency'];
            $user = Auth::user();
            $accountExists = Account::where('user_id', auth()->id())
                ->where('currency', $currency)
                ->exists();

            $count = Account::where('user_id', auth()->id())->count();


            if ($accountExists) {
                throw new Exception("A bank account with this currency already exists for the authenticated user.");
            }   else if ( $count > 4) {
                throw new Exception("You got limit. Max is 5 accounts");
            }

            else {
                $account = (new Account())->fill([
                    'number' => 'LV' . rand(1000000000, 9999999999),
                    'balance' => 0,
                    'currency' => $currency
                ]);
                $account->user()->associate($user);
                $account->save();
            }
            return redirect()->back()->with('success', 'Account created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(): View
    {
        $accounts = Account::where('user_id', Auth::id())->get();

        return view('accounts.accounts', [
            'accounts'=>$accounts,
            'currencies' => self::currencies()
        ]);
    }

    public function update(Account $account, Request $request): RedirectResponse
    {
        if($account->user_id !== Auth::id()){
            abort(403);
        }

        $account->update([
            'label' => $request->get('label')
        ]);
        return redirect()->back();
    }

    public function delete(Account $account, Request $request): RedirectResponse
    {
        Account::where('user_id', auth()->id())
            ->where('number', $account->number)
            ->delete();

        return redirect('accounts')->with('success', 'Account deleted successfully.');
    }

    public function edit(Account $account): View
    {
        if($account->user_id !== Auth::id()){
            abort(403);
        }

        return \view('accounts.edit', [
            'account' => $account
        ]);
    }

    private static function currencies(): array
    {
        $client = new Client();
        $response = $client->get('https://www.bank.lv/vk/ecb.xml');
        $xml = $response->getBody()->getContents();

        $xml = simplexml_load_string($xml);
        $currencies = [];

        foreach ($xml->Currencies->Currency as $currency) {
            $currencies[] = [
                'name' => (string) $currency->ID,
                'rate' => (float) $currency->Rate,
            ];
        }
        Cache::put('currencies', $currencies, 3600);
        return $currencies;
    }
}
