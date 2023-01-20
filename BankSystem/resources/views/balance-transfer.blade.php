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

{{--@if (session('success'))--}}
{{--    <div class="alert alert-success">--}}
{{--        {{ session('success') }}--}}
{{--    </div>--}}
{{--@endif--}}

{{--@if ($errors->any())--}}
{{--    <div class="alert alert-danger">--}}
{{--        <ul>--}}
{{--            @foreach ($errors->all() as $error)--}}
{{--                <li>{{ $error }}</li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-auto">

                <form method="post" action="{{ route('balance-transfer.transfer') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="account" class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">From Account</label>
                        <select name="from_account" id="account" class="form-select">
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->number }}
                                    <small>{{ $account->getBalanceFormatted() }} {{ $account->currency }}</small>
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                        <label for="to_account">To Account Number</label>
                        <input type="text" class="form-control" id="to_account" name="to_account" placeholder="Account Number">
                        <div class="m-2 p-2">
                            @error('to_account')
                            <span class="text-red-500 text-sm"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" placeholder="amount">
                        <div class="m-2 p-2">
                            @error('amount')
                            <span class="text-red-500 text-sm"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                        <label for="amount">Details</label>
                        <input type="text" class="form-control" id="details" name="details" placeholder="details">
                    </div>

                    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                        <label for="password">Password</label>
                        <input type="password" class="form-control datepicker" id="password" name="password" placeholder="********">
                        <div class="m-2 p-2">
                            @error('password')
                            <span class="text-red-500 text-sm"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                            <?php $codeNumber = rand(1, 12) ?>
                        <label for="code">Code</label>
                        <input type="text" class="form-control datepicker" id="code" name="code" placeholder="Enter code {{ $codeNumber }}">
                        <input type="hidden" name="code_number" value="{{ $codeNumber }}">
                        <div class="m-2 p-2">
                            @error('code')
                            <span class="text-red-500 text-sm"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                        Transfer
                    </button>

{{--                    <div class="mb-4">--}}
{{--                        <label for="to_account" class="block text-gray-700 text-sm font-bold mb-2">To Account</label>--}}
{{--                        <input type="text" name="to_account" id="to_account" class="form-input"--}}
{{--                               placeholder="Account Number">--}}
{{--                        <div class="m-2 p-2">--}}
{{--                            @error('to_account')--}}
{{--                            <span class="text-red-500 text-sm"> {{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4">--}}
{{--                        <label for="label" class="sr-only">Amount</label>--}}
{{--                        <label for="amount"></label><input type="text" name="amount" id="amount" placeholder="amount"--}}
{{--                                                           class="bg-gray-100 border-2">--}}
{{--                        <div class="m-2 p-2">--}}
{{--                            @error('amount')--}}
{{--                            <span class="text-red-500 text-sm"> {{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4">--}}
{{--                        <label for="label" class="sr-only">Password</label>--}}
{{--                        <label for="password"></label><input type="password" name="password" id="password"--}}
{{--                                                             placeholder="********" class="bg-gray-100 border-2">--}}
{{--                        <div class="m-2 p-2">--}}
{{--                            @error('password')--}}
{{--                            <span class="text-red-500 text-sm"> {{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4">--}}
{{--                            <?php $codeNumber = rand(1, 7) ?>--}}
{{--                        <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Code</label>--}}
{{--                        <input type="text" name="code" id="code" class="form-input"--}}
{{--                               placeholder="Enter code {{ $codeNumber }}">--}}
{{--                        <input type="hidden" name="code_number" value="{{ $codeNumber }}">--}}
{{--                        <div class="m-2 p-2">--}}
{{--                            @error('code')--}}
{{--                            <span class="text-red-500 text-sm"> {{ $message }}</span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <button type="submit">Transfer</button>--}}
{{--                    </div>--}}
                </form>
        </div>
    </div>
</div>

</body>
</html>

@endsection

