<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeCard extends Model
{
    use HasFactory;

    protected $table = 'users_code_cards';

    protected $fillable = [
        'code',
        'code_number'
    ];
}
