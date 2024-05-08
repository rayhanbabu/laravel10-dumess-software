<?php

namespace App\Http\Controllers;

use App\Models\Hallinfo;
use Illuminate\Http\Request;
use  DateTime;
use Illuminate\Support\Str;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Invoice;
use App\Models\Bazar;
use App\Models\Booking;
use App\Models\Expayemnt;

class HallinfoController extends Controller
{

     //memner invoice_status 1 ex member invoice_status 5  
     public function report(Request $request)
     {
          try {
               $hall_id = $request->header('hall_id');
               $hallinfo = Hallinfo::where('hall_id_info', $hall_id)->select('cur_month', 'cur_year', 'cur_section','pdf_order')->first();
               return view('manager.report',['hallinfo' => $hallinfo]);
          } catch (Exception $e) {
               return  view('errors.error', ['error' => $e]);
          }
     }


     public function memberlist_with_section(Request $request)
     {
          try {
               $hall_id = $request->header('hall_id');
               $month = date('n', strtotime($_POST['month']));
               $year = date('Y', strtotime($_POST['month']));
               $section = $_POST['section'];
               $month1 = date('F-Y', strtotime($_POST['month']));
               $hallinfo = Hallinfo::where('hall_id_info', $hall_id)->select('cur_month', 'cur_year', 'cur_section','pdf_order')->first();
               if(!empty($month) && !empty($section)){
                    $member = Member::where('hall_id', $hall_id)->where('admin_verify',1)
                      ->where('verify_month',$month)->where('verify_year',$year)->select('name','registration'
                      ,'phone','email','card')->orderBy($hallinfo->pdf_order,'asc')->get(); 
                }else{
                    $member = Member::where('hall_id', $hall_id)->where('admin_verify',1)
                      ->select('name','registration','phone','email','card')->orderBy($hallinfo->pdf_order,'asc')->get(); 
                }
               
               
           return view('pdf.memberlist',[
                    'month1' => $month1, 'member' => $member, 'section' => $section    
              ]);
             
             } catch (Exception $e) {
             return  view('errors.error', ['error' => $e]);
          }
     }


       
     public function active_member(Request $request)
     {
          try {
               $hall_id = $request->header('hall_id');
               $month = date('n',strtotime($_POST['month']));
               $year = date('Y',strtotime($_POST['month']));
               $section = $_POST['section'];
               $month1 = date('F-Y', strtotime($_POST['month']));
               $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month', 'cur_year', 'cur_section','pdf_order')->first();
          
               $invoice = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
                 ->where('invoice_month', $month)->where('invoices.hall_id', $hall_id)
                 ->where('invoice_year', $year)->where('invoice_section', $section)
                 ->where('onmeal_amount','>=',1)
                 ->select('name','registration','phone','email','card',
                 'payble_amount1','payble_amount2','payment_status1','payment_status2')->orderBy($hallinfo->pdf_order,'asc')->get();
               
               return view('pdf.active_member',[
                     'month1' => $month1, 'invoice' => $invoice, 'section' => $section    
                ]);
             
             } catch (Exception $e) {
             return  view('errors.error', ['error' => $e]);
          }
     }



