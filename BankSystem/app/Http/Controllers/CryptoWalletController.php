<?php

namespace App\Http\Controllers;

use App\Services\CryptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CryptoWalletController extends Controller
{
    private CryptoService $cryptoService;

    public function __construct(CryptoService $cryptoService)
    {
        $this->cryptoService = $cryptoService;
    }

    public function index(): View
    {
        $ownedCryptoCurrencies = DB::table('owned_crypto_currencies')
            ->where('user_id', auth()->id())
            ->get();

        $ownedCrypto = [];
        foreach ($ownedCryptoCurrencies->all() as $ownedCryptoCurrency) {
            $ownedCrypto[] = $ownedCryptoCurrency->symbol;
        }

        if (count($ownedCrypto) != 0) {
            $crypto = $this->cryptoService->getCrypto('', $ownedCrypto);
            $this->cryptoService->updatePrice($crypto);
        }

        $cryptoTransactions = DB::table('users_crypto_transactions')
            ->where('user_id', auth()->id())
            ->get();

        return view('crypto-wallet', [
            'ownedCrypto' => $ownedCryptoCurrencies,
            'transactions' => $cryptoTransactions->all()
        ]);
    }
}
