<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('members');
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('organisation_id')->index();
            $table->string('title', 50)->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 255);
            $table->string('mobile_phone', 30);
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['female', 'male', 'other']);
            $table->string('member_number', 30)->nullable();
            $table->date('joined_at');
            $table->boolean('is_active')->default(true);
            $table->json('roles');
            $table->dateTime('last_login_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
