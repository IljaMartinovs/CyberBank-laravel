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
        Schema::create('owned_crypto_currencies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('number');
            $table->string('symbol');
            $table->double('amount');
            $table->double('price_per_one');
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
        Schema::dropIfExists('owned_crypto_currencies');
    }
};
