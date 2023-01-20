<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{
    use HasFactory;

    protected $table = 'owned_crypto_currencies';

    protected $fillable = [
        'user_id',
        'number',
        'symbol',
        'amount',
        'price_per_one',
        'current_price_per_one',
        'trade'
    ];
}
