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
        Schema::create('hallinfos', function (Blueprint $table) {
             $table->id();
             $table->string('hall_id_info')->unique();
             $table->string('hall_name')->nullable();
             $table->date('cur_date');
             $table->integer('cur_year');
             $table->integer('cur_month');
             $table->string('cur_section');
             $table->date('pre_date')->nullable();
             $table->integer('pre_year')->nullable();
             $table->integer('pre_month')->nullable();
             $table->string('pre_section')->nullable();
             $table->integer('meeting_amount')->default(0);
             $table->integer('booking_status')->default(0);
             $table->integer('refund_status')->default(0);
             $table->integer('max_meal_off')->default(0);
             $table->integer('last_meal_off')->default(0);
             $table->integer('first_meal_off')->default(0);
             $table->date('meal_start_date')->nullable();
             $table->date('meal_end_date')->nullable();
             $table->integer('add_minute')->default(0);
             $table->integer('section_day')->default(0);
             $table->integer('pre_section_last_day')->default(0);
             $table->integer('unpaid_day')->default(0);
             $table->integer('card_fee')->default(0);
             $table->integer('security_money')->default(0);
             $table->integer('service_charge')->default(0);
            
             $table->integer('breakfast_rate')->default(0);
             $table->integer('lunch_rate')->default(0);
             $table->integer('dinner_rate')->default(0);

             $table->integer('breakfast_status')->default(1);
             $table->integer('lunch_status')->default(1);
             $table->integer('dinner_status')->default(1);


             $table->integer('friday')->default(0);
             $table->integer('feast')->default(0);
             $table->integer('welfare')->default(0);
             $table->integer('others')->default(0);
             $table->integer('employee')->default(0);
             $table->integer('water')->default(0);
             $table->integer('wifi')->default(0);
             $table->integer('dirt')->default(0);
             $table->integer('gass')->default(0);
             $table->integer('electricity')->default(0);
             $table->integer('tissue')->default(0);

 
             $table->boolean('first_payment_meal')->default(0);
             $table->boolean('fridayf')->default(0);
             $table->boolean('feastf')->default(0);
             $table->boolean('welfaref')->default(0);
             $table->boolean('othersf')->default(0);
             $table->boolean('employeef')->default(0);
             $table->boolean('waterf')->default(0);
             $table->boolean('wifif')->default(0);
             $table->boolean('dirtf')->default(0);
             $table->boolean('gassf')->default(0);
             $table->boolean('electricityf')->default(0);
             $table->boolean('tissuef')->default(0);
             
             $table->integer('refund_breakfast_rate')->default(0);
             $table->integer('refund_lunch_rate')->default(0);
             $table->integer('refund_dinner_rate')->default(0);

             $table->integer('refund_friday')->default(0);
             $table->integer('retund_feast')->default(0);
             $table->integer('refund_welfare')->default(0);
             $table->integer('refund_others')->default(0);
             $table->integer('refund_employee')->default(0);
             $table->integer('refund_water')->default(0);
             $table->integer('refund_wifi')->default(0);
             $table->integer('refund_dirt')->default(0);
             $table->integer('refund_gass')->default(0);
             $table->integer('refund_electricity')->default(0);
             $table->integer('refund_tissue')->default(0);

           
            $table->string('feast_day')->nullable();
            $table->string('friday1')->nullable();
            $table->string('friday2')->nullable();
            $table->string('friday3')->nullable();
            $table->string('friday4')->nullable();
            $table->string('friday5')->nullable();

            $table->integer('friday1t')->default(0);
            $table->integer('friday2t')->default(0);
            $table->integer('friday3t')->default(0);
            $table->integer('friday4t')->default(0);
            $table->integer('friday5t')->default(0);
            $table->string('date1')->nullable();
            $table->string('date2')->nullable();
            $table->string('date3')->nullable();
            $table->string('date4')->nullable();
            $table->string('date5')->nullable();
            $table->string('date6')->nullable();
            $table->string('date7')->nullable();
            $table->string('date8')->nullable();
            $table->string('date9')->nullable();
            $table->string('date10')->nullable();
            $table->string('date11')->nullable();
            $table->string('date12')->nullable();
            $table->string('date13')->nullable();
            $table->string('date14')->nullable();
            $table->string('date15')->nullable();
            $table->string('date16')->nullable();
            $table->string('date17')->nullable();
            $table->string('date18')->nullable();
            $table->string('date19')->nullable();
            $table->string('date20')->nullable();
            $table->string('date21')->nullable();
            $table->string('date22')->nullable();
            $table->string('date23')->nullable();
            $table->string('date24')->nullable();
            $table->string('date25')->nullable();
            $table->string('date26')->nullable();
            $table->string('date27')->nullable();
            $table->string('date28')->nullable();
            $table->string('date29')->nullable();
            $table->string('date30')->nullable();
            $table->string('date31')->nullable();
            $table->string('date32')->nullable();
            $table->timestamp('update_time')->nullable();
            $table->date('refresh_date')->nullable();
            $table->integer('refresh_no')->default(0);
            $table->string('web_link')->nullable();
            $table->string('email_send')->nullable();

         

            

             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hallinfos');
    }
};
