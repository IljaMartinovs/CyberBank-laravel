@extends('layouts.app')

@section('content')

<div class="bg-white rounded-lg p-4">
    <div class="text-lg font-medium text-center mb-2">Code Card</div>
    <div class="flex flex-wrap -mx-2">
        @foreach ($codeCards as $codeCard)
            <div class="w-1/3 px-2 mb-4">
                <div class="bg-gray-200 rounded-lg p-4 text-center">
                    <div class="text-xl font-medium bold">{{ $loop->iteration }}</div>
                    <div class="text-base font-medium">{{ $codeCard->code }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
