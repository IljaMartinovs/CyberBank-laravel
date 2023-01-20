@extends('layouts.app')

@section('content')
{{--    <!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <link rel="stylesheet" href="resources/css/transactions.css">--}}
{{--    <title>Document</title>--}}
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker();
        } );
    </script>
{{--</head>--}}
{{--<body>--}}

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{--<form class="mb-4" action="" method="post">--}}
{{--    @csrf--}}
{{--    <div class="form-group">--}}
{{--        <label for="account_number">Account Number</label>--}}
{{--        <input type="text" class="form-control" id="account_number" name="account_number">--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        <label for="recipient">Recipient</label>--}}
{{--        <input type="text" class="form-control" id="recipient" name="recipient">--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        <label for="start_date">Start Date</label>--}}
{{--        <input type="text" class="form-control datepicker" id="start_date" name="start_date">--}}
{{--    </div>--}}
{{--    <div class="form-group">--}}
{{--        <label for="end_date">End Date</label>--}}
{{--        <input type="text" class="form-control datepicker" id="end_date" name="end_date">--}}
{{--    </div>--}}
{{--    <button type="submit" class="btn btn-primary">Filter</button>--}}
{{--</form>--}}


<form class="mb-4 text-center" action="" method="post">
    @csrf
    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
        <label for="account_number">&#128179;Account Number</label>
        <input type="text" class="form-control" id="account_number" name="account_number">
    </div>
    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
        <label for="recipient">&#128104;Recipient</label>
        <input type="text" class="form-control" id="recipient" name="recipient">
    </div>
    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
        <label for="start_date">&#128197;Start Date</label>
        <input type="text" class="form-control datepicker" id="start_date" name="start_date">
    </div>
    <div class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
        <label for="end_date">&#128197;End Date</label>
        <input type="text" class="form-control datepicker" id="end_date" name="end_date">
    </div>

    <button type="submit" class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md ml-auto">
        Filter
    </button>
</form>
<div class="flex flex-wrap">
    <button class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4 ml-auto">
        <a href="/transactions/{{ $account->id }}">Refresh</a>
    </button>
</div>

<table class="table table-striped table-hover text-center">
    <thead>
    <tr>
        <th>Date</th>
        <th>Account number</th>
        <th>Information</th>
        <th>Details</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach (array_reverse($transactions) as $transaction)
        <tr>
            <td>{{ $transaction->created_at }}</td>
            <td> {{ $transaction->to_account }}</td>
            <td> {{ $transaction->details }}</td>
            <td>{{ $transaction->description }} <br> {{ $transaction->received_name }} </td>
            <td class="{{ $transaction->description === 'SENT' ? 'text-danger' : 'text-success'}}">
                {{ $transaction->description === 'SENT' ? '-' : '+'}} {{number_format($transaction->money / 100,2)}} {{$transaction->currency}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>



{{--</body>--}}
{{--</html>--}}

@endsection
