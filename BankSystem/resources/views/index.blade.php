@extends('layouts.app')

@section('content')

    <form class="w-1/6 mx-auto border-b py-2 flex items-center" action="" method="get">
        <input
            class="text-xl appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
            name="crypto" type="text" placeholder="Search...">
        <button
            class="bg-gray-600 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
            Search
        </button>
    </form>

    <div class="w-full">
        <table class="w-full ">
            <thead>
            <tr class="bg-gray-600 hover:bg-gray-600 text-center text-white font-medium py-2 px-4 rounded-md mx-auto my-4">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Change (1h)</th>
                <th class="px-4 py-2">Change (24h)</th>
                <th class="px-4 py-2">Change (7d)</th>
            </tr>
            </thead>
            <tbody>
            @php
                usort($crypto, function ($a, $b) {
                    return $a->getId() <=> $b->getId();
                });
            @endphp
            @foreach ($crypto as $cry)
                <tr class="border-t text-center">
                    <td class="px-4 py-2">{{ $cry->getId() }}</td>
                    <td class="px-4 py-2 ">
                        <img width="32" src="{{ $cry->getLogoURL() }}" alt="logo"
                             class="img-fluid mx-auto d-block inline-block">
                        <a href="?crypto={{$cry->getSymbols()}}" class="inline-block">
                            <b>{{ $cry->getName() }}</b>
                            <small>{{ $cry->getSymbols() }}</small>
                        </a>
                    </td>
                    <td class="px-4 py-2">{{ number_format($cry->getPrice(), 2) }}$</td>
                    <td class="px-4 py-2">

                    <span
                        class="@if($cry->getPercentChange1h() > 0) fas fa-solid fa-angle-up @else fas fa-solid fa-angle-down @endif">
                    </span>
                        <span class="@if($cry->getPercentChange1h() > 0) text-success @else text-danger @endif">
                        {{  number_format($cry->getPercentChange1h(), 2) }}%
                     </span>
                    </td>

                    <td class="px-4 py-2">
                    <span
                        class="@if($cry->getPercentChange24h() > 0) fas fa-solid fa-angle-up @else fas fa-solid fa-angle-down @endif">
                    </span>
                        <span class="@if($cry->getPercentChange24h() > 0) text-success @else text-danger @endif">
                        {{  number_format($cry->getPercentChange24h(), 2) }}%
                     </span>
                    </td>
                    <td class="px-4 py-2">
                    <span
                        class="@if($cry->getPercentChange7d() > 0) fas fa-solid fa-angle-up @else fas fa-solid fa-angle-down @endif">
                    </span>
                        <span class="@if($cry->getPercentChange7d() > 0) text-success @else text-danger @endif">
                        {{  number_format($cry->getPercentChange7d(), 2) }}%
                     </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