     public function section_invoice(Request $request)
     {
          try {
               $hall_id = $request->header('hall_id');
               $month = date('n',strtotime($_POST['month']));
               $year = date('Y',strtotime($_POST['month']));
               $section = $_POST['section'];
               $month1 = date('F-Y',strtotime($_POST['month']));
               $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
          
               $invoice = Invoice::leftjoin('members','members.id','=','invoices.member_id')
                  ->where('invoice_month',$month)->where('invoices.hall_id',$hall_id)
                  ->where('invoice_year',$year)->where('invoice_section',$section)
                  ->where('invoice_status',1)
                  ->select('name','registration','phone','email','card','cur_total_amount','inmeal_amount',
                  'payble_amount1','payble_amount2','payble_amount','pre_refund','payble_amount'
                  ,'pre_monthdue','pre_reserve_amount','invoice_status','security','withdraw')
                  ->orderBy($hallinfo->pdf_order,'asc')->get();

                  $withdraw = Invoice::leftjoin('members','members.id','=','invoices.member_id')
                  ->where('invoice_month',$month)->where('invoices.hall_id',$hall_id)
                  ->where('invoice_year',$year)->where('invoice_section',$section)
                  ->where('invoice_status',1)->where('withdraw_status',1)
                  ->select('name','registration','phone','email','card','cur_total_amount',
                  'payble_amount1','payble_amount2','payble_amount','pre_refund','payble_amount'
                  ,'pre_monthdue','pre_reserve_amount','invoice_status','security','withdraw')
                  ->orderBy($hallinfo->pdf_order,'asc')->get();


                  $exinvoice = Invoice::leftjoin('members','members.id','=','invoices.member_id')
                  ->where('invoice_month',$month)->where('invoices.hall_id',$hall_id)
                  ->where('invoice_year',$year)->where('invoice_section',$section)
                  ->where('invoice_status',5)
                  ->select('name','registration','phone','email','card',
                  'payble_amount1','payble_amount2','payble_amount','pre_refund'
                  ,'pre_monthdue','pre_reserve_amount','invoice_status','security','withdraw')
                  ->orderBy($hallinfo->pdf_order,'asc')->get();
               
               return view('pdf.section_invoice',[
                     'month1' => $month1, 'invoice' => $invoice, 'section' => $section  
                     ,'exinvoice' => $exinvoice ,'withdraw' => $withdraw
                ]);
             
             } catch (Exception $e) {
             return  view('errors.error', ['error' => $e]);
          }
     }



