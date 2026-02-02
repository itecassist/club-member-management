<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('organisations');
        Schema::create('organisations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('seo_name', 64)->unique();
            $table->string('email', 255);
            $table->string('phone', 255)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('website', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('free_trail')->default(true);
            $table->date('free_trail_end_date');
            $table->enum('billing_policy', ['debit_order','wallet','invoice'])->default('debit_order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisations');
    }
};