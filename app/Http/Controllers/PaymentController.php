<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Invoice;
use App\Models\Hall;
use App\Models\Hallinfo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Exception;
use  DateTime;

class PaymentController extends Controller
 {
      

   public function amarpay_epay($hall_id,$invoice_id,$tran_id)
   {
 
    // try {
      $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('hall_name','cur_year','cur_month'
      ,'cur_section','gateway_fee','refresh_date','refresh_no')->first();
      $invoice = Invoice::leftjoin('members','members.id','=','invoices.member_id')
       ->Where('invoices.hall_id',$hall_id)->Where('invoices.id',$invoice_id)
       ->Where('invoices.invoice_status',1)
       ->select('members.email','members.name','members.phone','members.registration','members.card', 'invoices.*')->first();
     if($invoice && ($invoice->tran_id1==$tran_id || $invoice->tran_id2==$tran_id)){
           $length =Str::length($tran_id);
            if($length==8){
                 $data=[
                     "name" =>$invoice->name,
                     "phone" =>$invoice->phone,
                     "email" =>$invoice->email,
                     "card" =>$invoice->card,
                     "registration" =>$invoice->registration,
                     "payment_status" =>$invoice->payment_status1,
                     "tran_id" =>$invoice->tran_id1,
                     "payble_amount" =>$invoice->payble_amount1,
                     "amount" =>$invoice->amount1,
                     "payment" =>"1st Payment",
                     "invoice_month" =>$invoice->invoice_month,
                     "invoice_year" =>$invoice->invoice_year,
                     "invoice_section" =>$invoice->invoice_section,
                     "hall" =>$hallinfo->hall_name,
                     "gateway_fee" =>$hallinfo->gateway_fee,
                     "hall_id" =>$hall_id,
                     "invoice_id" =>$invoice_id,
                  ];
             }else if($length==10){
               $data=[
                  "name" =>$invoice->name,
                  "phone" =>$invoice->phone,
                  "email" =>$invoice->email, 
                  "card" =>$invoice->card,
                  "registration" =>$invoice->registration,
                  "payment_status" =>$invoice->payment_status2,
                  "tran_id" =>$invoice->tran_id2,
                  "payble_amount" =>$invoice->payble_amount2,
                  "amount" =>$invoice->amount2,
                  "payment" =>"2nd Payment",
                  "invoice_month" =>$invoice->invoice_month,
                  "invoice_year" =>$invoice->invoice_year,
                  "invoice_section" =>$invoice->invoice_section,
                  "hall" =>$hallinfo->hall_name,
                  "gateway_fee" =>$hallinfo->gateway_fee,
                  "hall_id" =>$hall_id,
                  "invoice_id" =>$invoice_id,
                ];

            }else{
                    return "Invalid Url";
               }

            return view('web.invoicePayment',$data);
      } else {
         return "Invalid Url";
        }
     // } catch (Exception $e) {
     //   return "Something Error. please try again";
     // }

   }


   public function amarpay_payment($hall_id,$invoice_id,$tran_id)
   {
     //try {
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('hall_name','cur_year','cur_month'
         ,'cur_section','gateway_fee','refresh_date','refresh_no')->first();
         $invoice=Invoice::leftjoin('members','members.id','=','invoices.member_id')
          ->Where('invoices.hall_id',$hall_id)->Where('invoices.id',$invoice_id)
          ->Where('invoices.invoice_status',1)
          ->select('members.email','members.name','members.phone','members.registration','members.card', 'invoices.*')->first();
       if($invoice && $hallinfo->cur_year==$invoice->invoice_year &&  $hallinfo->cur_month==$invoice->invoice_month 
       && $hallinfo->cur_section==$invoice->invoice_section && ($invoice->tran_id1==$tran_id || $invoice->tran_id2==$tran_id)){
        $length =Str::length($tran_id);
        if($length==8){
           $data=[
              "name" =>$invoice->name,
              "phone" =>$invoice->phone,
              "email" =>$invoice->email,
              "card" =>$invoice->card,
              "registration" =>$invoice->registration,
              "payment_status" =>$invoice->payment_status1,
              "tran_id" =>$invoice->tran_id1,
              "payble_amount" =>$invoice->payble_amount1,
              "amount" =>$invoice->amount1,
              "payment" =>"1st Payment",
              "invoice_month" =>$invoice->invoice_month,
              "invoice_year" =>$invoice->invoice_year,
              "invoice_section" =>$invoice->invoice_section,
              "hall" =>$hallinfo->hall_name,
              "hall_id" =>$hall_id,
              "invoice_id" =>$invoice_id,
            ];
         }else if($length==10){
            $data=[
              "name" =>$invoice->name,
              "phone" =>$invoice->phone,
              "email" =>$invoice->email, 
              "card" =>$invoice->card,
              "registration" =>$invoice->registration,
              "payment_status" =>$invoice->payment_status2,
              "tran_id" =>$invoice->tran_id2,
              "payble_amount" =>$invoice->payble_amount2,
              "amount" =>$invoice->amount2,
              "payment" =>"2nd Payment",
              "invoice_month" =>$invoice->invoice_month,
              "invoice_year" =>$invoice->invoice_year,
              "invoice_section" =>$invoice->invoice_section,
              "hall" =>$hallinfo->hall_name,
              "hall_id" =>$hall_id,
              "invoice_id" =>$invoice_id,
            ];
         }
 
       if($data["payble_amount"]<=10){
              return "You can not paid this Invoice amount must be geater than 10";
       }else if($data["payment_status"]==1){
              return "Already paid this Invoice";
       }else{              
       $tran_id = $data["tran_id"];  //unique transection id for every transection 
       $currency = "BDT"; //aamarPay support Two type of currency USD & BDT  
  
       $amount = $data["amount"];   // 10 taka is the minimum amount for show card option in aamarPay payment gateway
       $desc="Hall Id: ".$data['hall_id']. ' Invoice Id:'.$data['invoice_id']. ' Section Name: '.$data['invoice_month'].$data['invoice_year'].$data['invoice_section'];
 
       $url ='https://​sandbox​.aamarpay.com/jsonpost.php';
       $store_id ='aamarpaytest';
       $signature_key ='dbb74894e82415a2f7ff0ec3a97e4183';

    
       $curl = curl_init();
       curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
          "store_id": "' . $store_id . '",
          "tran_id": "' . $tran_id . '",
          "success_url": "' . route('amarpay_success') . '",
          "fail_url": "' . route('amarpay_fail') . '",
          "cancel_url": "' . route('amarpay_cancel') . '",
          "amount": "' . $amount . '",
          "currency": "' . $currency . '",
          "signature_key": "' . $signature_key . '",
          "desc": "' . $desc . '",
          "cus_name": "' . $data["name"] . '",
          "cus_email": "' . $data["email"] . '",
           "cus_add1": "' . $data["card"] . '",
          "cus_add2": "' . $data["hall"] . '",
          "cus_city": "Dhaka",
          "cus_state": "Dhaka",
          "cus_postcode": "1206",
          "cus_country": "Bangladesh",
          "cus_phone": "' . $data["phone"] . '",
          "opt_a": "' . $data["invoice_id"] . '",
          "opt_b": "' . $data["hall_id"] . '",
          "type": "json"
     }',
         CURLOPT_HTTPHEADER => array(
           'Content-Type: application/json'
         ),
       ));
 
       $response = curl_exec($curl);
 
       curl_close($curl);
       //dd($response);
    
       $responseObj = json_decode($response);
       if(isset($responseObj->payment_url) && !empty($responseObj->payment_url)) {
             $paymentUrl = $responseObj->payment_url;
             // dd($paymentUrl);
             return redirect($paymentUrl);
       } else {
            echo $response;
       }

        // } catch (Exception $e) {
        //   return "Something Error. please try again";
        // }
      }
         }else{
            return "Invalid Url. Please try Proper way.";
         }
  }

    
   public function amarpay_success(Request $request)
   {
    // try {
       $request_id = $request->mer_txnid;
        
       $success_url ='https://sandbox.aamarpay.com/api/v1/trxcheck/request.php';
       $store_id ='aamarpaytest';
       $signature_key ='dbb74894e82415a2f7ff0ec3a97e4183';
 
       $url = $success_url."?request_id=$request_id&store_id=$store_id&signature_key=$signature_key&type=json";
       //For Live Transection Use "http://secure.aamarpay.com/api/v1/trxcheck/request.php"
 
       $curl = curl_init();
 
       curl_setopt_array($curl, array(
         CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'GET',
       ));
       $response = curl_exec($curl);
       curl_close($curl);
       // echo  $response;
 
       //database working part 
       $success = json_decode($response, true);
       //echo $success['status_code'];
       $payment_date = date('Y-m-d',strtotime($success['date_processed']));
       $payment_day = date('d',strtotime($success['date_processed']));
       $payment_month = date('n',strtotime($success['date_processed']));
       $payment_year = date('Y',strtotime($success['date_processed']));
       $status1=1;
       $paymenttime=$success['date_processed'];
 
        $tran_id=$success['mer_txnid'];
        $invoice_id=$success['opt_a'];
        $hall_id=$success['opt_b'];
        $length =Str::length($tran_id);
        $bank_trxid=$success['bank_trxid'];
        $payment_method=$success['payment_type'];
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('section_day','unpaid_day','breakfast_rate','lunch_rate'
       ,'dinner_rate','breakfast_status','lunch_status','dinner_status','first_payment_meal')->first();

        if($length==8){
         $data=Invoice::find($success['opt_a']);
         $today = $data->first_pay_mealon;
         $from_day = getDaysBetween2Dates(new DateTime($payment_date), new DateTime($data->meal_start_date), false) + 2;
         if ($from_day < 1) {
             $fromday = 1;
         } else {
             $fromday = $from_day;
         }

       DB::update("update invoices set payment_status1 ='$status1', payment_time1='$paymenttime', payment_type1='Online' 
        ,payment_day1='$payment_day',payment_method1='$payment_method' where id ='$invoice_id' ");
       $invoice = Invoice::find($invoice_id);
       if($hallinfo->breakfast_status==1){
          for ($x = $fromday; $x <= $today; $x++) {
              $day = "b" . $x;
              $invoice->$day = $status1;
          }
         }
       
       if($hallinfo->lunch_status==1){
         for ($x = $fromday; $x <= $today; $x++) {
            $day = "l" . $x;
            $invoice->$day = $status1;
          }
       }

       if($hallinfo->dinner_status==1){
        for ($x = $fromday; $x <= $today; $x++) {
           $day = "d" . $x;
           $invoice->$day = $status1;
         }
       }
     $invoice->save();

   DB::update("update invoices set 
      payble_amount1=(CASE 
        WHEN first_pay_mealon<=0 THEN 0
        WHEN withdraw_status>=1 THEN  first_pay_mealamount+first_others_amount-inmeal_amount
        ELSE first_pay_mealamount+first_others_amount-(inmeal_amount+withdraw)  END),

     payble_amount2=(CASE 
        WHEN payment_status1>=1 THEN second_pay_mealamount+second_others_amount
        WHEN withdraw_status>=1 THEN cur_total_amount-inmeal_amount
        ELSE cur_total_amount-(inmeal_amount+withdraw)  END)
        where id ='$invoice_id'");

      $member=Member::where('id',$invoice->member_id)->first();
      $payment_status = "Paid";
      $subject="Payment 1 Invoice Summary: ".$invoice->invoice_year.'-'.$invoice->invoice_month.'-'.$invoice->invoice_section;
      $details = [
          'subject' =>$subject,
          'otp_code' =>255,
          'payment' => $data->payble_amount1,
          'payment_status' => $payment_status,
          'paymenttime' => $paymenttime,
          'paymenttype' =>'Online',
          'payment_method' =>$payment_method,
          'name' => 'ANCOVA',
        ];
       Mail::to($member->email)->send(new \App\Mail\paymentMail($details));   
   
        }else if($length==10){

        $data=Invoice::find($success['opt_a']);
        $today = $hallinfo->section_day;
        $from_day = getDaysBetween2Dates(new DateTime($payment_date), new DateTime($data->meal_start_date), false) + 2;
        if($from_day<1){
              $fromday = 1;
        }else{
              $fromday = $from_day;
        }

      DB::update("update invoices set payment_status2 ='$status1',payment_time2='$paymenttime', payment_type2='Online' 
       ,payment_day2='$payment_day' ,payment_method2='$payment_method' where id ='$invoice_id'");

        $invoice = Invoice::find($invoice_id);
        if($hallinfo->breakfast_status==1){
           for ($x = $fromday; $x <= $today; $x++) {
              $day = "b".$x;
              $invoice->$day = $status1;
            }
          }
         
         if($hallinfo->lunch_status==1){
            for ($x = $fromday; $x <= $today; $x++){
               $day = "l".$x;
               $invoice->$day = $status1;
             }
         }

         if($hallinfo->dinner_status==1){
            for ($x = $fromday; $x <= $today; $x++) {
               $day = "d".$x;
               $invoice->$day = $status1;
            }
         }
       $invoice->save();

    DB::update("update invoices set 
    first_pay_mealon=(CASE 
        WHEN  $hallinfo->first_payment_meal<=0 THEN 0 
        WHEN  $hallinfo->first_payment_meal<=breakfast_inmeal THEN 0 
        WHEN  payment_status1<=0 && payment_status2>=1 THEN 0   
        ELSE  $hallinfo->first_payment_meal  END),

      payble_amount1=(CASE 
         WHEN first_pay_mealon<=0 THEN 0
         WHEN withdraw_status>=1 THEN  first_pay_mealamount+first_others_amount-inmeal_amount
         ELSE first_pay_mealamount+first_others_amount-(inmeal_amount+withdraw)  END),

      payble_amount2=(CASE 
          WHEN payment_status1>=1 THEN second_pay_mealamount+second_others_amount
          WHEN withdraw_status>=1 THEN cur_total_amount-inmeal_amount
          ELSE cur_total_amount-(inmeal_amount+withdraw)  END)
          where id ='$invoice_id'");

          $member=Member::where('id',$invoice->member_id)->first();
          $subject="Payment 2 Invoice Summary: ".$invoice->invoice_year.'-'.$invoice->invoice_month.'-'.$invoice->invoice_section;
          $payment_status = "Paid";
          $details = [
              'subject' =>$subject,
              'otp_code' =>255,
              'payment' => $data->payble_amount2,
              'payment_status' => $payment_status,
              'paymenttype' =>'Online',
              'paymenttime' => $paymenttime,
              'payment_method' =>$payment_method,
              'name' => 'ANCOVA',
            ];
           Mail::to($member->email)->send(new \App\Mail\paymentMail($details));  
    


        }
     

      
      
       return view('web.payment_success');
    //  } catch (Exception $e) {
    //   return "Something Error. please try again"; }

   }
 
 
   public function amarpay_fail(Request $request)
   {
     try {
          $fail = $request;
          return view('web.payment_fail',["web_link" => $fail['opt_b']]);
      } catch (Exception $e) {
          return "Something Error. please try again";
      }
   }


   public function amarpay_cancel()
   {
     return 'Payment Canceled. Please try again';
   }



  }
 
 
 
   

 
