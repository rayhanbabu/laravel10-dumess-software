<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MaintainController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\UniverController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BazarController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HallinfoController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ExpayemntController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\ManagerlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::get('locale/{locale}',function($locale){
         Session::put('locale',$locale);
         return redirect()->back();
    });


     //Mainatin Panel
     Route::get('/maintain/login',[MaintainController::class,'login'])->middleware('MaintainTokenExist');
     Route::post('maintain/login-insert',[MaintainController::class,'login_insert']);
     Route::post('/maintain/login-verify',[MaintainController::class,'login_verify']);
     Route::get('maintain/forget',[MaintainController::class,'forget']); 
     Route::post('maintain/forget',[MaintainController::class,'forgetemail']); 
     Route::post('maintain/forgetcode',[MaintainController::class,'forgetcode']); 
     Route::post('maintain/confirmpass',[MaintainController::class,'confirmpass']);
     
   
     Route::middleware('MaintainToken')->group(function(){
          
          Route::get('/maintain/dashboard',[MaintainController::class,'dashboard']);
          Route::get('/maintain/logout',[MaintainController::class,'logout']);

          Route::get('maintain/password',[MaintainController::class,'passwordview']);
          Route::post('maintain/password',[MaintainController::class,'passwordupdate']);

          //Universty route
          Route::get('maintain/univer-view',[UniverController::class,'univer_view']);
          Route::post('/univer/store',[UniverController::class,'store']);
          Route::get('/univer/fetchAll',[UniverController::class,'fetchAll']);
          Route::get('/univer/edit',[UniverController::class,'edit']);
          Route::post('/univer/update',[UniverController::class,'update']);
          Route::delete('/univer/delete',[UniverController::class,'delete']);
          Route::post('/maintain/import',[UniverController::class,'import']);
          Route::post('/maintain/export',[UniverController::class,'export']);
          Route::post('/maintain/dompdf',[UniverController::class,'dompdf']);
          Route::post('/maintain/jsprint',[UniverController::class,'jsprint']);

          Route::post('/maintain/member_import',[MaintainController::class,'member_import']);
          Route::post('/maintain/member_export',[MaintainController::class,'member_export']);

          //Hall  create
          Route::get('/maintain/hall_view',[HallController::class,'hall_view']);
          Route::get('/maintain/hall_fetch',[HallController::class,'fetch']);
          Route::get('/maintain/hall/fetch_data',[HallController::class,'fetch_data']);
          Route::post('/maintain/hall_store',[HallController::class,'store']);
          Route::get('/maintain/hall_edit',[HallController::class,'hall_edit']);
          Route::post('/maintain/hall_update',[HallController::class,'hall_update']);
          Route::delete('/maintain/hall_delete',[HallController::class,'hall_delete']);


            //Withdraw 
       
        Route::get('/maintain/withdraw/',[WithdrawController::class,'withdraw_index']);
        Route::get('/maintain/withdraw_fetch/',[WithdrawController::class,'withdraw_fetch']);
        Route::get('/maintain/withdraw/fetch_data/',[WithdrawController::class,'withdraw_fetch_data']);
        Route::post('/maintain/withdraw/',[WithdrawController::class,'withdraw_add']);
        Route::get('/maintain/withdraw/{operator}/{status}/{id}', [WithdrawController::class,'withdraw_status']);
        Route::post('/maintain/withdraw_update',[WithdrawController::class,'withdraw_update']); 
      
          Route::middleware('SupperAdminToken')->group(function(){
              Route::get('/maintain/text',[UniverController::class,'text']);
              Route::get('text/create',[UniverController::class,'text_create']);
              Route::post('/text/store',[UniverController::class,'text_store']);
              Route::get('/text/show/{id}',[UniverController::class,'text_show']);
              Route::get('/text/edit/{id}',[UniverController::class,'text_edit']);
              Route::post('/text/update/{id}',[UniverController::class,'text_update']);
              Route::get('/text/delete/{id}',[UniverController::class,'text_destroy']);
                
              //maintain people add
              Route::get('maintain/maintainview',[MaintainController::class,'maintainview']);
              Route::post('/maintain/store',[MaintainController::class,'store']);
              Route::get('/maintain/fetchAll',[MaintainController::class,'fetchAll']);
              Route::get('/maintain/edit',[MaintainController::class,'edit']);
              Route::post('/maintain/update',[MaintainController::class,'update']);
        });

     });

      //Manager Panel
      Route::get('/manager/login',[ManagerController::class,'login'])->middleware('ManagerTokenExist');
      Route::post('manager/login-insert',[ManagerController::class,'login_insert']);
      Route::post('/manager/login-verify',[ManagerController::class,'login_verify']);
      Route::get('manager/forget',[ManagerController::class,'forget']); 
      Route::post('manager/forget',[ManagerController::class,'forgetemail']); 
      Route::post('manager/forgetcode',[ManagerController::class,'forgetcode']); 
      Route::post('manager/confirmpass',[ManagerController::class,'confirmpass']);


     Route::middleware('ManagerToken')->group(function(){
         Route::get('/manager/dashboard',[ManagerController::class,'dashboard']);
         Route::get('/manager/logout',[ManagerController::class,'logout']);
         Route::get('manager/password',[ManagerController::class,'passwordview']);
         Route::post('manager/password',[ManagerController::class,'passwordupdate']);

        //Sction Info
        Route::get('/manager/sectioninfo', [InvoiceController::class,'section_view']);
        Route::get('/manager/section_fetch', [InvoiceController::class,'section_fetch']);
        Route::get('/manager/section/fetch_data', [InvoiceController::class,'section_fetch_data']);

        //Payment Link Info
        Route::get('/manager/payment_link', [InvoiceController::class,'payment_link_view']);
        Route::get('/manager/payment_link_fetch', [InvoiceController::class,'payment_link_fetch']);
        Route::get('/manager/payment_link/fetch_data', [InvoiceController::class,'payment_link_fetch_data']);

         //Module Summary Info
         Route::get('/manager/module_summary', [InvoiceController::class,'module_summary_view']);
       
        //Route::post('/manager/invoice_create', [InvoiceController::class,'invoice_create']);
        Route::get('/manager/section_view/{id}', [InvoiceController::class,'section_view_id']);
        Route::get('/manager/section_update', [InvoiceController::class,'section_update']);


        
         //members
         Route::get('/manager/member/{member_status}', [ManagerController::class, 'member']);
         Route::get('/manager/member_fetch/{member_status}', [ManagerController::class, 'member_fetch']);
         Route::get('/manager/member_view/{id}', [ManagerController::class, 'member_view']);
         Route::get('/manager/member/{member_status}/fetch_data', [ManagerController::class, 'member_fetch_data']);
       
         //Meeting Fee
         Route::get('/manager/meeting', [ManagerController::class, 'meeting']);
         Route::get('/manager/meeting/{session}', [ManagerController::class, 'meeting_view']);
         Route::post('/manager/meeting-update', [ManagerController::class, 'meeting_update']);

         //Payment 
         Route::get('/manager/payment/{invoice_status}', [InvoiceController::class, 'payment_view']);
         Route::get('/manager/payment_view/{id}', [InvoiceController::class, 'payment_view_all']);
         Route::get('/manager/payment_fetch/{invoice_status}', [InvoiceController::class, 'payment_fetch']);
         Route::get('/manager/payment/{invoice_status}/fetch_data', [InvoiceController::class, 'payment_fetch_data']);
         Route::get('/manager/payment1_view/{id}', [InvoiceController::class, 'payment1_view']);

        //meal
        Route::get('/manager/mealsheet', [InvoiceController::class, 'mealsheet_view']);
        Route::get('/manager/mealsheet_fetch', [InvoiceController::class, 'mealsheet_fetch']);
        Route::get('/manager/mealsheet/fetch_data', [InvoiceController::class, 'mealsheet_fetch_data']);

        //bazar
        Route::get('/manager/bazar/',[BazarController::class, 'index']);
       
        Route::get('/manager/bazar/fetch_data', [BazarController::class, 'fetch_data']);

        //withdraw View
        Route::get('/manager/withdraw/',[WithdrawController::class,'manager_withdraw_index']);
        Route::get('/manager/withdraw_fetch/',[WithdrawController::class,'manager_withdraw_fetch']);
        Route::get('/manager/withdraw/fetch_data/',[WithdrawController::class,'manager_withdraw_fetch_data']);


       //Extra Payment
       Route::get('/manager/extra_payment',[ExpayemntController::class, 'index']);
       Route::post('/manager/extra_payment',[ExpayemntController::class, 'store']);
       Route::get('/manager/extra_payment_fetch', [ExpayemntController::class, 'fetch']);
       Route::get('/manager/extra_payment/fetch_data', [ExpayemntController::class, 'fetch_data']);
       Route::get('/manager/extra_payment_edit/{id}', [ExpayemntController::class, 'edit']);
       Route::post('/manager/extra_payment_update/{id}', [ExpayemntController::class, 'update']);
       Route::delete('/manager/extra_payment_delete/{id}', [ExpayemntController::class, 'destroy']);

       Route::middleware('AdminToken')->group(function(){
           Route::get('/manager/information_update',[ManagerController::class,'information_update']);
           Route::get('/manager/information_update_view/{id}',[ManagerController::class,'information_update_view']);
           Route::post('/manager/information_update_submit',[ManagerController::class,'information_update_submit']);

          
           Route::get('/manager/new_invoice_create',[ManagerController::class,'invoice_create']);
           Route::get('/manager/mealon_update',[ManagerController::class,'mealon_update']);
           Route::post('/manager/daywise_mealupdate',[ManagerController::class,'daywise_mealupdate']);
           Route::post('/manager/invoice_all_delete',[ManagerController::class,'invoice_all_delete']);
          
         
          
       
         });


         Route::middleware('AdminAuditorToken')->group(function(){

            //Manager  add and access
            Route::get('manager/manager_access',[ManagerController::class,'manager_access']);
            Route::post('/manager/store',[ManagerController::class,'store']);
            Route::get('/manager/fetchAll',[ManagerController::class,'fetchAll']);
            Route::get('/manager/edit',[ManagerController::class,'edit']);
            Route::post('/manager/update',[ManagerController::class,'update']);
            Route::delete('/manager/manager_delete',[ManagerController::class,'manager_delete']);

            //Presvous Section  Due , Refund, Reserve Update
            Route::post('/manager/section_update_id', [InvoiceController::class,'section_update_id']);

          });

      

     

       Route::middleware('MealToken')->group(function(){    
               //MealSheet Info
               Route::get('/manager/mealsheet_view/{id}', [InvoiceController::class, 'mealsheet_view_id']);
               Route::post('manager/mealupdate', [InvoiceController::class, 'mealupdate']);    

        }); 


        Route::middleware('PaymentToken')->group(function(){
               //Payment Info
               Route::post('/manager/payment1_update', [InvoiceController::class, 'payment1_update']);
               Route::post('/manager/payment2_update', [InvoiceController::class, 'payment2_update']);
               Route::post('/manager/withdraw_update', [InvoiceController::class, 'withdraw_update']);
               Route::get('/manager/payment_show/{id}', [InvoiceController::class, 'payment_show']);
               Route::get('/manager/ex_payment/{invoice_status}', [InvoiceController::class, 'ex_payment_view']);
               Route::get('/manager/ex_payment_view/{id}', [InvoiceController::class, 'ex_payment_view_all']);
               Route::get('/manager/ex_payment_fetch/{invoice_status}', [InvoiceController::class, 'ex_payment_fetch']);
               Route::get('/manager/ex_payment/{invoice_status}/fetch_data', [InvoiceController::class, 'ex_payment_fetch_data']);
               Route::post('/manager/member_block', [InvoiceController::class, 'member_block']);
      
          });   


       Route::middleware('ApplicationToken')->group(function(){
            //Application 
            Route::get('/manager/app/{category}', [AppController::class, 'index']);
            Route::post('/manager/app', [AppController::class, 'store']);
            Route::get('/manager/app_fetch/{category}', [AppController::class, 'fetch']);
            Route::get('/manager/app/{category}/fetch_data', [AppController::class, 'fetch_data']);
            Route::get('/manager/app_edit/{id}', [AppController::class, 'edit']);
            Route::post('/manager/app_update/{id}', [AppController::class, 'update']);
            Route::delete('/manager/app_delete/{id}', [AppController::class, 'destroy']);
       });


        Route::middleware('BazarToken')->group(function(){
             //product
             Route::get('/manager/product', [ProductController::class, 'index']);
             Route::post('/manager/product', [ProductController::class, 'store']);
             Route::get('/manager/product_fetch', [ProductController::class, 'fetch']);
             Route::get('/manager/product/fetch_data', [ProductController::class, 'fetch_data']);
             Route::get('/manager/product_edit/{id}', [ProductController::class, 'edit']);
             Route::post('/manager/product_update/{id}', [ProductController::class, 'update']);
             Route::delete('/manager/product_delete/{id}', [ProductController::class, 'destroy']);

             //Bazar
             Route::post('/manager/bazar',[BazarController::class, 'store']);
             Route::get('/manager/bazar_fetch', [BazarController::class, 'fetch']);
             Route::get('/manager/bazar_edit/{id}', [BazarController::class, 'edit']);
             Route::post('/manager/bazar_update/{id}', [BazarController::class, 'update']);
             Route::delete('/manager/bazar_delete/{id}', [BazarController::class, 'destroy']);
       });


          Route::middleware('MemberaccessToken')->group(function(){
             //members access
             Route::get('/manager/member/{operator}/{status}/{id}', [ManagerController::class, 'memberstatus']);
          });

          Route::middleware('MemberEditToken')->group(function(){
               Route::post('/manager/member_update', [ManagerController::class, 'member_update']);
          });


          //feesback/Resign
          Route::get('/manager/feedback',[ManagerController::class,'feedback']);
          Route::get('/manager/resign',[ManagerController::class,'resignview']);


          Route::middleware('ResignToken')->group(function(){
               Route::post('/manager/feedback/{id}',[ManagerController::class,'feedback_delete']);
               Route::post('/manager/resignmember/{id}',[ManagerController::class,'resign_delete']);
        
                   //member and invoice delete
               Route::get('/manager/member_delete/{id}',[ManagerController::class,'member_delete']);
               Route::get('/manager/ex_payment_delete/{id}',[InvoiceController::class,'ex_payment_delete']);
          });

          Route::get('/manager/report', [HallinfoController::class, 'report']);
          Route::post('/pdf/memberlist_with_section', [HallinfoController::class, 'memberlist_with_section']);
          Route::post('/pdf/bazarday', [HallinfoController::class,'bazarday']);
          Route::post('/pdf/bazarmonth', [HallinfoController::class,'bazarmonth']);
          Route::post('/pdf/product_wise', [HallinfoController::class,'product_wise']);
          Route::post('/pdf/daily_sheet', [HallinfoController::class,'daily_sheet']);
          Route::post('/pdf/meal_chart', [HallinfoController::class,'meal_chart']);
          Route::post('/pdf/daily_payment', [HallinfoController::class,'daily_payment']);
          Route::post('/pdf/active_member', [HallinfoController::class,'active_member']);
          Route::post('/pdf/monthly_payment', [HallinfoController::class,'monthly_payment']);
          Route::post('/pdf/section_invoice', [HallinfoController::class,'section_invoice']);
          Route::post('/pdf/overall_summary', [HallinfoController::class,'overall_summary']);
          Route::post('/pdf/booking_payment', [HallinfoController::class,'booking_payment']);
          Route::post('/pdf/refund_summary', [HallinfoController::class,'refund_summary']);
          Route::post('/pdf/monthly_payment_invoice', [HallinfoController::class,'monthly_payment_invoice']);
          Route::post('/pdf/due_invoice', [HallinfoController::class,'due_invoice']);
          Route::post('/pdf/member_invoice_summary', [HallinfoController::class,'member_invoice_summary']);
          Route::post('/pdf/withdraw_invoice', [HallinfoController::class,'withdraw_invoice']);
          Route::post('/pdf/range_inactive_member', [HallinfoController::class,'range_inactive_member']);
          Route::post('/pdf/extra_payment', [HallinfoController::class,'extra_payment']);
          Route::post('/pdf/settlement_history', [HallinfoController::class,'settlement_history']);
          Route::post('/pdf/range_wise_payment', [HallinfoController::class,'range_wise_payment']);
          Route::post('/pdf/last_payment_invoice', [HallinfoController::class,'last_payment_invoice']);
          Route::post('/pdf/managerlist', [HallinfoController::class,'managerlist']);
          Route::get('/pdf/invoiceprint/{invoice_id}', [HallinfoController::class,'invoiceprint']);
          Route::post('/pdf/managermonth', [HallinfoController::class,'managermonth']);
          
          
          Route::middleware('BookingSeatToken')->group(function(){
               //Building  create
               Route::get('/manager/building_view',[BuildingController::class,'building_view']);
               Route::get('/manager/building_fetch',[BuildingController::class,'fetch']);
               Route::get('/manager/building/fetch_data',[BuildingController::class,'fetch_data']);
               Route::post('/manager/building_store',[BuildingController::class,'store']);
               Route::get('/manager/building_edit',[BuildingController::class,'building_edit']);
               Route::post('/manager/building_update',[BuildingController::class,'building_update']);
               Route::delete('/manager/building_delete',[BuildingController::class,'building_delete']);
 
               //Room  create
               Route::get('/manager/room_view',[RoomController::class,'room_view']);
               Route::get('/manager/room_fetch',[RoomController::class,'fetch']);
               Route::get('/manager/room/fetch_data',[RoomController::class,'fetch_data']);
               Route::post('/manager/room_store',[RoomController::class,'store']);
               Route::get('/manager/room_edit',[RoomController::class,'room_edit']);
               Route::post('/manager/room_update',[RoomController::class,'room_update']);
               Route::delete('/manager/room_delete',[RoomController::class,'room_delete']); 
 
                //Seat  create
                 Route::get('/manager/seat_view',[SeatController::class,'seat_view']);
                 Route::get('/manager/seat_fetch',[SeatController::class,'fetch']);
                 Route::get('/manager/seat/fetch_data',[SeatController::class,'fetch_data']);
                 Route::post('/manager/seat_store',[SeatController::class,'store']);
                 Route::get('/manager/seat_edit',[SeatController::class,'seat_edit']);
                 Route::post('/manager/seat_update',[SeatController::class,'seat_update']);
                 Route::delete('/manager/seat_delete',[SeatController::class,'seat_delete']); 
                 Route::get('/manager/room_fetch_building',[SeatController::class,'room_fetch_building']);
 
                 Route::get('/manager/booking/{category}', [BookingController::class, 'index']);
                 Route::post('/manager/booking', [BookingController::class, 'store']);
                 Route::get('/manager/booking_fetch/{category}', [BookingController::class, 'fetch']);
                 Route::get('/manager/booking/{category}/fetch_data', [BookingController::class, 'fetch_data']);
                 Route::get('/manager/booking_edit/{id}', [BookingController::class, 'edit']);
                 Route::post('/manager/booking_update/{id}', [BookingController::class, 'update']);
                 Route::post('/manager/payment_update/{id}', [BookingController::class, 'payment_update']);
                 
         });



         Route::get('/manager/managerlist/{category}', [ManagerlistController::class, 'index']);
         Route::post('/manager/managerlist', [ManagerlistController::class, 'store']);
         Route::get('/manager/managerlist_edit/{id}', [ManagerlistController::class, 'edit']);
         Route::post('/manager/managerlist_update/{id}', [ManagerlistController::class, 'update']);
         Route::delete('/manager/managerlist_delete/{id}', [ManagerlistController::class, 'destroy']);
 


    });


     //Amarpay Payment getway
     Route::get('epay/{hall_id}/{invoice_id}/{tran_id}',[PaymentController::class,'amarpay_epay'])->name('amarpay_epay');
 
     Route::get('amarpay_payment/{hall_id}/{invoice_id}/{tran_id}',[PaymentController::class,'amarpay_payment'])->name('amarpay_payment');
     //You need declear your success & fail route in "app\Middleware\VerifyCsrfToken.php"
     Route::post('amarpay_success',[PaymentController::class,'amarpay_success'])->name('amarpay_success');
     Route::post('amarpay_fail',[PaymentController::class,'amarpay_fail'])->name('amarpay_fail');
     Route::get('amarpay_cancel',[PaymentController::class,'amarpay_cancel'])->name('amarpay_cancel');
     Route::get('payment',[PaymentController::class,'payment'])->name('payment');
 
     Route::post('admin/amarpay_search',[PaymentController::class,'amarpay_search']);


     Route::get('/', function (){
            return view('welcome');
      });

     Route::get('/send-mail', function () {
          $details = [
              'title' => 'Sample Title From Mail',
              'body' => 'This is sample content we have added for this test mail'
          ];
        Mail::to('rayhanbabu458@gmail.com')->send(new \App\Mail\SendMail($details));
        dd("Email is Sent, please check your inbox.");
   });
