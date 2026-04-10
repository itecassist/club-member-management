<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('payment_methods');
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->string('name', 255);
            $table->string('type', 100);
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};