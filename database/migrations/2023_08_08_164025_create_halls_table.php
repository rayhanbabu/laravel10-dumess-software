<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('university_id');
            $table->foreign('university_id')->references('id')->on('univers');
            $table->string('hall_id');
            $table->string('hall');
            $table->string('image')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_username')->nullable();
            $table->string('others')->nullable();
            $table->string('category')->nullable();
            $table->string('password');
            $table->string('role');
            $table->string('login_device')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('status')->nullable();
            $table->string('login_code')->nullable();
            $table->string('login_time')->nullable();
            $table->string('forget_code')->nullable();
            $table->string('forget_time')->nullable();
            $table->string('level_registration')->nullable();
            $table->string('level_custom1')->nullable();
            $table->string('level_custom2')->nullable();
            $table->string('level_custom3')->nullable();
            $table->string('level_profile_image')->nullable();
            $table->string('level_file_image')->nullable();
            $table->string('frontend_link')->nullable();
            $table->string('comments')->nullable();
            $table->string('payment')->nullable();
            $table->string('bazar')->nullable();
            $table->string('meal')->nullable();
            $table->string('member')->nullable();
            $table->string('storage')->nullable();
            $table->string('access_number')->nullable();
            $table->string('others_access')->nullable();
            $table->string('application')->nullable();
            $table->string('application_verify')->nullable();
            $table->string('email_send_access')->nullable();
            $table->string('resign')->nullable();
            $table->string('refund_status')->nullable();
            $table->string('booking')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
