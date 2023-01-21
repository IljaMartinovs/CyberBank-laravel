@extends('layouts.app')

@section('content')

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

@endsection
