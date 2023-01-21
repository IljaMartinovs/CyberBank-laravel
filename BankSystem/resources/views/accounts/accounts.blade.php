@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-lg overflow-hidden shadow-lg p-6 m-4">
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-medium">
                            <img src="{{ asset('images/card-logo2.jpg') }}" alt="Logo" width="40" height="40"
                                 class="inline-block align-middle mr-2">
                            <span class="inline-block align-middle">LV********22</span>
                        </div>
                    </div>
                    <div class="text-lg font-medium">Owner : {{ $user }}</div>

                    <form method="post" action="/accounts">
                        @csrf
                        <label class="text-lg font-medium inline-block" for="currency">Currency:</label>
                        <select class="form-select appearance-none inline-block
      block
      w-20
      px-3
      py-1.5
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border border-solid border-gray-300
      rounded
      transition
      ease-in-out
      m-0
      focus:text-gray-700 " aria-label="Default select example"
                                id="currency" name="currency">
                            @foreach ($currencies as $code => $currency)
                                <option class="text-base py-2 px-4 rounded-md bg-gray-200 border border-gray-300"
                                        value="{{ $currency['name'] }}">{{ $currency['name'] }}</option>
                            @endforeach
                        </select>
                        <button
                            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4"
                            type="submit">
                            Open new Account
                        </button>
                    </form>
                </div>

                @foreach($accounts as $account)
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg p-6 m-4">
                        <div class="flex items-center justify-between">
                            <div class="text-lg font-medium">
                                <img src="{{ asset('images/card-logo2.jpg') }}" alt="Logo" width="40" height="40"
                                     class="inline-block align-middle mr-2">
                                @if($account->label)
                                    <span class="inline-block align-middle">{{ $account->label }}</span>
                                    <small class="inline-block align-middle"> ({{ $account->number }}) </small>
                                @else
                                    <span class="inline-block align-middle">{{ $account->number }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-lg font-medium">Owner : {{ $user }}</div>
                        <div class="text-lg font-medium">Balance
                            : {{ number_format($account->money / 100,2) }} {{ $account->currency }}</div>

                        <a href="/transactions/{{ $account->id }}">
                            <button
                                class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                                Account Transactions
                            </button>
                        </a>

                        <a href="/crypto-transactions/{{ $account->id }}">
                            <button
                                class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                                Crypto Transactions
                            </button>
                        </a>


                        <a href="/accounts/{{ $account->id }}/edit">
                            <button
                                class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                                Edit
                            </button>
                        </a>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
