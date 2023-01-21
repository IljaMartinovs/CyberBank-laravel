<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_transactions', function (Blueprint $table) {
            $table->string('details')->after('currency');
        });
    }

    public function down(): void
    {
        Schema::table('accounts_transactions_details', function (Blueprint $table) {
            $table->string('details')->after('currency');
        });
    }
};
