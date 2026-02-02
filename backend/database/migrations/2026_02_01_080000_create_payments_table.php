<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('payments');
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->unsignedBigInteger('member_id')->index();
            $table->unsignedBigInteger('invoice_id')->nullable()->index();
            $table->date('payment_date');
            $table->decimal('amount', 14, 6);
            $table->string('payment_method', 100);
            $table->string('reference', 255)->nullable();
            $table->enum('status', ['pending','completed','failed','refunded']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};