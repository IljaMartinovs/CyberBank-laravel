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
        'sender_name',
        'from_account',
        'received_name',
        'to_account',
        'money',
        'currency',
        'details',
        'description'
    ];
}
