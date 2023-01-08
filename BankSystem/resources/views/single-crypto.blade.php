@extends('layouts.app')

@section('content')

    <div class="container-lg" style="margin:0  auto;">
        <div class="row mt-5">
            @foreach ($crypto as $cry)
                <div class="col-lg-4 col-md-4 col-sm-12 text-center mb-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <img width="32" src="{{ $cry->getLogoURL() }}" alt="logo" class="img-fluid mx-auto d-block">
                            <div class="'card-title">{{ $cry->getSymbols()}}</div>
                            <div class="'card-text">{{ $cry->getName()}}</div>
                            <div class="'card-title">price {{ $cry->getPrice()}}$</div>
                            <div class="'card-title">1h {{ $cry->getPercentChange1h()}}%</div>
                            <div class="'card-title">24h {{ $cry->getPercentChange24h()}}%</div>
                            <div class="'card-title">7d {{ $cry->getPercentChange7d()}}%</div>
                        </div>
                        <form class="mb-4" action="{{ route('crypto.buy', ['symbol' => $cry->getSymbols()]) }}" method="post">
                            @csrf
                            <label class="block font-bold mb-2 text-gray-700 text-lg">Amount to buy:</label>
                            <input  id="product" name="product" value="{{ $cry->getSymbols() }}" type="hidden"/>
                            <label for="quantity"></label><input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" id="quantity" name="quantity" step="0.001"/>
                            <button type="submit" style="filter: brightness(80%);" class="bg-green-500 hover:bg-green-700 text-black text-center py-2 px-4 rounded">Buy</button>
                        </form>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
