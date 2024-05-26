<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dss_analytic_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('report_list_id');
            $table->foreign('report_list_id')->references('id')->on('report_list');
            $table->float('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
