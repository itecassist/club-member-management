<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('organisation_config_financials');
        Schema::create('organisation_config_financials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->char('currency', 1);
            $table->boolean('vat_status')->default(true);
            $table->string('vat_number', 255);
            $table->string('financial_year_end', 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisation_config_financials');
    }
};