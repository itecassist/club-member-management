<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('group_members');
        Schema::create('group_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->index();
            $table->unsignedBigInteger('member_id')->index();
            $table->enum('role', ['admin', 'member'])->default('member');
            $table->boolean('is_primary')->default(false);
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
            $table->index(['group_id', 'member_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};
