@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="text-center mx-auto my-4">
        <div class="bg-green-200 p-4 rounded-lg text-green-800">
            {{ session('success') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="text-center mx-auto my-4">
        <div class="bg-red-200 p-4 rounded-lg text-red-800">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-auto">

            <form method="post" action="{{ route('balance-transfer.transfer') }}">
                @csrf
                <div class="mb-4">
                    <label for="account" class="form-group d-inline-block mr-3 font-medium text-xl text-gray-600">From
                        Account</label>
                    <select name="from_account" id="account" class="form-select">
                        @foreach($accounts as $account)
                            <option value="{{ $account->id }}">
                                {{ $account->number }}
                                <small>{{ number_format($account->money / 100,2) }} {{ $account->currency }}</small>
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-center form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                    <label for="to_account">To Account Number</label>
                    <input type="text" class="form-control" id="to_account" name="to_account"
                           placeholder="Account Number">
                    <div class="m-2 p-2">
                    </div>
                </div>

                <div class="text-center form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                    <label for="amount">Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount" placeholder="amount">
                    <div class="m-2 p-2">
                    </div>
                </div>

                <div class="text-center form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                    <label for="amount">Details</label>
                    <input type="text" class="form-control" id="details" name="details" placeholder="details">
                </div>

                <div class="text-center form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                    <label for="password">Password</label>
                    <input type="password" class="form-control datepicker" id="password" name="password"
                           placeholder="********">
                    <div class="m-2 p-2">
                    </div>
                </div>

                <div class="text-center form-group d-inline-block mr-3 font-medium text-xl text-gray-600">
                    <?php $codeNumber = rand(1, 12) ?>
                    <label for="code">Code</label>
                    <input type="text" class="form-control datepicker" id="code" name="code"
                           placeholder="Enter code {{ $codeNumber }}">
                    <input type="hidden" name="code_number" value="{{ $codeNumber }}">
                    <div class="m-2 p-2">
                    </div>
                </div>

                <button type="submit"
                        class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                    Transfer
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

