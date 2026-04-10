<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('invoices');
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->unsignedBigInteger('member_id')->index();
            $table->string('invoice_number', 100);
            $table->date('issue_date');
            $table->date('due_date');
            $table->enum('status', ['draft','sent','paid','overdue','cancelled']);
            $table->decimal('subtotal', 14, 6);
            $table->decimal('tax_total', 14, 6);
            $table->decimal('total', 14, 6);
            $table->char('currency_code', 3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};