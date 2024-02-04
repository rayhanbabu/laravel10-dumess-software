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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('hall_id');
            $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos');

            $table->unsignedBigInteger('booking_member_id');
            $table->foreign('booking_member_id')->references('id')->on('booking_members');

            $table->unsignedBigInteger('seat_id');
            $table->foreign('seat_id')->references('id')->on('seats');
             
            $table->integer('seat_amount')->default(0);
            $table->integer('service_amount')->default(0);
            $table->integer('total_amount')->default(0);

            $table->integer('amount1')->default(0);
            $table->integer('amount2')->default(0);
            $table->integer('amount3')->default(0);
            $table->integer('due_amount')->default(0);

            $table->integer('booking_status')->default(0);

            $table->timestamp('time1')->nullable(); 
            $table->timestamp('time2')->nullable(); 
            $table->timestamp('time3')->nullable();    

            $table->date('date1')->nullable();
            $table->date('date2')->nullable();
            $table->date('date3')->nullable();
            
            $table->string('type1')->nullable();
            $table->string('type2')->nullable();
            $table->string('type3')->nullable();
           
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
