@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

{{--    @if(count($ownedCrypto) != 0)--}}
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
                    <td> {{ $owned->symbol }}</td>
                    <td>{{ $owned->amount }}</td>
                    <td>${{  number_format($owned->current_price_per_one * $owned->amount,2) }}</td>
                    <td>${{  number_format($owned->current_price_per_one,2) }}</td>
                    <td>${{  number_format($owned->price_per_one,2) }}</td>
                    <td>
    <span class="{{ ($owned->current_price_per_one - $owned->price_per_one) > 0 ? 'text-green-700' : 'text-red-700' }}">
        ${{  number_format(($owned->current_price_per_one - $owned->price_per_one) * $owned->amount ,2) }}
    </span>
                        <span class="{{ ($owned->current_price_per_one - $owned->price_per_one) > 0 ? 'text-green-700' : 'text-red-700' }}">
        %{{ number_format( ($owned->current_price_per_one - $owned->price_per_one) / $owned->price_per_one * 100 ,2) }}
    </span>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
{{--    @endif--}}

@endsection
