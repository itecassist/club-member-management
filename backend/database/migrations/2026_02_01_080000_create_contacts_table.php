<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('contacts');
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contactable_type', 255);
            $table->unsignedBigInteger('contactable_id');
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('mobile_phone', 255)->nullable();
            $table->string('relation', 255)->nullable();
            $table->index(['contactable_type', 'contactable_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};