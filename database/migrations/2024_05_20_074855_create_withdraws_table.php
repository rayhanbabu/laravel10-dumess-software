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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->string('hall_id');
            $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos');
            $table->string('bank_name');
            $table->string('bank_account_name');
            $table->string('bank_account');
            $table->string('bank_route');
            $table->string('withdraw_status')->default(0);
            $table->float('withdraw_amount');
            $table->float('current_balance')->default(0);
            $table->timestamp('withdraw_submited_time');
            $table->timestamp('withdraw_time')->nullable();
            $table->text('withdraw_type')->nullable();
            $table->integer('withdraw_year')->nullable();
            $table->integer('withdraw_month')->nullable();
            $table->text('withdraw_info')->nullable();
            $table->text('withdraw_info_update')->nullable();
            $table->text('image')->nullable();
            $table->text('updated_by')->nullable();
            $table->text('updated_by_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
