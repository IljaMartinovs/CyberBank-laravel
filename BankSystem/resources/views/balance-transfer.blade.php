@extends('layouts.app')

@section('content')
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resources/css/transactions.css">
    <title>Document</title>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h2> Transfer Balance </h2>
            <form method="post" action="{{ route('balance-transfer.transfer') }}">
                @csrf
                <div class="mb-4">
                    <label for="account" class="block text-gray-700 text-sm font-bold mb-2">Account</label>
                    <select name="from_account" id="account" class="form-select">
                        @foreach($accounts as $account)
                        <option value="{{ $account->id }}">
                            {{ $account->number }} <small>{{ $account->getBalanceFormatted() }} {{ $account->currency }}</small>

                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="to_account" class="block text-gray-700 text-sm font-bold mb-2">To Account</label>
                    <input type="text" name="to_account" id="to_account" class="form-input" placeholder="Account Number">
                    <div class="m-2 p-2">
                        @error('to_account')
                            <span class="text-red-500 text-sm"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="label" class="sr-only">Amount</label>
                    <label for="amount"></label><input type="text" name="amount" id="amount" placeholder="amount" class="bg-gray-100 border-2">
                    <div class="m-2 p-2">
                        @error('amount')
                        <span class="text-red-500 text-sm"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <?php $codeNumber = rand(1,7) ?>
                    <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code</label>
                    <input type="text" name="code" id="code" class="form-input" placeholder="Enter code {{ $codeNumber }}">
                    <input type="hidden" name="code_number" value="{{ $codeNumber }}">
                    <div class="m-2 p-2">
                        @error('code')
                        <span class="text-red-500 text-sm"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div>
                    <button type="submit">Transfer</button>
                </div>
            </form><br><br>
            @foreach (array_reverse($transactions) as $transaction)
                <div class="card">
                    <div class="card-header">
                        {{ $transaction->description }} {{number_format($transaction->money / 100,2)}} {{$transaction->currency}} to {{ $transaction->to_account }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $transaction->created_at }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

</body>
</html>

@endsection

