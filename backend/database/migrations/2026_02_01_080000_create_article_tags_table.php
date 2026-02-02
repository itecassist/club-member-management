<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('article_tags');
        Schema::create('article_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('article_id')->index();
            $table->string('tag', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_tags');
    }
};