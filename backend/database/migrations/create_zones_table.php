<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('zones');
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id')->index();
            $table->string('name', 255);
            $table->string('code', 32);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};