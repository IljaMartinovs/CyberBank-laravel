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

    <div class="container-lg tex" style="margin:0  auto;">
        <div class="row mt-5">
            @foreach ($crypto as $cry)
                <div class="col-lg-4 col-md-4 col-sm-12 text-center mb-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <img width="32" src="{{ $cry->getLogoURL() }}" alt="logo" class="img-fluid mx-auto d-block">
                            <div class="'card-title">#{{ $cry->getId()}}</div>
                            <div class="'card-title">{{ $cry->getSymbols()}}</div>
                            <div class="'card-text">{{ $cry->getName()}}</div>
                            <div class="'card-title">price {{ $cry->getPrice()}}$</div>
                            <div class="'card-title">1h {{ $cry->getPercentChange1h()}}%</div>
                            <div class="'card-title">24h {{ $cry->getPercentChange24h()}}%</div>
                            <div class="'card-title">7d {{ $cry->getPercentChange7d()}}%</div>
                        </div>

{{--                        <form class="mb-4" action="{{ route('crypto.buy', ['symbol' => $cry->getSymbols()]) }}" method="post">--}}

                        <form class="mb-4" action="/crypto/{{ $cry->getSymbols() }}/buy" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="account" class="block text-gray-700 text-sm font-bold mb-2">Account</label>
                                <select name="from_account" id="account" class="form-select">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->number }}">
                                            @if ($account->label)
                                            {{ $account->label }}  <small>{{ $account->getBalanceFormatted() }} {{ $account->currency }}</small>
                                            @else
                                                {{ $account->number }}  <small>{{ $account->getBalanceFormatted() }} {{ $account->currency }}</small>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="block font-bold mb-2 text-gray-700 text-lg">Amount to buy:</label>
                            <input  id="product" name="product" value="{{ $cry->getSymbols() }}" type="hidden"/>
                            <label for="quantity"></label><input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  id="quantity" name="quantity_buy"/>
                            <button type="submit" style="filter: brightness(80%);" class="bg-green-500 hover:bg-green-700 text-black text-center py-2 px-4 rounded">Buy</button>
                            <div class="m-2 p-2">
                                @error('quantity_buy')
                                <span class="text-red-500 text-sm"> {{ $message }}</span>
                                @enderror
                            </div>
                        </form>

                        <form class="mb-4" action="/crypto/{{ $cry->getSymbols() }}/sell" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="account" class="block text-gray-700 text-sm font-bold mb-2">Account</label>
                                <select name="from_account" id="account" class="form-select">
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->number }}">
{{--                                            {{ $account->label }} {{ $account->number }}{{ $account->getBalanceFormatted() }} {{ $account->currency }}--}}
                                            @if ($account->label)
                                                {{ $account->label }}  <small>{{ $account->getBalanceFormatted() }} {{ $account->currency }}</small>
                                            @else
                                                {{ $account->number }}  <small>{{ $account->getBalanceFormatted() }} {{ $account->currency }}</small>
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="block font-bold mb-2 text-gray-700 text-lg">Amount to sell:</label>
                            <input  id="product" name="product" value="{{ $cry->getSymbols() }}" type="hidden"/>
                            <label for="quantity"></label><input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  id="quantity" name="quantity_sell"/>
                            <button type="submit" style="filter: brightness(80%);" class="bg-red-500 hover:bg-red-700 text-black text-center py-2 px-4 rounded">Sell</button>
                            <div class="m-2 p-2">
                                @error('quantity_sell')
                                <span class="text-red-500 text-sm"> {{ $message }}</span>
                                @enderror
                            </div>
                        </form>



                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
