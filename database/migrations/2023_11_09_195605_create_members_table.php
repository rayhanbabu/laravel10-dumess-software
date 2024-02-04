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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hall_id');
            $table->foreign('hall_id')->references('hall_id_info')->on('hallinfos')
                  ->restrictOnDelete()
                  ->cascadeOnUpdate();

            $table->string('phone')->unique();
            $table->string('registration')->unique();
            $table->string('email_verify')->nullable();
            $table->string('verify_time')->nullable();
            $table->string('email')->unique();
            $table->integer('member_status')->default(1);
            $table->string('email2');
            $table->string('password');
            $table->string('status')->nullable();
            $table->string('login_device')->nullable();
            $table->string('forget_code')->nullable();
            $table->string('forget_time')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('nid_front_image')->nullable();
            $table->string('nid_back_image')->nullable();
            $table->string('others_image')->nullable();
            $table->string('card')->unique();
            $table->date('birth_date')->nullable();
            $table->string('session')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();
            $table->string('file_name')->nullable();
            $table->string('admin_verify')->nullable();
            $table->string('dept')->nullable();
            $table->string('nation')->nullable();
            $table->string('religion')->nullable();
            $table->string('division')->nullable();
            $table->string('zila')->nullable();
            $table->text('upazila')->nullable();
            $table->integer('postcode')->nullable();
            $table->string('village')->nullable();
            $table->integer('security_money')->default(0);
            $table->integer('service_charge')->default(0);
            $table->integer('hostel_fee')->default(0);
            $table->string('old_card')->nullable();
            $table->integer('verify_month')->default(0);
            $table->integer('verify_year')->default(0);
            $table->string('verify_section')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('custom1')->nullable();
            $table->string('custom2')->nullable();
            $table->string('custom3')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
