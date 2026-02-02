<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('groups');
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->string('name', 255);
            $table->enum('type', ['family', 'corporate', 'club', 'committee', 'other'])->default('other');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('primary_admin_id')->nullable();
            $table->unsignedInteger('max_members')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
