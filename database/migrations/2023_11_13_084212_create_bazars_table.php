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
        Schema::create('bazars', function (Blueprint $table) {
            $table->id();
            $table->string('hall_id');
                $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos');
            $table->unsignedBigInteger('product_id');
                $table->foreign('product_id')->references('id')->on('products');
            $table->date('date')->nullable();
            $table->integer('bazar_day');
            $table->integer('bazar_month');
            $table->integer('bazar_year');
            $table->string('bazar_section');
            $table->string('category');
            $table->string('unit')->nullable();
            $table->decimal('qty',8,3);
            $table->decimal('price',8,2);
            $table->decimal('total',8,2);
            $table->string('bazar_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bazars');
    }
};
