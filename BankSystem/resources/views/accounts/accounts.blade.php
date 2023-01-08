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

            <form method="post" action="/accounts">
                @csrf
                <label for="currency">Currency:</label>
                <select id="currency" name="currency">
                    @foreach ($currencies as $code => $currency)
                        <option value="{{ $currency['name'] }}">{{ $currency['name'] }}</option>
                    @endforeach
                </select>
                <input type="submit" value="Create">
            </form>
            <br><br>
            <ul>
                <a href="/balance-transfer">Transfer</a><br>
                @foreach($accounts as $account)

                    <li>Number : @if($account->label)
                            {{ $account->label }} (<small> {{ $account->number }}</small>)
                        @else
                            {{ $account->number }}
                        @endif </li>
                    <li>Balance : {{ $account->getBalanceFormatted() }} {{ $account->currency }}</li>
                    <a href="/accounts/{{ $account->id }}/edit">Edit</a><br>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</body>
</html>
@endsection
