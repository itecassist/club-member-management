<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('subscription_price_late_fees');
        Schema::create('subscription_price_late_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subscription_id')->index();
            $table->integer('days_after_due');
            $table->decimal('fee_amount', 14, 6);
            $table->unsignedBigInteger('tax_rate_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_price_late_fees');
    }
};