     public function overall_summary(Request $request)
     {
          try {
               // Member invoice_status 1 Exmember invoice_status 5 
            $hall_id = $request->header('hall_id');
            $month = date('n',strtotime($_POST['month']));
            $year = date('Y',strtotime($_POST['month']));
            $section = $_POST['section'];
            $month1 = date('F-Y',strtotime($_POST['month']));
            $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order'
            ,'meal_start_date')->first();
      
    
       $invoice=DB::table('invoices')->where('invoice_month',$month)->where('hall_id',$hall_id)
          ->where('invoice_year',$year)->where('invoice_section',$section)->where('invoice_status',1)->get();

       $active_invoice = Invoice::where('invoice_month',$month)->where('hall_id',$hall_id)
          ->where('invoice_year',$year)->where('invoice_section',$section)
          ->where('onmeal_amount','>=',1)->get();

       $payment1=DB::table('invoices')->where('invoice_month', $month)->where('hall_id', $hall_id)
        ->where('invoice_year', $year)->where('invoice_section', $section)->where('invoice_status',1)
        ->where('payment_status1',1)->get();

       $payment2=DB::table('invoices')->where('invoice_month', $month)->where('hall_id', $hall_id)
        ->where('invoice_year', $year)->where('invoice_section', $section)->where('invoice_status',1)
        ->where('payment_status2',1)->get();

        $withdraw=DB::table('invoices')->where('invoice_month', $month)->where('hall_id', $hall_id)
        ->where('invoice_year', $year)->where('invoice_section', $section)->where('invoice_status',1)
        ->where('withdraw_status',1)->get();


        $exinvoice_payment=DB::table('invoices')->where('invoice_month', $month)->where('hall_id', $hall_id)
        ->where('invoice_year', $year)->where('invoice_section', $section)->where('invoice_status',5)
        ->where('withdraw_status',1)->get();
     
     

       $exinvoice = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
          ->where('invoice_month', $month)->where('invoices.hall_id', $hall_id)
          ->where('invoice_year', $year)->where('invoice_section', $section)
          ->where('invoice_status',5)->select('security_money','members.service_charge as member_serice_charge','invoices.*')->get();

     $bazar=DB::table('bazars')->where('bazar_year',$year)->where('bazar_month',$month)->where('bazar_section',$section)
      ->where('hall_id',$hall_id)->get();

      $extra_payment=Expayemnt::where('cur_month',$month)->where('cur_year',$year)->where('hall_id',$hall_id)
      ->where('cur_section',$section)->orderBy('id','desc')->get();
        
      $reserve_payment2=DB::table('invoices')->where('invoice_month', $month)->where('hall_id', $hall_id)
      ->where('invoice_year', $year)->where('invoice_section',$section)->where('invoice_status',1)
      ->where('payment_status2',1)->where('payble_amount2','<',0)->sum('payble_amount2');

          return view('pdf.overall_summary2',[
                       'month1' => $month1 ,'invoice' => $invoice ,'section' => $section 
                       ,'exinvoice' => $exinvoice, 'active_invoice' => $active_invoice
                       ,'payment1' => $payment1,'payment2' => $payment2,'bazar'=>$bazar  
                       ,'exinvoice_payment'=>$exinvoice_payment,'withdraw' => $withdraw
                      ,'extra_payment'=>$extra_payment,'reserve_payment2'=>$reserve_payment2
           ]);
             
             } catch (Exception $e) {
             return  view('errors.error', ['error' => $e]);
          }
     }


     public function monthly_payment(Request $request)
     {
        //  try {
               $hall_id = $request->header('hall_id');
               $month = date('n',strtotime($_POST['month']));
               $year = date('Y',strtotime($_POST['month']));
               $section = $_POST['section'];
               $month1 = date('F-Y', strtotime($_POST['month']));
               $status=1;
               $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month', 'cur_year', 'cur_section','pdf_order')->first();
          

          $payment1 = DB::select("select  SUM(payble_amount1) AS payble_amount1, COUNT(id) AS id_total,
              DATE_FORMAT(payment_time1,'%d') AS payment_day
              FROM `invoices` WHERE invoice_month='$month'  AND invoice_year='$year' AND payment_status1='$status' AND 
              invoice_section='$section' AND hall_id='$hall_id' GROUP BY DATE_FORMAT(payment_time1,'%d')");

          $payment2 = DB::select("select  SUM(payble_amount2) AS payble_amount2, COUNT(id) AS id_total,
              DATE_FORMAT(payment_time2,'%d') AS payment_day
              FROM `invoices`  WHERE  invoice_month='$month' AND invoice_year='$year' AND payment_status2='$status' AND 
              invoice_section='$section' AND  hall_id='$hall_id' GROUP BY DATE_FORMAT(payment_time2,'%d')");
           
           $reserve_payment2=DB::table('invoices')->where('invoice_month', $month)->where('hall_id', $hall_id)
              ->where('invoice_year', $year)->where('invoice_section',$section)->where('invoice_status',1)
              ->where('payment_status2',1)->where('payble_amount2','<',0)->sum('payble_amount2');   

                // return $payment2;
            return view('pdf.monthly_payment',['month1'=>$month1, 'payment1'=>$payment1, 
            'payment2' => $payment2, 'section' => $section,'reserve_payment2'=>$reserve_payment2]);
             

                // } catch (Exception $e) {
              //   return  view('errors.error', ['error' => $e]);}
      }





     public function bazarday(Request $request)
     {
          $hall_id = $request->header('hall_id');
          $data = Hallinfo::where('hall_id_info', $hall_id)->first();

          $cur_month = $data->cur_month;
          $cur_year = $data->cur_year;
          $section = $data->cur_section;

          $day = date('Y-m-d', strtotime($_POST['bazardate']));
          $day1 = date('d-F-Y', strtotime($_POST['bazardate']));
          $file = 'Bazar_' . $day1 . '.pdf';

          $daymeal = (getDaysBetween2Dates(new DateTime($_POST['bazardate']), new DateTime($data->meal_start_date), false) + 1);

          $b_meal = 'b' . $daymeal;
          $l_meal = 'l' . $daymeal;
          $d_meal = 'd' . $daymeal;
          if ($daymeal > 0) {
               $sum = 0;
               for ($x = 1; $x < 5; $x++) {
                    $breakfast_meal = Invoice::where('friday' . $x, $b_meal)->where('invoice_month', $cur_month)->where('hall_id', $hall_id)
                         ->where('invoice_year', $cur_year)->where('invoice_section', $section)->where($b_meal, 1)->count('id');

                    $lunch_meal = Invoice::where('friday' . $x, $l_meal)->where('invoice_month', $cur_month)->where('hall_id', $hall_id)
                         ->where('invoice_year', $cur_year)->where('invoice_section', $section)->where($l_meal, 1)->count('id');

                    $dinner_meal = Invoice::where('friday' . $x, $d_meal)->where('invoice_month', $cur_month)->where('hall_id', $hall_id)
                         ->where('invoice_year', $cur_year)->where('invoice_section', $section)->where($d_meal, 1)->count('id');

                    $fridaytaka = 'friday' . $x . 't';

                    $sum1 = $breakfast_meal * $data->$fridaytaka + $lunch_meal * $data->$fridaytaka + $dinner_meal * $data->$fridaytaka;
                    $sum += $sum1;
               }
          } else {
               $sum = 0;
          }


          if ($daymeal > 0) {
               $b_meal_no = Invoice::where($b_meal, 1)->where('invoice_month', $cur_month)->where('hall_id', $hall_id)
                    ->where('invoice_year', $cur_year)->where('invoice_section', $section)->count('id');

               $l_meal_no = Invoice::where($l_meal, 1)->where('invoice_month', $cur_month)->where('hall_id', $hall_id)
                    ->where('invoice_year', $cur_year)->where('invoice_section', $section)->count('id');

               $d_meal_no = Invoice::where($l_meal, 1)->where('invoice_month', $cur_month)->where('hall_id', $hall_id)
                    ->where('invoice_year', $cur_year)->where('invoice_section', $section)->count('id');

               $meal_amount = ($b_meal_no * $data->breakfast_rate + $l_meal_no * $data->lunch_rate + $d_meal_no * $data->dinner_rate) + $sum;
          } else {
               $meal_amount = 0;
               $b_meal_no = 0;
               $l_meal_no = 0;
               $d_meal_no = 0;
          }


          $bazar = Bazar::leftjoin('products', 'products.id', '=', 'bazars.product_id')->where('date', $day)
               ->where('bazars.category', 'bazar')->where('bazars.hall_id', $hall_id)->orderBy('bazars.id', 'DESC')->get();



          if ($bazar->count()>0) {
                return view('pdf.bazarday', [
                     'day1' => $day1, 'bazar' => $bazar, 
                     'sum' => $sum, 'meal_amount' => $meal_amount, 
                     'b_meal_no' => $b_meal_no ,'l_meal_no' => $l_meal_no,'d_meal_no' => $d_meal_no
                ]);
           } else {
                return back()->with('fail', 'Bazar not found this date ');
           }
     }


     public function bazarmonth(Request $request)
       {
          $hall_id = $request->header('hall_id');
        
          $month=date('n',strtotime($_POST['month']));
          $year=date('Y',strtotime($_POST['month']));
          $section=$_POST['section'];
     
          $month1=date('F-Y',strtotime($_POST['month']));

          $bazar=DB::table('bazars')->where('bazar_year',$year)->where('bazar_month',$month)->where('bazar_section',$section)
          ->where('bazars.category','bazar')->where('hall_id',$hall_id)->select('bazar_day',DB::raw('count(id) as id_total'),DB::raw('sum(total) as bazar_total'))
          ->orderBy('bazar_day','asc')->groupBy('bazar_day')->get();

          if ($bazar->count()>0) {
               return view('pdf.bazarmonth', [
                    'month1' => $month1, 'bazar' => $bazar,  'section' => $section    
               ]);
          } else {
               return back()->with('fail', 'Bazar not found this date ');
          }
       }


       public function product_wise(Request $request)
       {
          $hall_id = $request->header('hall_id');
        
          $month=date('n',strtotime($_POST['month']));
          $year=date('Y',strtotime($_POST['month']));
          $product_id=$request->input('product_id');
          $section=$_POST['section'];
     
          $month1=date('F-Y',strtotime($_POST['month']));

          $product=Bazar::leftjoin('products', 'products.id', '=', 'bazars.product_id')->where('bazar_month',$month)->where('bazar_year',$year)
          ->where('bazars.category','bazar')->where('product_id',$product_id)->where('bazar_section',$section)
          ->where('bazars.hall_id',$hall_id)->select('products.product', 'bazars.*')->orderBy('bazars.id', 'DESC')->get();

        
          if ($product->count()>0) {
               return view('pdf.bazarproduct', [
                    'month1' => $month1, 'product' => $product,  'section' => $section    
               ]);
          } else {
               return back()->with('fail', 'Bazar not found this date ');
          }
       }



   public function daily_sheet(Request $request)
       {
            $hall_id = $request->header('hall_id');
            $data = Hallinfo::where('hall_id_info', $hall_id)->select('meal_start_date','pdf_order')->first();
          
            $status=$_POST['status'];
            $month=date('n',strtotime($_POST['month']));
            $year=date('Y',strtotime($_POST['month']));
            $month1=date('d-M-Y',strtotime($_POST['milloff_date']));
            $section=$_POST['section'];
            $type=$_POST['type'];
            $page_type=$_POST['page_type'];

           $invoice= Invoice::where('invoice_month',$month)->where('invoices.hall_id',$hall_id)
                 ->where('invoice_year', $year)->where('invoice_section', $section)->first();

             
           if($status==1){ $type_status="ON";
           }else{ $type_status="OFF"; }

     $daymeal = (getDaysBetween2Dates(new DateTime($_POST['milloff_date']), new DateTime($invoice->meal_start_date), false) + 1);
        if($daymeal>=1){
          $meal = $type . $daymeal;
          if($status==1){
               $meal=Invoice::leftjoin('members','members.id', '=', 'invoices.member_id')
                 ->where($meal,$status)->where('invoice_month',$month)->where('invoices.hall_id',$hall_id)
                 ->where('invoice_year', $year)->where('invoice_section', $section)
                 ->select('invoices.id','name','registration','card')
                 ->orderBy($data->pdf_order,'asc')->get();
          }else{
               $meal=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
                 ->where($meal,$status)->where('invoice_month',$month)->where('invoices.hall_id',$hall_id)
                 ->where('invoice_year',$year)->where('invoice_section',$section)
                 ->where('onmeal_amount','>=',1)
                 ->select('invoices.id','name','registration','card')
                 ->orderBy($data->pdf_order,'asc')->get();
          }
        

              $sum=$meal->count('id');
              $file='Meal Sheet-'.$month1.'.pdf';

              if($page_type=="card"){
                 return view('pdf.mealoncard', [
                      'month1' => $month1, 'meal' => $meal, 'type' => $type_status,'file'=>$file ,
                      'section' => $section, 'meal_type' => $type, 'sum' => $sum,  
                    ]);
              }else{
                return view('pdf.mealonfpdf', [
                    'month1' => $month1, 'meal' => $meal, 'type' => $type_status,'file'=>$file ,
                    'section' => $section, 'meal_type' => $type, 'sum' => $sum,  
                 ]);
              }

             


          }else{
               return back()->with('fail', 'Data not found  ');
           }
        }

    public function meal_chart(Request $request){
          $hall_id = $request->header('hall_id');
          $month=date('n',strtotime($_POST['month']));
          $year=date('Y',strtotime($_POST['month']));
          $section=$_POST['section'];

          $data = Hallinfo::where('hall_id_info', $hall_id)->select('meal_start_date','pdf_order')->first();
      
          $month1=date('F-Y',strtotime($_POST['month']));
          $file='Mealchart_'.$month1.'.pdf';	

          $meal=Invoice::where('invoice_month',$month)->where('invoice_year',$year)->where('invoices.hall_id',$hall_id)
          ->where('invoice_section',$section)->first();

       if($meal){
          $meal_start_date=$meal->meal_start_date;
          $cur_day=$meal->section_day;
      
           $t_invoice=00;
           $t_meal=00;
           $refund_meal=00;
           $ddue_meal=00;
      
          $invoice=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
            ->where('invoice_month',$month)->where('invoice_year',$year)->where('invoices.hall_id',$hall_id)
            ->where('invoice_section',$section)->where('onmeal_amount','>=',1)->select('invoices.*','name','registration','card')
            ->orderBy($data->pdf_order,'asc')->get();
       
           return view('pdf.mealchart',['invoice'=>$invoice,'month1'=>$month1 ,'file'=>$file,
             't_invoice'=>$t_invoice,'t_meal'=>$t_meal ,'refund_meal'=>$refund_meal 
             ,'ddue_meal'=>$ddue_meal ,'cur_day'=>$cur_day,'meal_start_date'=>$meal_start_date,'section'=>$section ]);

         }else{
               return back()->with('fail', 'Data not found');          
         }

      }


      public function daily_payment(Request $request){

          $hall_id = $request->header('hall_id');
          $date=date('Y-m-d',strtotime($_POST['date']));
          $type=$request->input('type');
          $status=1;
          $date1=date('d-F-Y',strtotime($_POST['date']));

          $payment1=array();
          $payment2=array();

          $data = Hallinfo::where('hall_id_info', $hall_id)->select('meal_start_date','pdf_order')->first();
        

        if($type==1){
          $payment1= Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
           ->whereDate('invoices.payment_time1',$date)
           ->where('invoices.hall_id',$hall_id)->where('payment_status1',$status)
           ->select('invoices.id','name','registration','card','payble_amount1','phone',
           'payble_amount2','payment_time1','payment_time2','payment_type1','payment_type2')->orderBy($data->pdf_order,'asc')->get();
         
        }else if($type==2){
           $payment2= Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
            ->whereDate('invoices.payment_time2',$date)
            ->where('invoices.hall_id',$hall_id)->where('payment_status2',$status)
            ->select('invoices.id','name','registration','card','payble_amount1','phone',
            'payble_amount2','payment_time1','payment_time2','payment_type1','payment_type2')->orderBy($data->pdf_order,'asc')->get();
        }else if($type==3){
           $payment1= Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
           ->whereDate('invoices.payment_time1',$date)
           ->where('invoices.hall_id',$hall_id)->where('payment_status1',$status)
           ->select('invoices.id','name','registration','card','payble_amount1','phone',
           'payble_amount2','payment_time1','payment_time2','payment_type1','payment_type2')->orderBy($data->pdf_order,'asc')->get();

           $payment2= Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
           ->whereDate('invoices.payment_time2',$date)
           ->where('invoices.hall_id',$hall_id)->where('payment_status2',$status)
           ->select('invoices.id','name','registration','card','payble_amount1','phone',
           'payble_amount2','payment_time1','payment_time2','payment_type1','payment_type2')->orderBy($data->pdf_order,'asc')->get();
        }
           
       return view('pdf.daily_payment',['type'=>$type,'date1'=>$date1 ,"payment1"=>$payment1, "payment2"=>$payment2]);
  
   }
 



       public function booking_payment(Request $request){

              $hall_id = $request->header('hall_id');
              $date=date('Y-m-d',strtotime($_POST['date']));
              $type=$request->input('type');
              $status=1;
              $date1=date('d-F-Y',strtotime($_POST['date']));

              $payment1=array();
              $payment2=array();
              $payment3=array();

            if($type==1){
                 $payment1= Booking::leftjoin('booking_members', 'booking_members.id', '=', 'bookings.booking_member_id')
                 ->whereDate('bookings.time1',$date)->where('bookings.hall_id',$hall_id)
                 ->select('name','phone','bookings.*')->get();
            }else if($type==2){
                 $payment2= Booking::leftjoin('booking_members', 'booking_members.id', '=', 'bookings.booking_member_id')
                 ->whereDate('bookings.time2',$date)->where('bookings.hall_id',$hall_id)
                 ->select('name','phone','bookings.*')->get();
            }else if($type==3){
                 $payment3= Booking::leftjoin('booking_members', 'booking_members.id', '=', 'bookings.booking_member_id')
                 ->whereDate('bookings.time3',$date)->where('bookings.hall_id',$hall_id)
                 ->select('name','phone','bookings.*')->get();

            }
           else if($type==4){

               $payment1= Booking::leftjoin('booking_members', 'booking_members.id', '=', 'bookings.booking_member_id')
                 ->whereDate('bookings.time1',$date)->where('bookings.hall_id',$hall_id)
                 ->select('name','phone','bookings.*')->get();

                 $payment2= Booking::leftjoin('booking_members', 'booking_members.id', '=', 'bookings.booking_member_id')
                 ->whereDate('bookings.time2',$date)->where('bookings.hall_id',$hall_id)
                 ->select('name','phone','bookings.*')->get();

                 $payment3= Booking::leftjoin('booking_members', 'booking_members.id', '=', 'bookings.booking_member_id')
                 ->whereDate('bookings.time3',$date)->where('bookings.hall_id',$hall_id)
                 ->select('name','phone','bookings.*')->get();
          }

             //  dd($payment1);
             return view('pdf.booking_payment',['type'=>$type,'date1'=>$date1 
              ,"payment1"=>$payment1 ,"payment2"=>$payment2, "payment3"=>$payment3]);

       }



       public function refund_summary(Request $request)
       {
          try {
               $hall_id = $request->header('hall_id');
               $month = date('n',strtotime($_POST['month']));
               $year = date('Y',strtotime($_POST['month']));
               $section = $_POST['section'];
               $month1 = date('F-Y',strtotime($_POST['month']));
               $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
          
               $invoice = Invoice::leftjoin('members','members.id','=','invoices.member_id')
                  ->where('invoice_month', $month)->where('invoices.hall_id', $hall_id)
                  ->where('invoice_year', $year)->where('invoice_section', $section)
                  ->where('invoice_status', 1)
                  ->select('name','registration','phone','email','card',
                  'payble_amount1','payble_amount2','payble_amount','total_refund'
                  ,'total_due','reserve_amount','invoice_status')
                  ->orderBy($hallinfo->pdf_order,'asc')->get();
               
               return view('pdf.refund_summary',[
                     'month1' => $month1, 'invoice' => $invoice, 'section' => $section    
                ]);
             
             } catch (Exception $e) {
             return  view('errors.error', ['error' => $e]);
          }
     }




     public function monthly_payment_invoice(Request $request){

               $hall_id = $request->header('hall_id');
               $month = date('n',strtotime($_POST['month']));
               $year = date('Y',strtotime($_POST['month']));
               $section = $_POST['section'];
               $month1 = date('F-Y',strtotime($_POST['month']));
               $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
          
            $payment1=array();
            $payment2=array();
            $status=1;
        
     $payment1=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
       ->where('invoice_month',$month)->where('invoice_year',$year)->where('invoices.hall_id',$hall_id)
       ->where('invoice_section',$section)->where('payment_status1',$status)->select('invoices.*','name','registration','card','phone')
       ->orderBy($hallinfo->pdf_order,'asc')->get();

     $payment2=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
       ->where('invoice_month',$month)->where('invoice_year',$year)->where('invoices.hall_id',$hall_id)
       ->where('invoice_section',$section)->where('payment_status2',$status)->select('invoices.*','name','registration','card','phone')
       ->orderBy($hallinfo->pdf_order,'asc')->get();
     
      
      return view('pdf.monthly_payment_invoice',["section"=>$section,"month1"=>$month1,"payment1"=>$payment1, "payment2"=>$payment2]);
  
     }


     public function due_invoice(Request $request){

          $hall_id = $request->header('hall_id');
          $month = date('n',strtotime($_POST['month']));
          $year = date('Y',strtotime($_POST['month']));
          $section = $_POST['section'];
          $month1 = date('F-Y',strtotime($_POST['month']));
          $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
     
       $payment1=array();
       $status=0;
   
       $payment=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
        ->where('invoice_month',$month)->where('invoice_year',$year)->where('invoices.hall_id',$hall_id)
        ->where('invoice_section',$section)->where('payment_status1',$status)
        ->where('payment_status2',$status)->where('onmeal_amount','>',0)->select('invoices.*','name','registration','card','phone')
        ->orderBy($hallinfo->pdf_order,'asc')->get();

       return view('pdf.due_invoice',["section"=>$section,"month1"=>$month1,"payment"=>$payment,]);

     }


      public function member_invoice_summary(Request $request){

          $hall_id = $request->header('hall_id');
          $card = $_POST['card'];
          $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
          $invoice=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
          ->where('invoices.hall_id',$hall_id)->where('members.card',$card)->select('invoices.*','name','registration','card','phone')
          ->orderBy('id','desc')->get();
          return view('manager.member_invoice_summary',["hallinfo"=>$hallinfo,"invoice"=>$invoice,]);

      }



 
      public function withdraw_invoice(Request $request){

          $hall_id = $request->header('hall_id');
          $month = date('n',strtotime($_POST['month']));
          $year = date('Y',strtotime($_POST['month']));
          $section = $_POST['section'];
          $month1 = date('F-Y',strtotime($_POST['month']));
          $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
     
        $status=1;
   
       $withdraw=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
        ->where('invoice_month',$month)->where('invoice_year',$year)->where('invoices.hall_id',$hall_id)
        ->where('invoice_section',$section)->where('withdraw_status',$status)->where('invoice_status',1)->select('invoices.*','name','registration','card','phone')
         ->orderBy($hallinfo->pdf_order,'asc')->get();
     return view('pdf.withdraw_invoice',["section"=>$section,"month1"=>$month1,"withdraw"=>$withdraw]);

}

 
  public function range_inactive_member(Request $request){

       $hall_id = $request->header('hall_id');
       $date1 = $_POST['date1'];
       $date2 = $_POST['date2'];
       $hallinfo = Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();

       $status=1;

       $invoice=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
          ->where('invoices.hall_id',$hall_id)->whereBetween('invoice_date', [$date1, $date2])->where('onmeal_amount','<=',0)->select('invoices.*','name','registration','card','phone')
           ->orderBy($hallinfo->pdf_order,'asc')->get();
 
        return view('pdf.range_inactive',["date1"=>$date1,"date2"=>$date2,"invoice"=>$invoice]);

    }



    public function extra_payment(Request $request){

        $hall_id = $request->header('hall_id');
        $month = date('n',strtotime($_POST['month']));
        $year = date('Y',strtotime($_POST['month']));
        $section = $_POST['section'];
        $month1 = date('F-Y',strtotime($_POST['month']));
        $status=1;

       $extra_payment=Expayemnt::where('cur_month',$month)->where('cur_year',$year)->where('hall_id',$hall_id)
       ->where('cur_section',$section)->orderBy('id','desc')->get();
        return view('pdf.extra_payment',["section"=>$section,"month1"=>$month1,"extra_payment"=>$extra_payment]);

    }




       
     

}
