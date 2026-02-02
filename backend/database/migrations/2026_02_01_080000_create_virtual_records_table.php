<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('virtual_records');
        Schema::create('virtual_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('virtual_form_id')->index();
            $table->string('recordable_type', 255);
            $table->unsignedBigInteger('recordable_id');
            $table->json('data');
            $table->index(['recordable_type', 'recordable_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('virtual_records');
    }
};