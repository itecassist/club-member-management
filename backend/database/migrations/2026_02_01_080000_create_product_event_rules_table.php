<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('product_event_rules');
        Schema::create('product_event_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index();
            $table->string('event_name', 255);
            $table->string('action', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_event_rules');
    }
};