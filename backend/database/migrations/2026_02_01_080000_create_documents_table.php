<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('documents');
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('documentable_type', 255);
            $table->unsignedBigInteger('documentable_id');
            $table->string('name', 255);
            $table->string('path', 255);
            $table->string('type', 100);
            $table->integer('size');
            $table->index(['documentable_type', 'documentable_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};