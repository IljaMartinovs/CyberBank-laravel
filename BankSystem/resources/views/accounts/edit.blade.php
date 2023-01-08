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

             <h4>
                 Edit -
                @if($account->label)
                     {{ $account->label }} (<small> {{ $account->number }}</small>)
                @else
                    {{ $account->number }}
                @endif
             </h4>
            <form method="post" action="{{ route('accounts.update', $account) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="label" class="sr-only">Label</label>
                    <input type="text" name="label" id="label" placeholder="label" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ $account->label }}">
                </div>

                <div>
                    <button type="submit">Update</button>
                </div>
            </form><br>
                <form method="post" action="{{ route('accounts.delete', $account) }}">
                    @csrf
                        <button type="submit">Delete</button>
                </form>
            <ul>

            </ul>
        </div>
    </div>
</div>

</body>
</html>

@endsection
