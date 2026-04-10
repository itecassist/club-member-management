<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('lookups');
        Schema::create('lookups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 255);
            $table->string('key', 255);
            $table->string('value', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lookups');
    }
};