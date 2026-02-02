<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('product_recurring_rules');
        Schema::create('product_recurring_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index();
            $table->string('interval', 50);
            $table->integer('frequency');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_recurring_rules');
    }
};