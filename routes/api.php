<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\BookingMemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
       return $request->user();
     });

     Route::get('/hall_information',[MemberController::class,'hall_information']);
     Route::get('/custom1_information/{hall_id}',[MemberController::class,'custom1_information']);
     Route::post('/application_memebr',[MemberController::class,'application_memebr']);
     Route::get('/member/email_verify/{emailmd5}',[MemberController::class,'member_email_verify']);

     Route::post('/contact_form',[FeedbackController::class,'contact_form']);



    Route::get('forget_password/{email}',[MemberController::class, 'forget_password']);


    Route::middleware('ForgetToken')->group(function(){
        Route::get('forget_code/{forget_code}', [MemberController::class, 'forget_code']);
        Route::post('confirm_password', [MemberController::class, 'confirm_password']);
    });


   Route::post('member/login',[MemberController::class,'member_login']);

   Route::middleware('MemberToken')->group(function(){
          Route::get('profile_view', [MemberController::class,'profile_view']);
          Route::post('profile_update', [MemberController::class,'profile_update']);
          Route::post('password_update', [MemberController::class,'password_update']);
          Route::post('member_feedback/{category}', [FeedbackController::class,'member_feedback']);
          Route::get('member_feedback_view/{category}', [FeedbackController::class,'member_feedback_view']);
          Route::get('member_feedback_delete/{id}', [FeedbackController::class,'member_feedback_delete']);

          Route::get('invoice_view', [MemberController::class,'invoice_view']);
          Route::get('cur_invoice_view', [MemberController::class,'cur_invoice_view']);
          Route::post('meal_off_on', [MemberController::class,'meal_off_on']);
          Route::get('bazar/{date}', [MemberController::class,'bazar_date']);

 
    });


     //website booking
      Route::get('/{hall_id}/hall_view',[BookingMemberController::class,'hall_view']);
      Route::get('/{hall_id}/building_view',[BookingMemberController::class,'building_view']);
      Route::get('/{hall_id}/{building_id}/room_view',[BookingMemberController::class,'room_view']);
      Route::get('/{hall_id}/{room_id}/room_details',[BookingMemberController::class,'room_details']);
      Route::get('/{hall_id}/{room_id}/seat_details',[BookingMemberController::class,'seat_details']);
      Route::get('/{hall_id}/booking_member_login/{phone}', [BookingMemberController::class,'booking_member_login']);
      Route::get('/{hall_id}/Booking_VerifyLogin/{phone}/{otp}',[BookingMemberController::class, 'Booking_VerifyLogin']);


      Route::middleware('BookingMemberToken')->group(function(){

         Route::post('/{hall_id}/booking_seat',[BookingMemberController::class,'booking_seat']);
         Route::get('/{hall_id}/booking_view',[BookingMemberController::class,'booking_view']);
         Route::get('/{hall_id}/booking_profile_view',[BookingMemberController::class,'booking_profile_view']);
         Route::get('/{hall_id}/booking_cencel/{booking_id}',[BookingMemberController::class,'booking_cencel']);

      });
     



