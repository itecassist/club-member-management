<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('subscription_auto_renewals');
        Schema::create('subscription_auto_renewals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subscription_id')->index();
            $table->boolean('enable_auto_renewal')->default(false);
            $table->boolean('apply_to_all_subscription_fees');
            $table->boolean('payment_method');
            $table->integer('order_expiry_days');
            $table->enum('should_have_form', ['no','select_existing','create_new'])->default('no');
            $table->unsignedBigInteger('virtual_form_id')->nullable();
            $table->string('message', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_auto_renewals');
    }
};