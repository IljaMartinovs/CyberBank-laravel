@extends('layouts.app')

@section('content')

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

    <div class="text-center">
        <h1 class="text-3xl font-medium">Welcome to Cyber Bank</h1>
    </div>

@endsection

