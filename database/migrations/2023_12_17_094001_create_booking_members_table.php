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
        Schema::create('booking_members', function (Blueprint $table) {
              $table->id();
              $table->string('hall_id');
              $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos');
              $table->string('name')->nullable();
              $table->string('phone');
              $table->string('occupation')->nullable();
              $table->string('address')->nullable();
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_members');
    }
};
