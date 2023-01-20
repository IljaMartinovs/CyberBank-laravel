<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CryptoTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CryptoTransactionController extends Controller
{
    public function index(Account $account): View
    {
        $cryptoTransactions = CryptoTransaction::where('number', $account->number)->get();
        return view('crypto-transactions', [
            'transactions' => $cryptoTransactions->all()
        ]);
    }

    public function filterCryptoTransactions(Request $request, Account $account): View
    {
        $cryptoTransactions = CryptoTransaction::where('number', $account->number)
            ->where('symbol', $request->input('symbol'))->get();

        $request->validate([
            'symbol' => [
                'required',
                Rule::exists('users_crypto_transactions', 'symbol')->where(function ($query) use ($account) {
                    $query->where('number', $account->number);
                }),
            ],
        ]);

        return view('crypto-transactions', [
            'transactions' => $cryptoTransactions->all()
        ]);
    }
}
