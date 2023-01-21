@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="text-center mx-auto my-4">
            <div class="bg-green-200 p-4 rounded-lg text-green-800">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="text-center mx-auto my-4">
            <div class="bg-red-200 p-4 rounded-lg text-red-800">
                <ul class="list-inside list-disc">
                    <li>{{ session('error') }}</li>

                </ul>
            </div>
        </div>
    @endif

    <div class="container-lg text-center mr-20 mt-3">
        <div class="">
            @foreach ($crypto as $cry)
                <div class="">
                    <div class="card w-1/2 flex items-center">
                        <div class="card-body">
                            <img width="32" src="{{ $cry->getLogoURL() }}" alt="logo" class="img-fluid mx-auto d-block">
                            <div class="'card-text">{{ $cry->getSymbols()}} - {{ $cry->getName()}}</div>
                            <div class="'card-title">Rank #{{ $cry->getId()}} </div>
                            <div class="'card-title">Price : {{ number_format($cry->getPrice(),2)}}$</div>
                            <div class="'card-title">1h change : {{ number_format($cry->getPercentChange1h(),2)}}%</div>
                            <div class="'card-title">24h change : {{ number_format($cry->getPercentChange24h(),2)}}%
                            </div>
                            <div class="'card-title">7d change : {{ number_format($cry->getPercentChange7d(),2)}}%</div>
                        </div>

                        <form class="mb-4"
                              action="{{ route('cryptoTransaction', ['action' => 'buy', 'symbol' => $cry->getSymbols()]) }}"
                              method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="account" class="block text-gray-700 text-sm font-bold mb-2">Account</label>
                                <select name="from_account" id="account" class="form-select">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->number }}">
                                            @if ($account->label)
                                                {{ $account->label }}
                                                <small>{{ number_format($account->money / 100,2) }} {{ $account->currency }}</small>
                                            @else
                                                {{ $account->number }}
                                                <small>{{ number_format($account->money / 100,2) }} {{ $account->currency }}</small>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="block font-bold mb-2 text-gray-700 text-lg">Amount to buy:</label>
                            <input id="product" name="product" value="{{ $cry->getSymbols() }}" type="hidden"/>
                            <label for="quantity"></label><input
                                class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="quantity" name="amount_buy"/>
                            <button type="submit" style="filter: brightness(80%);"
                                    class="bg-green-500 hover:bg-green-700 text-black text-center py-2 px-4 rounded">Buy
                            </button>
                            <div class="m-2 p-2">
                                @error('amount_buy')
                                <span class="text-red-500 text-sm"> {{ $message }}</span>
                                @enderror
                            </div>
                        </form>

                        <form class="mb-4"
                              action="{{ route('cryptoTransaction', ['action' => 'sell', 'symbol' => $cry->getSymbols()]) }}"
                              method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="account" class="block text-gray-700 text-sm font-bold mb-2">Account</label>
                                <select name="from_account" id="account" class="form-select">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->number }}">
                                            @if ($account->label)
                                                {{ $account->label }}
                                                <small>{{ number_format($account->money / 100,2) }} {{ $account->currency }}</small>
                                            @else
                                                {{ $account->number }}
                                                <small>{{ number_format($account->money / 100,2) }} {{ $account->currency }}</small>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="block font-bold mb-2 text-gray-700 text-lg">Amount to sell:</label>
                            <input id="product" name="product" value="{{ $cry->getSymbols() }}" type="hidden"/>
                            <label for="quantity"></label><input
                                class="shadow appearance-none border rounded w-1/2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="quantity" name="amount_sell"/>
                            <button type="submit" style="filter: brightness(80%);"
                                    class="bg-red-500 hover:bg-red-700 text-black text-center py-2 px-4 rounded">Sell
                            </button>
                            <div class="m-2 p-2">
                                @error('amount_sell')
                                <span class="text-red-500 text-sm"> {{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        @endforeach
    </div>
@endsection
