<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserTransactionController extends Controller
{
    public function index(Account $account): View
    {
        $transactions = Transaction::where('from_account', $account->number)->get();
        return \view('user-transactions', [
            'account' => $account,
            'transactions' => $transactions->all()
        ]);
    }

    public function filterTransactions(Request $request, Account $account): View
    {
        $request->validate([
            'account_number' => 'nullable|required_without:recipient',
            'recipient' => 'nullable|required_without:account_number',
            'start_date' => 'nullable|date|after:-1 year|before:+1 year',
            'end_date' => 'nullable|date|required_with:start_date|after:-1 year|before:+1 year',
        ]);

        $transactions = Transaction::where('from_account', $account->number)
            ->when($request->input('account_number'), function ($query) use ($request) {
                return $query->where('to_account', 'like', "%{$request->input('account_number')}%");
            })
            ->when($request->input('recipient'), function ($query) use ($request) {
                return $query->where('received_name', 'like', "%{$request->input('recipient')}%");
            })
            ->when($request->input('start_date') && $request->input('end_date'), function ($query) use ($request) {
                $start_date = date("Y-m-d", strtotime($request->input('start_date')));
                $end_date = date("Y-m-d", strtotime($request->input('end_date')));
                return $query->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date]);
            })
            ->get();

        return view('user-transactions', [
            'account' => $account,
            'transactions' => $transactions->all()
        ]);
    }
}
