@extends('layouts.app')

@section('content')

    <script>
        $(function () {
            $(".datepicker").datepicker();
        });
    </script>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="text-center mx-auto my-4">
            <div class="bg-red-200 p-4 rounded-lg text-red-800">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="flex items-center">
        <form class="ml-20 text-center mt-3 mb-3" action="" method="post">
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

            <button type="submit"
                    class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md ml-auto">
                Filter
            </button>
        </form>
        <button type="submit"
                class="mt-7 ml-3 bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md ml-auto">
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

@endsection
