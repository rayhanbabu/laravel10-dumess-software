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
        Schema::create('managerlists', function (Blueprint $table) {
            $table->id();
            $table->string('hall_id');
            $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos');

            $table->integer('invoice_month');
            $table->integer('invoice_year');
            $table->string('invoice_section');
            $table->string('name');
            $table->string('phone');
            $table->string('role');
            $table->string('registration')->nullable();
            $table->string('department')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managerlists');
    }
};
