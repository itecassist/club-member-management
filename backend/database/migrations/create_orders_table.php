<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('orders');
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('member_id')->nullable()->index();
            $table->unsignedBigInteger('organisation_id')->index();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('payment_method', 255);
            $table->string('payment_reference', 255)->nullable();
            $table->enum('order_status', ['order_placed','payment_received','payment_problem','cancelled','cancelled_before_payment','cancelled_pending_payment','cancelled_refund_scheduled','cancelled_refund_due','cancelled_not_refunded','cancelled_refunded','partially_cancelled','no_payment_required','completed','partial_payment','refunded','payment_transfer']);
            $table->date('date_finished');
            $table->string('comments', 255)->nullable();
            $table->char('currency_code', 3);
            $table->decimal('currency_value', 14, 6)->nullable();
            $table->decimal('tax_total', 14, 6);
            $table->decimal('total', 14, 6);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};