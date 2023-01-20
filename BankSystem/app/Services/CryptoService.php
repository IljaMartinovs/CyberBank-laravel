<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Crypto;
use App\Models\CryptoCurrency;
use App\Models\CryptoTransaction;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use stdClass;

class CryptoService
{
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client(['base_uri' => 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/']);
    }

    public function updatePrice(Collection $collection): void
    {
        foreach ($collection->all() as $crypto) {
            $symbol = $crypto->getSymbols();
            $price = $crypto->getPrice();
            Crypto::where('user_id', auth()->id())
                ->where('symbol', $symbol)
                ->update(['current_price_per_one' => $price]);
        }
    }

    public function getCrypto($symbol, $symbols): Collection
    {

        $response = $this->fetch($symbols, $symbol);
        $cryptoCurrencies = collect();
        $info = $this->fetch($symbols, $symbol, 'info');

        foreach ($response->data as $currency) {
            $currency->logo = $info->data->{$currency->symbol}->logo;
            $cryptoCurrencies->add(new CryptoCurrency(
                $currency->id,
                $currency->symbol,
                $currency->name,
                $currency->quote->USD->price,
                $currency->quote->USD->percent_change_1h,
                $currency->quote->USD->percent_change_24h,
                $currency->quote->USD->percent_change_7d,
                $currency->logo
            ));
        }
        return $cryptoCurrencies;
    }

    public function buyCrypto(int $userId, string $userAccount, int $money, string $number, string $symbol, float $amount, ?float $rate, ?string $currency): RedirectResponse
    {
        $user = Account::where('user_id', $userId)->where('number', $userAccount)->firstOrFail();

        $response = $this->fetch([], $symbol);
        $actualPrice = $response->data->$symbol->quote->USD->price;
        $userPrice = $actualPrice * $amount;
        $trade = 'bought';




        if ($userPrice > $money)
            return redirect()->back()->with('error', "Transaction Declined. Not Enough Balance.");

        $crypto = Crypto::firstOrNew(['user_id' => $userId, 'number' => $userAccount, 'symbol' => $symbol]);
        if($crypto->exists){
            $crypto->amount += $amount;
            $crypto->price_per_one = ($crypto->price_per_one*$crypto->amount + $actualPrice*$amount)/($crypto->amount + $amount);
        }else{
            $crypto->user_id = $userId;
            $crypto->number = $number;
            $crypto->symbol = $symbol;
            $crypto->amount = $amount;
            $crypto->price_per_one = $actualPrice;
            $crypto->current_price_per_one = $actualPrice;
            $crypto->trade = 'owned';
        }
        $crypto->save();

        $this->saveTransaction($userId, $number, $symbol, $amount, $actualPrice, $trade);

        $userPrice *= $rate;
        $user->money -= intval($userPrice * 100);
        $user->save();

        return redirect()->back()->with('success', "you bought $amount of $symbol for $userPrice$currency");
    }

    public function sellCrypto(int $userId, string $userAccount, string $number, string $symbol, float $amount, ?float $rate, ?string $currency): RedirectResponse
    {
        $user = Account::where('user_id', $userId)->where('number', $userAccount)->firstOrFail();

        $crypto = Crypto::where('user_id', $userId)
            ->where('number', $number)
            ->where('symbol', $symbol)
            ->where('trade', 'owned')
            ->first();

        if (!$crypto) {
            return redirect()->back()->with('error', "You don't have any $symbol to sell");
        }

        if ($crypto->amount < $amount) {
            return redirect()->back()->with('error', "You don't have enough $symbol to sell");
        }

        $response = $this->fetch([], $symbol);
        $actualPrice = $response->data->$symbol->quote->USD->price;
        $userPrice = $actualPrice * $amount;

        $crypto->amount -= $amount;
        $trade = 'sold';

        if ($crypto->amount == 0)
            $crypto->delete();
        else
            $crypto->save();

        $this->saveTransaction($userId, $number, $symbol, $amount, $actualPrice, $trade);

        $userPrice *= $rate;
        $user->money += intval($userPrice * 100);
        $user->save();

        return redirect()->back()->with('success', "you sold $amount of $symbol for $userPrice$currency");
    }

    private function fetch(array $symbols, ?string $single, string $url = 'quotes/latest'): stdClass
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
        return json_decode($response->getBody()->getContents());
    }

    private function saveTransaction($userId, $number, $symbol, $amount, $actualPrice, $trade): void
    {
        CryptoTransaction::create([
            'user_id' => $userId,
            'number' => $number,
            'symbol' => $symbol,
            'amount' => $amount,
            'price_per_one' => $actualPrice,
            'trade' => $trade
        ]);
    }
}
