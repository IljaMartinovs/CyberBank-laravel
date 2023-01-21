<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\AccountService;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AccountController extends Controller
{
    protected string $redirectTo = RouteServiceProvider::HOME;
    private AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    protected function create(Request $request): RedirectResponse
    {
        $currency = $request['currency'];
        $user = Auth::user();
        return $this->accountService->createAccount($currency, $user);
    }

    public function show(): View
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        $user = User::where('id', Auth::id())->get();

        return view('accounts.accounts', [
            'user' => $user->all()[0]->name,
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
        return redirect('accounts')->with('success', 'Account label successfully edited.');
    }

    public function delete(Account $account): RedirectResponse
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
        $currencies [] = [
            'name' => 'EUR',
            'rate' => 1.00,
        ];
        Cache::put('currencies', $currencies, 3600);
        return $currencies;
    }
}
