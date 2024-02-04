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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('hall_id');
            $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos');
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members');
            $table->date('invoice_date');
            $table->integer('invoice_month');
            $table->integer('invoice_year');
            $table->string('invoice_section');
            $table->integer('pre_reserve_amount')->default(0);
            $table->integer('pre_refund')->default(0);
            $table->integer('pre_monthdue')->default(0);
            $table->integer('pre_last_meal')->default(0);
            $table->integer('pre_meeting_present')->default(0);
            $table->date('meal_start_date');
            $table->date('meal_end_date');
            $table->integer('friday')->default(0);
            $table->integer('feast')->default(0);
            $table->integer('employee')->default(0);
            $table->integer('welfare')->default(0);
            $table->integer('others')->default(0);
            $table->integer('security')->default(0);
            $table->integer('hostel_fee')->default(0);
            $table->integer('service_charge')->default(0);
            $table->integer('card_fee')->default(0);
            $table->integer('gass')->default(0);
            $table->integer('electricity')->default(0);
            $table->integer('tissue')->default(0);
            $table->integer('water')->default(0);
            $table->integer('wifi')->default(0);
            $table->integer('dirt')->default(0);
            $table->integer('section_day')->default(0);
            $table->integer('breakfast_rate')->default(0);
            $table->integer('lunch_rate')->default(0);
            $table->integer('dinner_rate')->default(0);
            $table->integer('breakfast_onmeal')->default(0);
            $table->integer('breakfast_offmeal')->default(0);
            $table->integer('breakfast_inmeal')->default(0);
            $table->integer('lunch_onmeal')->default(0);
            $table->integer('lunch_offmeal')->default(0);
            $table->integer('lunch_inmeal')->default(0);
            $table->integer('dinner_onmeal')->default(0);
            $table->integer('dinner_offmeal')->default(0);
            $table->integer('dinner_inmeal')->default(0);
            $table->integer('onmeal_amount')->default(0);
            $table->integer('inmeal_amount')->default(0);

            $table->integer('cur_meal_amount')->default(0);
            $table->integer('cur_total_amount')->default(0);
            $table->integer('payble_amount')->default(0);

            $table->integer('first_pay_mealon')->default(0);
            $table->integer('first_pay_mealamount')->default(0);
            $table->integer('first_others_amount')->default(0);
            $table->integer('second_pay_mealon')->default(0);
            $table->integer('second_pay_mealamount')->default(0);
            $table->integer('second_others_amount')->default(0);

            $table->integer('payble_amount1')->default(0);
            $table->integer('payment_status1')->default(0);
            $table->integer('payment_day1')->default(0);
            $table->timestamp('payment_time1')->nullable();
            $table->string('payment_type1')->nullable();

            $table->integer('payble_amount2')->default(0);
            $table->integer('payment_status2')->default(0);
            $table->integer('payment_day2')->default(0);
            $table->timestamp('payment_time2')->nullable();
            $table->string('payment_type2')->nullable();

          
            $table->integer('withdraw')->default(0);
            $table->string('withdraw_status')->default(0);
            $table->string('withdraw_type')->nullable();
            $table->integer('withdraw_day')->default(0);
            $table->timestamp('withdraw_time')->nullable();   


            $table->integer('refund_breakfast_rate')->default(0);
            $table->integer('refund_lunch_rate')->default(0);
            $table->integer('refund_dinner_rate')->default(0);

            $table->integer('offmeal_amount')->default(0);
            $table->integer('refund_feast')->default(0);
            $table->integer('refund_welfare')->default(0);
            $table->integer('refund_employee')->default(0);
            $table->integer('refund_others')->default(0);
            $table->integer('refund_friday')->default(0);
            $table->integer('refund_tissue')->default(0);
            $table->integer('refund_gass')->default(0);
            $table->integer('refund_electricity')->default(0);
            $table->integer('refund_water')->default(0);
            $table->integer('refund_wifi')->default(0);
            $table->integer('refund_dirt')->default(0);

            $table->integer('mealreducetk')->default(0);
            $table->integer('reserve_amount')->default(0); 
            $table->integer('total_refund')->default(0);
            $table->integer('first_payment_due')->default(0);
            $table->integer('second_payment_due')->default(0);
            $table->integer('total_due')->default(0);
            $table->integer('total_due')->default(0);

            
            
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
            $table->string('date21')->nullable();
            $table->string('date22')->nullable();
            $table->string('date23')->nullable();
            $table->string('date24')->nullable();
            $table->string('date20')->nullable();
            $table->string('date26')->nullable();
            $table->string('date27')->nullable();
            $table->string('date28')->nullable();
            $table->string('date29')->nullable();
            $table->string('date30')->nullable();
            $table->string('date25')->nullable();
            $table->string('date31')->nullable();
            $table->integer('b1')->default(0);
            $table->integer('b2')->default(0);
            $table->integer('b3')->default(0);
            $table->integer('b4')->default(0);
            $table->integer('b5')->default(0);
            $table->integer('b6')->default(0);
            $table->integer('b7')->default(0);
            $table->integer('b8')->default(0);
            $table->integer('b9')->default(0);
            $table->integer('b10')->default(0);
            $table->integer('b11')->default(0);
            $table->integer('b12')->default(0);
            $table->integer('b13')->default(0);
            $table->integer('b14')->default(0);
            $table->integer('b15')->default(0);
            $table->integer('b16')->default(0);
            $table->integer('b17')->default(0);
            $table->integer('b18')->default(0);
            $table->integer('b19')->default(0);
            $table->integer('b20')->default(0);
            $table->integer('b21')->default(0);
            $table->integer('b22')->default(0);
            $table->integer('b23')->default(0);
            $table->integer('b24')->default(0);
            $table->integer('b25')->default(0);
            $table->integer('b26')->default(0);
            $table->integer('b27')->default(0);
            $table->integer('b28')->default(0);
            $table->integer('b29')->default(0);
            $table->integer('b30')->default(0);
            $table->integer('b31')->default(0);

            $table->integer('l1')->default(0);
            $table->integer('l2')->default(0);
            $table->integer('l3')->default(0);
            $table->integer('l4')->default(0);
            $table->integer('l5')->default(0);
            $table->integer('l6')->default(0);
            $table->integer('l7')->default(0);
            $table->integer('l8')->default(0);
            $table->integer('l9')->default(0);
            $table->integer('l10')->default(0);
            $table->integer('l11')->default(0);
            $table->integer('l12')->default(0);
            $table->integer('l13')->default(0);
            $table->integer('l14')->default(0);
            $table->integer('l15')->default(0);
            $table->integer('l16')->default(0);
            $table->integer('l17')->default(0);
            $table->integer('l18')->default(0);
            $table->integer('l19')->default(0);
            $table->integer('l20')->default(0);
            $table->integer('l21')->default(0);
            $table->integer('l22')->default(0);
            $table->integer('l23')->default(0);
            $table->integer('l24')->default(0);
            $table->integer('l25')->default(0);
            $table->integer('l26')->default(0);
            $table->integer('l27')->default(0);
            $table->integer('l28')->default(0);
            $table->integer('l29')->default(0);
            $table->integer('l30')->default(0);
            $table->integer('l31')->default(0);

            $table->integer('d1')->default(0);
            $table->integer('d2')->default(0);
            $table->integer('d3')->default(0);
            $table->integer('d4')->default(0);
            $table->integer('d5')->default(0);
            $table->integer('d6')->default(0);
            $table->integer('d7')->default(0);
            $table->integer('d8')->default(0);
            $table->integer('d9')->default(0);
            $table->integer('d10')->default(0);
            $table->integer('d11')->default(0);
            $table->integer('d12')->default(0);
            $table->integer('d13')->default(0);
            $table->integer('d14')->default(0);
            $table->integer('d15')->default(0);
            $table->integer('d16')->default(0);
            $table->integer('d17')->default(0);
            $table->integer('d18')->default(0);
            $table->integer('d19')->default(0);
            $table->integer('d20')->default(0);
            $table->integer('d21')->default(0);
            $table->integer('d22')->default(0);
            $table->integer('d23')->default(0);
            $table->integer('d24')->default(0);
            $table->integer('d25')->default(0);
            $table->integer('d26')->default(0);
            $table->integer('d27')->default(0);
            $table->integer('d28')->default(0);
            $table->integer('d29')->default(0);
            $table->integer('d30')->default(0);
            $table->integer('d31')->default(0);

            $table->integer('meeting_present')->default(0);
            $table->integer('meeting_penalty')->default(0);

            $table->integer('friday1')->default(0);
            $table->integer('friday2')->default(0);
            $table->integer('friday3')->default(0);
            $table->integer('friday4')->default(0);
            $table->integer('friday5')->default(0);
            $table->integer('fridayt1')->default(0);
            $table->integer('fridayt2')->default(0);
            $table->integer('fridayt3')->default(0);
            $table->integer('fridayt4')->default(0);
            $table->integer('fridayt5')->default(0);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
