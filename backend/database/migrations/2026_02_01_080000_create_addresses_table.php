<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('addresses');
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('addressable_type', 255);
            $table->unsignedBigInteger('addressable_id');
            $table->string('line_1', 64);
            $table->string('line_2', 64)->nullable();
            $table->string('line_3', 64)->nullable();
            $table->string('line_4', 64)->nullable();
            $table->string('postcode', 20);
            $table->unsignedBigInteger('country_id')->index();
            $table->unsignedBigInteger('zone_id')->index();
            $table->index(['addressable_type', 'addressable_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};