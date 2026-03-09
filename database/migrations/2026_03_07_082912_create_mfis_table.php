<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mfis', function (Blueprint $table) {
            $table->id();
            $table->integer('sl_no')->nullable();
            $table->string('license_number_of_mfi')->nullable();
            $table->string('licence_no')->nullable();
            $table->string('name_of_mfi')->nullable();
            $table->text('name_without_abbreviation')->nullable();
            $table->string('sort_name')->nullable();
            $table->string('t_50')->nullable();
            $table->string('cdf')->nullable();
            $table->string('t_100')->nullable();
            $table->string('pksf')->nullable();
            $table->text('current_address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->integer('no_of_branches')->nullable();
            $table->bigInteger('number_of_employees_total')->nullable();
            $table->bigInteger('number_of_clients_total')->nullable();
            $table->bigInteger('number_of_borrowers_total')->nullable();
            $table->decimal('savings_bdt', 20, 2)->nullable();
            $table->decimal('loan_disbursement_bdt', 20, 2)->nullable();
            $table->decimal('loan_outstanding_bdt', 20, 2)->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('dhaka_area')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mfis');
    }
};