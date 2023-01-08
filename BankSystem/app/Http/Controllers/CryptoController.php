<?php

namespace App\Http\Controllers;

use App\Models\CryptoCurrency;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CryptoController extends Controller
{
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(['base_uri' => 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/']);
    }

    public function buyCrypto(Request $request, $symbol)
    {
        dd('buyCrypto called with symbol: ' . $symbol . 'Amount: ' . $request['quantity']);
    }

    public function getCrypto(?string $symbol=null): View
    {
        $symbols =  ['BTC', 'ETH', 'XRP', 'DOT', 'DOGE', 'LTC', 'BCH', 'ADA', 'BNB', 'SRM', 'LUNA', 'MATIC'];
        $response = $this->fetch($symbols, $symbol);
        $cryptoCurrencies = collect();
        $info = $this->fetch($symbols, $symbol,'info');

        foreach ($response->data as $currency) {
            $currency->logo = $info->data->{$currency->symbol}->logo;
            $cryptoCurrencies->add(new CryptoCurrency(
                $currency->symbol,
                $currency->name,
                $currency->quote->USD->price,
                $currency->quote->USD->percent_change_1h,
                $currency->quote->USD->percent_change_24h,
                $currency->quote->USD->percent_change_7d,
                $currency->logo
            ));
        }
        if(count($cryptoCurrencies->all()) == 1)
            return view('single-crypto', ['crypto' => $cryptoCurrencies->all()]);
        return view('index', ['crypto' => $cryptoCurrencies->all()]);
    }

    private function fetch(array $symbols, ?string $single,string $url='quotes/latest'): \stdClass
    {
        if ($single != null)
            $symbols = $single;
        else
            $symbols = implode(',', $symbols);

        $response = $this->httpClient->request('GET', $url, [
            'headers' => [
                'Accepts' => 'application/json',
                'X-CMC_PRO_API_KEY' => env('API_KEY')
            ],
            'query' => [
                'symbol' => $symbols,
            ]
        ]);
        return  json_decode($response->getBody()->getContents());
    }
}
