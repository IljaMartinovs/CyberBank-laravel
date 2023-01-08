{{--@extends('cryptoLayouts.main')--}}
@extends('layouts.app')

@section('content')

    <form class="flex items-center border-b border-teal-500 py-2" action="" method="get">
        <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" name="crypto" type="text" placeholder="Search...">
        <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" >
            Search
        </button>
    </form>



<div class="container-lg" style="margin:0  auto;">
    <div class="row mt-5">
        @foreach ($crypto as $cry)
        <div class="col-lg-4 col-md-4 col-sm-12 text-center mb-3">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <img width="32" src="{{ $cry->getLogoURL() }}" alt="logo" class="img-fluid mx-auto d-block">
                    <div class="'card-title"><a href="crypto/buy/{{$cry->getSymbols()}}">{{ $cry->getSymbols()}}</a></div>
                    <div class="'card-text">{{ $cry->getName()}}</div>
                    <div class="'card-title">price {{ $cry->getPrice()}}$</div>
                    <div class="'card-title">1h {{ $cry->getPercentChange1h()}}%</div>
                    <div class="'card-title">24h {{ $cry->getPercentChange24h()}}%</div>
                    <div class="'card-title">7d {{ $cry->getPercentChange7d()}}%</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
