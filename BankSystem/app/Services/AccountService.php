<?php

namespace App\Services;

use App\Models\Account;
use Exception;
use Illuminate\Http\RedirectResponse;

class AccountService
{
    public function createAccount($currency,$user): RedirectResponse
    {
        try {
            $accountExists = Account::where('user_id', $user->id)
                ->where('currency', $currency)
                ->exists();

            $count = Account::where('user_id', $user->id)->count();


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
}
