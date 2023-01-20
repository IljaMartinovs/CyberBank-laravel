<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\CryptoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CryptoController extends Controller
{
    private CryptoService $cryptoService;

    public function __construct(CryptoService $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function index(Request $request): View
    {
        $symbol = $request->get('crypto');
        $symbols = ['BTC', 'ETH', 'XRP', 'DOT', 'DOGE', 'LTC', 'BCH', 'ADA', 'BNB', 'SRM', 'LUNA', 'MATIC'];
        $cryptoCurrencies = $this->cryptoService->getCrypto($symbol, $symbols);
        $accounts = Account::where('user_id', Auth::id())->get();

        if (count($cryptoCurrencies->all()) == 1)
            return view('single-crypto', [
                'crypto' => $cryptoCurrencies->all(),
                'accounts' => $accounts
            ]);
        return view('index', ['crypto' => $cryptoCurrencies->all()]);
    }

    public function buyCrypto(Request $request): RedirectResponse
    {

        $request->validate([
            'quantity_buy' => 'required|numeric|min:0.001',
        ]);

        $fromAccount = $this->fetchUserAccount($request);
        if ($fromAccount->user_id !== Auth::id()) {
            abort(403);
        }

        $rate = 1.00;

        $currencies = Cache::get('currencies');
        if ($fromAccount->currency !== 'EUR') {
            $rates = array_column($currencies, 'rate', 'name');
            $rate = $rates[$fromAccount->currency];
        }

        $userAccount = $request['from_account'];
        $symbol = $request['symbol'];
        $userId = $fromAccount->user_id;
        $userMoney = $fromAccount->money / 100;
        $number = $fromAccount->number;
        $amount = $request['quantity_buy'];
        $currency = $fromAccount->currency;

        $this->cryptoService->buyCrypto($userId, $userAccount, $userMoney, $number, $symbol, $amount, $rate, $currency);

        return redirect()->back();
    }

    public function sellCrypto(Request $request): RedirectResponse
    {
        $request->validate([
            'quantity_sell' => 'required|numeric|min:0.001',
        ]);

        $fromAccount = $this->fetchUserAccount($request);
        if ($fromAccount->user_id !== Auth::id()) {
            abort(403);
        }

        $rate = 1.00;

        $currencies = Cache::get('currencies');
        if ($fromAccount->currency !== 'EUR') {
            $rates = array_column($currencies, 'rate', 'name');
            $rate = $rates[$fromAccount->currency];
        }

        $symbol = $request['symbol'];
        $userAccount = $request['from_account'];
        $userId = $fromAccount->user_id;
        $number = $fromAccount->number;
        $amount = $request['quantity_sell'];
        $currency = $fromAccount->currency;

       $this->cryptoService->sellCrypto($userId, $userAccount, $number, $symbol, $amount, $rate,$currency);
        return redirect()->back();
    }

    private function fetchUserAccount(Request $request): Account
    {
        return Account::where('number', $request->get('from_account'))->firstOrFail();
    }
}
