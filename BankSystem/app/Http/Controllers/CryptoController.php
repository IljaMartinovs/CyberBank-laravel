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

    public function cryptoTransaction(Request $request, string $action): RedirectResponse
    {
        $request->validate([
            'amount_buy' => ($action === 'buy') ? 'required|numeric|min:0.001' : 'nullable',
            'amount_sell' => ($action === 'sell') ? 'required|numeric|min:0.001' : 'nullable',
        ], [
            'amount_buy.required' => 'You need to input the Quantity to Buy',
            'amount_sell.required' => 'You need to input the Quantity to Sell'
        ]);

        $fromAccount = $this->fetchUserAccount($request);
        if ($fromAccount->user_id !== Auth::id()) {
            abort(403);
        }

        $rate = $this->calculateRate($fromAccount);
        $symbol = $request['symbol'];
        $amount = ($action === 'buy') ? $request->input('amount_buy') : $request->input('amount_sell');

        if ($action === 'buy') {
            $this->cryptoService->buyCrypto($symbol, $amount, $rate, $fromAccount);
        } else {
            $this->cryptoService->sellCrypto($symbol, $amount, $rate, $fromAccount);
        }
        return redirect()->back();
    }

    private function calculateRate($fromAccount): float
    {
        $rate = 1.00;
        $currencies = Cache::get('currencies');
        if ($fromAccount->currency !== 'EUR') {
            $rates = array_column($currencies, 'rate', 'name');
            $rate = $rates[$fromAccount->currency];
        }
        return $rate;
    }

    private function fetchUserAccount(Request $request): Account
    {
        return Account::where('number', $request->get('from_account'))->firstOrFail();
    }
}
