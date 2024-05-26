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
        Schema::create('report_list', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('segment_id');
            $table->foreignUuid('user_id');
            $table->foreignUuid('status_id');
            $table->foreign('segment_id')->references('id')->on('segments');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('status');
            $table->string('no_ticket');
            $table->string('note');
            $table->string('maintenance_by');
            $table->string('survey_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {    
        Schema::dropIfExists('report_list');
    }
};
