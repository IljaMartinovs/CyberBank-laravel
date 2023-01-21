<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_transactions', function (Blueprint $table) {
            $table->string('sender_name')->after('id');
            $table->string('received_name')->after('from_account');
        });
    }

    public function down(): void
    {
        Schema::table('account_transactions_rows', function (Blueprint $table) {
            $table->string('sender_name')->after('id');
            $table->string('received_name')->after('from_account');
        });
    }
};
