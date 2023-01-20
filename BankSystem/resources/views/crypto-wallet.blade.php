@extends('layouts.app')

@section('content')
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(count($ownedCrypto) != 0)
    <table class="table table-striped table-hover text-center">
        <thead>
        <tr>
            <th>&#128179;Wallet</th>
            <th>&#129689;Coin</th>
            <th>&#128176;Amount</th>
            <th>&#128176;Current value per amount</th>
            <th>&#128176;Current value per one</th>
            <th>&#128176;Bought value per one</th>
            <th>📈Profit/Loss</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($ownedCrypto as $owned)
            <tr>
                <td>{{ $owned->number }}</td>
                <td > {{ $owned->symbol }}</td>
                <td >{{ $owned->amount }}</td>
                <td >${{ $owned->current_price_per_one * $owned->amount }}</td>
                <td >{{ $owned->current_price_per_one }}</td>
                <td >{{ $owned->price_per_one }}</td>
                <td >{{ number_format($owned->current_price_per_one - $owned->price_per_one, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</body>
</html>
@endsection
