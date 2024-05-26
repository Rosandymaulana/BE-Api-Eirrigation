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
        Schema::create('irrigations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('district_id');
            $table->foreignUuid('sub_district_id');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('sub_district_id')->references('id')->on('sub_districts');
            $table->string('length');
            $table->string('width');
            $table->lineString('geom');
            $table->string('type');
            $table->string('name');
            $table->string('condition');
            $table->string('canal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irrigations');
    }
};
