<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected string $redirectTo = '/accounts';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birth' => ['required', 'date', function ($attribute, $value, $fail) {
                $birth_date = Carbon::createFromFormat('m/d/Y', $value)->toDateString();
                if ($birth_date > Carbon::now()->subYears(18)->toDateString()) {
                    $fail('You must be over 18 years old to register.');
                }
            }],
        ]);
    }

    protected function create(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birth_date' => $data['birth'],
        ]);

        $account = (new Account())->fill([
            'number' => 'LV' . rand(1000000000, 9999999999),
            'balance' => 0,
            'currency' => 'EUR'
        ]);

        $account->user()->associate($user);
        $account->save();

        $counter = 1;
        for ($i = 0; $i < 12; $i++) {
            $code = strval(random_int(1000, 99999)); // Generate a random code
            $user->codeCards()->create(['code' => $code, 'code_number' => $counter]);
            $counter++;
        }
        return $user;
    }
}
