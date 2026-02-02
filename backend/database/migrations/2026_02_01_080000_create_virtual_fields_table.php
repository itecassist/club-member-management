<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('virtual_fields');
        Schema::create('virtual_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('virtual_form_id')->index();
            $table->string('name', 255);
            $table->string('label', 255);
            $table->string('type', 100);
            $table->boolean('required')->default(false);
            $table->json('options')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('virtual_fields');
    }
};