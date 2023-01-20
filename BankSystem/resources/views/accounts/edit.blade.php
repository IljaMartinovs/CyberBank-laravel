@extends('layouts.app')

@section('content')
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

                    <div class=" bg-white rounded-lg overflow-hidden shadow-lg p-6 m-4">
                        <div class="flex items-center justify-between">
                            <div class="text-lg font-medium">
                                <img src="{{ asset('images/card-logo2.jpg') }}" alt="Logo" width="40" height="40" class="inline-block align-middle mr-2">
                                @if($account->label)
                                    <span class="inline-block align-middle">{{ $account->label }}</span>
                                    <small class="inline-block align-middle"> ({{ $account->number }}) </small>
                                @else
                                    <span class="inline-block align-middle">{{ $account->number }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-lg font-medium">Balance : {{ $account->getBalanceFormatted() }} {{ $account->currency }}</div>


                        <div class="text-lg font-medium">Update your label - </div>

                        <form method="post" action="{{ route('accounts.update', $account) }}" class="inline-block">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="label" class="sr-only">Label</label>
                                <input type="text" name="label" id="label" placeholder="label" class="bg-gray-100 border-2 w-5/6 p-2 rounded-lg text-sm" value="{{ $account->label }}">
                            </div>
                            <button class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md ">
                                Update
                            </button>
                        </form>


                        <div class="relative">
                            <div class="absolute bottom-0 right-0">
                                <form method="post" action="{{ route('accounts.delete', $account) }}" class="inline-block">
                                    @csrf
                                    <div class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md">
                                        <div class="text-center">
                                            <button class="fas fa-trash"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
        </div>
    </div>
</div>

</body>
</html>

@endsection
