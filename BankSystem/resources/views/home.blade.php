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


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User info') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            {{ __('You are logged in - ')  }}  {{ Auth::user()->name }}<br>
                            {{ __('Your email is - ')  }}  {{ Auth::user()->email }}<br>
                            {{ __('Created at - ')  }}  {{ Auth::user()->created_at }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
