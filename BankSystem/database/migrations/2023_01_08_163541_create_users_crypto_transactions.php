<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_crypto_transactions');
    }
};
