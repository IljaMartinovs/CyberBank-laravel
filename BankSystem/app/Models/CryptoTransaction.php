<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $table = 'users_crypto_transactions';

    protected $fillable = [
        'user_id',
        'number',
        'symbol',
        'amount',
        'price_per_one',
        'trade'
    ];
}
