@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Code cards') }}</div>

                    <div class="card-body">
                        <ol>
                            @foreach ($codeCards as $codeCard)
                               {{ $loop->iteration }}. {{ $codeCard->code }}<br>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
