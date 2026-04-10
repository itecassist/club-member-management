<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('account_balances');
        Schema::create('account_balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->string('holder_type', 255);
            $table->unsignedBigInteger('holder_id');
            $table->decimal('balance', 14, 6)->default(0.000000);
            $table->char('currency_code', 3)->default('GBP');
            $table->timestamp('last_transaction_at')->nullable();
            $table->index(['holder_type', 'holder_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('account_balances');
    }
};