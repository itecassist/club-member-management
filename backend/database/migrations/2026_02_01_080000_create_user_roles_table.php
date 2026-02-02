<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('user_roles');
        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('role_id')->index();
            $table->unsignedBigInteger('organisation_id')->nullable();
            $table->index(['user_id', 'role_id', 'organisation_id']);
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};