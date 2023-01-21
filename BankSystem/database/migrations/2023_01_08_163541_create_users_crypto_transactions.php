<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('number');
            $table->string('symbol');
            $table->float('amount');
            $table->float('price_per_one');
            $table->string('trade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_crypto_transactions');
    }
};
