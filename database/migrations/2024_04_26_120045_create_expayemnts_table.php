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
        Schema::create('expayemnts', function (Blueprint $table) {
            $table->id();
            $table->string('hall_id');
            $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos');
            $table->integer('cur_year');
            $table->integer('cur_month');
            $table->string('cur_section');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expayemnts');
    }
};
