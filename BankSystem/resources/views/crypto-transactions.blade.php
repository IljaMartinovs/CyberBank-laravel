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

{{--<div class="w-full">--}}
{{--    <table class="mx-auto">--}}
{{--        <thead>--}}
{{--        <tr class="bg-gray-600 text-left font-bold text-white">--}}
{{--            <th class="text-sm font-semibold p-2 ">Number</th>--}}
{{--            <th class="text-sm font-semibold p-2 ">Symbol</th>--}}
{{--            <th class="text-sm font-semibold  p-2 ">Transaction Type</th>--}}
{{--            <th class="text-sm font-semibold  p-2 ">Amount</th>--}}
{{--            <th class="text-sm font-semibold  p-2 ">Price</th>--}}
{{--            <th class="text-sm font-semibold  p-2 ">Time</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach (array_reverse($transactions) as $transaction)--}}
{{--            <tr class="odd:bg-gray-100">--}}
{{--                <td class="p-2 border-t border-gray-600 text-left">{{ $transaction->number }}</td>--}}
{{--                <td class="p-2 border-t border-gray-600 text-left">{{ $transaction->symbol }}</td>--}}
{{--                <td class="p-2 border-t border-gray-600 text-left">{{ $transaction->trade }}</td>--}}
{{--                <td class="p-2 border-t border-gray-600 text-left">{{ $transaction->amount }}</td>--}}
{{--                <td class="p-2 border-t border-gray-600 text-left">{{ $transaction->price_per_one * $transaction->amount }}$</td>--}}
{{--                <td class="p-2 border-t border-gray-600 text-left">{{ $transaction->created_at }}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}

<form class="mb-4 text-center" action="" method="post">
    @csrf
    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
        <label for="account_number">&#8383; Crypto Symbol</label>
        <label for="symbol"></label><input type="text" class="form-control" id="symbol" name="symbol">
    </div>
    <button type="submit" class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md ml-auto">
        Filter
    </button>
    @error('symbol')
    <span class="text-red-500 text-sm"> {{ $message }}</span>
    @enderror
</form>

<div class="text-center">

</div>

<table class="table table-striped table-hover text-center">
    <thead>
    <tr>
        <th>Number</th>
        <th>Symbol</th>
        <th>Transaction Type</th>
        <th>Amount</th>
        <th>Price</th>
        <th>Time</th>
    </tr>
    </thead>
    <tbody>
    @foreach (array_reverse($transactions) as $transaction)
        <tr>
            <td>{{ $transaction->number }}</td>
            <td> {{ $transaction->symbol }}</td>
            <td>{{ $transaction->trade }}</td>
            <td>{{ $transaction->amount }}</td>
            <td>{{ $transaction->price_per_one * $transaction->amount }}$</td>
            <td>{{ $transaction->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>


</body>
</html>

@endsection
