<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('organisation_configs');
        Schema::create('organisation_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->string('key', 100);
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisation_configs');
    }
};