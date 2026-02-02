<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('articles');
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type');
            $table->string('title', 255);
            $table->unsignedBigInteger('article_category_id')->index();
            $table->string('page_title', 255);
            $table->string('seo_name', 255)->unique();
            $table->text('content');
            $table->text('summary');
            $table->string('seo_description', 255);
            $table->boolean('featured');
            $table->boolean('live')->default(true);
            $table->boolean('category_live');
            $table->integer('popularity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};