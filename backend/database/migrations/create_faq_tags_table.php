<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('faq_tags');
        Schema::create('faq_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('faq_id')->index();
            $table->string('tag', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_tags');
    }
};