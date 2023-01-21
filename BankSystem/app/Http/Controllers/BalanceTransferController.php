<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\BalanceTransferService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BalanceTransferController extends Controller
{
    private BalanceTransferService $balanceTransferService;

    public function __construct(BalanceTransferService $balanceTransferService)
    {
        $this->balanceTransferService = $balanceTransferService;
    }

    public function show(): View
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        return \view('balance-transfer', [
            'accounts' => $accounts,
        ]);
    }

    public function transfer(Request $request): RedirectResponse
    {
        $fromAccount = Account::findOrFail($request->get('from_account'));

        if ($fromAccount->user_id !== Auth::id()) {
            abort(403);
        }


        Validator::extend('password_match', function($attribute, $value) {
            return Hash::check($value, auth()->user()->password);
        }, 'The :attribute field is incorrect.');

        //VALIDATION
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . ($fromAccount->money / 100),
            'to_account' => 'required|exists:accounts,number',
            'code_number' => 'required',
            'password' => 'required|password_match',
            'messages' => [
                'password_match' => 'The password do not match.'
            ],
            'code' => ['required', function ($attribute, $value, $fail) use ($request) {
                $codeCard = DB::table('users_code_cards')
                    ->where('user_id', '=', auth()->id())
                    ->where('code_number', '=', $request->input('code_number'))
                    ->first();
                if (!$codeCard || $request->input('code') !== $codeCard->code) {
                    $fail('The code does not match.');
                }
            }]
        ]);

        $toAccount = Account::where('number', $request->get('to_account'))->firstOrFail();
        $amount = $request->get('amount');
        $details = $request->get('details');

        $this->balanceTransferService->transfer($fromAccount,$toAccount,$amount,$details);
//        $this->balanceTransferService->transfer($request);
        return redirect()->back()->with('success', "you successfully sent money");
    }
}
