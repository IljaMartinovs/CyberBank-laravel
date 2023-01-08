<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'account_transactions';

    protected $fillable = [
        'user_id',
        'from_account',
        'to_account',
        'money',
        'currency',
        'description'
    ];
}
