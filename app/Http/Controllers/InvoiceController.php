<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\validator;
use Exception;
use App\Models\Hallinfo;
use  DateTime;
use Illuminate\Support\Str;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{

  public function section_view(Request $request)
   {
       try {
             $hall_id = $request->header('hall_id');
             $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
             return view('manager.sectioninfo',['hallinfo'=>$hallinfo]);
         }catch (Exception $e) {  return  view('errors.error', ['error' => $e]);} 
    }


    public function section_view_id($id)
    {
        $value = Invoice::find($id);
        if ($value) {
            return response()->json([
                'status' => 200,
                'value' => $value,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found',
            ]);
        }
    }


    public function section_update_id(Request $request)
     {
        $validator = \Validator::make(
            $request->all(),
            [
                'hostel_fee' => 'required|numeric',
                'pre_reserve_amount' =>'required|numeric',
                'pre_refund' => 'required|numeric',
                'pre_monthdue' => 'required|numeric',  
            ],  
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
            $model = Invoice::find($request->input('edit_id'));
            if ($model) {
                $model->pre_reserve_amount = $request->input('pre_reserve_amount');
                $model->pre_refund = $request->input('pre_refund');
                $model->pre_monthdue = $request->input('pre_monthdue');
                $model->hostel_fee = $request->input('hostel_fee');
                $model->security = $request->input('security');
                $model->update();
                return response()->json([
                    'status' => 200,
                    'message' => ' Updated Successfull'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                ]);
            }
        }
    }


     
    public function section_fetch(Request $request)
    {
    
      $hall_id = $request->header('hall_id');
      $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
  
      $data = Invoice::leftjoin('members','members.id','=','invoices.member_id')
         ->Where('invoices.hall_id',$hall_id)->Where('invoices.invoice_year', $hallinfo->cur_year)
         ->Where('invoices.invoice_month', $hallinfo->cur_month)->Where('invoices.invoice_section', $hallinfo->cur_section)
         ->Where('invoices.invoice_status', 1)
         ->select('members.name','members.phone','members.registration','members.card', 'invoices.*')
         ->orderBy('registration','asc')
         ->paginate(10);
  
         return view('manager.section_data', compact('data'));
    }




    function section_fetch_data(Request $request)
     {
  
        $hall_id = $request->header('hall_id');
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
      
      if ($request->ajax()) {
         $sort_by = $request->get('sortby');
         $sort_type = $request->get('sorttype');
         $search = $request->get('search');
         $search = str_replace(" ", "%", $search);

        $data = Invoice::leftjoin('members','members.id', '=', 'invoices.member_id')
        ->Where('invoices.hall_id',$hall_id)->Where('invoices.invoice_year',$hallinfo->cur_year)
        ->Where('invoices.invoice_month',$hallinfo->cur_month)->Where('invoices.invoice_section',$hallinfo->cur_section)
        ->Where('invoices.invoice_status',1)
        ->where(function ($query) use ($search) {
            $query->where('members.card', 'like', '%' . $search . '%')
              ->orWhere('name', 'like', '%' . $search . '%')
              ->orWhere('registration', 'like', '%' . $search . '%')
              ->orWhere('invoices.id', 'like', '%' . $search . '%')
              ->orWhere('phone', 'like', '%' . $search . '%');
          })
          ->select('members.name', 'members.phone','members.registration','members.card', 'invoices.*')
          ->orderBy('registration','asc')
          ->paginate(10);
         return view('manager.section_data', compact('data'))->render();
      }

    }
   



    public function section_update(Request $request){

      try {

          $hall_id = $request->header('hall_id');
          $result= section_update($hall_id);

        
      return response()->json([
          'status'=>200,  
          'message'=>'Data Updated Successfull',
          'result'=>$result,
      ]); 
      
       } catch (\Exception $e) {
          DB::rollback();
          return response()->json([
           'status' => 'fail',
            'message' => 'Some error occurred. Please try again',
           ],200);
        }
    
        
   }


     public function mealsheet_view(Request $request)
     {
       try {
            $hall_id = $request->header('hall_id');
            $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->first();
            return view('manager.mealsheet',['data' => $hallinfo]);
           }catch (Exception $e) { return view('errors.error',['error'=>$e]);} 
       }


      public function mealsheet_fetch(Request $request)
      {
       
        $hall_id = $request->header('hall_id');
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
        $data = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
           ->Where('invoices.hall_id', $hall_id)->Where('invoices.invoice_year', $hallinfo->cur_year)
           ->Where('invoices.invoice_month', $hallinfo->cur_month)->Where('invoices.invoice_section', $hallinfo->cur_section)
           ->Where('invoices.invoice_status', 1)
           ->select('members.name','members.phone','members.registration','members.card', 'invoices.*')
           ->orderBy('registration', 'asc')
           ->paginate(10);
        return view('manager.mealsheet_data', compact('data'));
      }


      function mealsheet_fetch_data(Request $request)
      {
    
        $hall_id = $request->header('hall_id');
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();

        if ($request->ajax()) {
          $sort_by = $request->get('sortby');
          $sort_type = $request->get('sorttype');
          $search = $request->get('search');
          $search = str_replace(" ", "%", $search);
          $data = Invoice::leftjoin('members','members.id','=','invoices.member_id')
          ->Where('invoices.hall_id',$hall_id)->Where('invoices.invoice_year',$hallinfo->cur_year)
          ->Where('invoices.invoice_month', $hallinfo->cur_month)->Where('invoices.invoice_section', $hallinfo->cur_section)
          ->Where('invoices.invoice_status',1)
            ->where(function ($query) use ($search) {
                $query->where('card', 'like', '%' . $search . '%')
                ->orWhere('registration', 'like', '%' . $search . '%');
            })
            ->select('members.name', 'members.phone','members.registration','members.card', 'invoices.*')
            ->orderBy($sort_by, $sort_type)
            ->paginate(10);
          return view('manager.mealsheet_data', compact('data'))->render();
        }
      }


      public function mealsheet_view_id($id)
      {
        $value = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
          ->Where('invoices.id', $id)->select('members.name', 'members.phone','members.registration','members.card', 'invoices.*')->first();
        if ($value) {
          return response()->json([
            'status' => 200,
            'value' => $value,
          ]);
        } else {
          return response()->json([
            'status' => 404,
            'message' => 'Invoice not found',
          ]);
        }
      }
  
  


      public function mealupdate(Request $request)
      {
     
          $hall_id = $request->header('hall_id');
          $data=Hallinfo::where('hall_id_info',$hall_id)->first();

          $invoice = Invoice::find($request->input('id'));

          $invoice->b1 = empty($data->date1) ? 0 : $request->input('b1');
          $invoice->b2 = empty($data->date2) ? 0 : $request->input('b2');
          $invoice->b3 = empty($data->date3) ? 0 : $request->input('b3');
          $invoice->b4 = empty($data->date4) ? 0 : $request->input('b4');
          $invoice->b5 = empty($data->date5) ? 0 : $request->input('b5');
          $invoice->b6 = empty($data->date6) ? 0 : $request->input('b6');
          $invoice->b7 = empty($data->date7) ? 0 : $request->input('b7');
          $invoice->b8 = empty($data->date8) ? 0 : $request->input('b8');
          $invoice->b9 = empty($data->date9) ? 0 : $request->input('b9');
          $invoice->b10 = empty($data->date10) ? 0 : $request->input('b10');
          $invoice->b11 = empty($data->date11) ? 0 : $request->input('b11');
          $invoice->b12 = empty($data->date12) ? 0 : $request->input('b12');
          $invoice->b13 = empty($data->date13) ? 0 : $request->input('b13');
          $invoice->b14 = empty($data->date14) ? 0 : $request->input('b14');
          $invoice->b15 = empty($data->date15) ? 0 : $request->input('b15');
          $invoice->b16 = empty($data->date16) ? 0 : $request->input('b16');
          $invoice->b17 = empty($data->date17) ? 0 : $request->input('b17');
          $invoice->b18 = empty($data->date18) ? 0 : $request->input('b18');
          $invoice->b19 = empty($data->date19) ? 0 : $request->input('b19');
          $invoice->b20 = empty($data->date20) ? 0 : $request->input('b20');
          $invoice->b21 = empty($data->date21) ? 0 : $request->input('b21');
          $invoice->b22 = empty($data->date22) ? 0 : $request->input('b22');
          $invoice->b23 = empty($data->date23) ? 0 : $request->input('b23');
          $invoice->b24 = empty($data->date24) ? 0 : $request->input('b24');
          $invoice->b25 = empty($data->date25) ? 0 : $request->input('b25');
          $invoice->b26 = empty($data->date26) ? 0 : $request->input('b26');
          $invoice->b27 = empty($data->date27) ? 0 : $request->input('b27');
          $invoice->b28 = empty($data->date28) ? 0 : $request->input('b28');
          $invoice->b29 = empty($data->date29) ? 0 : $request->input('b29');
          $invoice->b30 = empty($data->date30) ? 0 : $request->input('b30');
          $invoice->b31 = empty($data->date31) ? 0 : $request->input('b31');


          $invoice->l1 = empty($data->date1) ? 0 : $request->input('l1');
          $invoice->l2 = empty($data->date2) ? 0 : $request->input('l2');
          $invoice->l3 = empty($data->date3) ? 0 : $request->input('l3');
          $invoice->l4 = empty($data->date4) ? 0 : $request->input('l4');
          $invoice->l5 = empty($data->date5) ? 0 : $request->input('l5');
          $invoice->l6 = empty($data->date6) ? 0 : $request->input('l6');
          $invoice->l7 = empty($data->date7) ? 0 : $request->input('l7');
          $invoice->l8 = empty($data->date8) ? 0 : $request->input('l8');
          $invoice->l9 = empty($data->date9) ? 0 : $request->input('l9');
          $invoice->l10 = empty($data->date10) ? 0 : $request->input('l10');
          $invoice->l11 = empty($data->date11) ? 0 : $request->input('l11');
          $invoice->l12 = empty($data->date12) ? 0 : $request->input('l12');
          $invoice->l13 = empty($data->date13) ? 0 : $request->input('l13');
          $invoice->l14 = empty($data->date14) ? 0 : $request->input('l14');
          $invoice->l15 = empty($data->date15) ? 0 : $request->input('l15');
          $invoice->l16 = empty($data->date16) ? 0 : $request->input('l16');
          $invoice->l17 = empty($data->date17) ? 0 : $request->input('l17');
          $invoice->l18 = empty($data->date18) ? 0 : $request->input('l18');
          $invoice->l19 = empty($data->date19) ? 0 : $request->input('l19');
          $invoice->l20 = empty($data->date20) ? 0 : $request->input('l20');
          $invoice->l21 = empty($data->date21) ? 0 : $request->input('l21');
          $invoice->l22 = empty($data->date22) ? 0 : $request->input('l22');
          $invoice->l23 = empty($data->date23) ? 0 : $request->input('l23');
          $invoice->l24 = empty($data->date24) ? 0 : $request->input('l24');
          $invoice->l25 = empty($data->date25) ? 0 : $request->input('l25');
          $invoice->l26 = empty($data->date26) ? 0 : $request->input('l26');
          $invoice->l27 = empty($data->date27) ? 0 : $request->input('l27');
          $invoice->l28 = empty($data->date28) ? 0 : $request->input('l28');
          $invoice->l29 = empty($data->date29) ? 0 : $request->input('l29');
          $invoice->l30 = empty($data->date30) ? 0 : $request->input('l30');
          $invoice->l31 = empty($data->date31) ? 0 : $request->input('l31');


          $invoice->d1 = empty($data->date1) ? 0 : $request->input('d1');
          $invoice->d2 = empty($data->date2) ? 0 : $request->input('d2');
          $invoice->d3 = empty($data->date3) ? 0 : $request->input('d3');
          $invoice->d4 = empty($data->date4) ? 0 : $request->input('d4');
          $invoice->d5 = empty($data->date5) ? 0 : $request->input('d5');
          $invoice->d6 = empty($data->date6) ? 0 : $request->input('d6');
          $invoice->d7 = empty($data->date7) ? 0 : $request->input('d7');
          $invoice->d8 = empty($data->date8) ? 0 : $request->input('d8');
          $invoice->d9 = empty($data->date9) ? 0 : $request->input('d9');
          $invoice->d10 = empty($data->date10) ? 0 : $request->input('d10');
          $invoice->d11 = empty($data->date11) ? 0 : $request->input('d11');
          $invoice->d12 = empty($data->date12) ? 0 : $request->input('d12');
          $invoice->d13 = empty($data->date13) ? 0 : $request->input('d13');
          $invoice->d14 = empty($data->date14) ? 0 : $request->input('d14');
          $invoice->d15 = empty($data->date15) ? 0 : $request->input('d15');
          $invoice->d16 = empty($data->date16) ? 0 : $request->input('d16');
          $invoice->d17 = empty($data->date17) ? 0 : $request->input('d17');
          $invoice->d18 = empty($data->date18) ? 0 : $request->input('d18');
          $invoice->d19 = empty($data->date19) ? 0 : $request->input('d19');
          $invoice->d20 = empty($data->date20) ? 0 : $request->input('d20');
          $invoice->d21 = empty($data->date21) ? 0 : $request->input('d21');
          $invoice->d22 = empty($data->date22) ? 0 : $request->input('d22');
          $invoice->d23 = empty($data->date23) ? 0 : $request->input('d23');
          $invoice->d24 = empty($data->date24) ? 0 : $request->input('d24');
          $invoice->d25 = empty($data->date25) ? 0 : $request->input('d25');
          $invoice->d26 = empty($data->date26) ? 0 : $request->input('d26');
          $invoice->d27 = empty($data->date27) ? 0 : $request->input('d27');
          $invoice->d28 = empty($data->date28) ? 0 : $request->input('d28');
          $invoice->d29 = empty($data->date29) ? 0 : $request->input('d29');
          $invoice->d30 = empty($data->date30) ? 0 : $request->input('d30');
          $invoice->d31 = empty($data->date31) ? 0 : $request->input('d31');
          
          $invoice->pre_meeting_present =$request->input('pre_meeting_present');
          $invoice->meeting_present =$request->input('meeting_present');
          $invoice->update();

          member_meal_update($invoice);
    
          return response()->json([
            'status' => 404,
            'message' => 'data Updated',
    
          ]);
      }


      public function payment_view(Request $request , $invoice_status)
      {
          try{
               $hall_id = $request->header('hall_id');
               $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
               return view('manager.payment',['hallinfo'=>$hallinfo,'invoice_status'=>$invoice_status]);

            }catch (Exception $e) {  return  view('errors.error', ['error' => $e]);} 
       }


       public function payment_fetch(Request $request, $invoice_status)
       {
         $hall_id = $request->header('hall_id');
         $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
         $data = Invoice::leftjoin('members', 'members.id','=','invoices.member_id')
           ->Where('invoices.hall_id', $hall_id)->Where('invoices.invoice_year', $hallinfo->cur_year)->Where('invoices.invoice_status',$invoice_status)
           ->Where('invoices.invoice_month', $hallinfo->cur_month)->Where('invoices.invoice_section', $hallinfo->cur_section)
           ->select('members.name','members.phone','members.registration','members.card','invoices.*')
           ->orderBy('registration','asc')
           ->paginate(10);
     
           return view('manager.payment_data', ['data'=>$data, 'invoice_status'=>$invoice_status]);
       }


       function payment_fetch_data(Request $request , $invoice_status)
       {
           $hall_id=$request->header('hall_id');
           $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
         
         if ($request->ajax()) {
           $sort_by = $request->get('sortby');
           $sort_type = $request->get('sorttype');
           $search = $request->get('search');
           $search = str_replace(" ", "%", $search);
   
           $data = Invoice::leftjoin('members','members.id','=','invoices.member_id')
           ->Where('invoices.hall_id',$hall_id)->Where('invoices.invoice_year', $hallinfo->cur_year)->Where('invoices.invoice_status',1)
           ->Where('invoices.invoice_month',$hallinfo->cur_month)->Where('invoices.invoice_section',$hallinfo->cur_section)
           ->where(function ($query) use ($search) {
               $query->where('members.card', 'like', '%' . $search . '%')
                 ->orWhere('name', 'like', '%' . $search . '%')
                 ->orWhere('registration', 'like', '%' . $search . '%')
                 ->orWhere('invoices.id', 'like', '%' . $search . '%')
                 ->orWhere('phone', 'like', '%' . $search . '%');
             })
             ->select('members.name', 'members.phone','members.registration','members.card', 'invoices.*')
             ->orderBy($sort_by,$sort_type)
             ->paginate(10);
            return view('manager.payment_data', ['data'=>$data, 'invoice_status'=>$invoice_status])->render();
         }
   
       }



       public function payment1_view($id)
       {
        $value = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
        ->Where('invoices.id', $id)->select('members.name', 'members.phone','members.registration','members.card', 'invoices.id'
        , 'invoices.payble_amount1' ,'invoices.payble_amount2' ,'invoices.withdraw')->first();
         if ($value) {
           return response()->json([
             'status' =>200,
             'value' =>$value,
           ]);
         } else {
           return response()->json([
             'status' =>404,
             'message' =>'Student not found',
           ]);
         }
       }
      

       public function payment1_update(Request $request)
       {

        DB::beginTransaction();
          try {

         $manager_username = $request->header('manager_username');
         $hall_id = $request->header('hall_id');
         $id = $request->input('payment1_id');
         $data = Invoice::Where('invoices.id', $id)->select('payble_amount1','payment_status1' ,'payment_time1','payment_type1','payment_type2'
         ,'payble_amount2' ,'payment_status2' ,'withdraw' ,'withdraw_status','meal_start_date','first_pay_mealon')->first();

        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('section_day','unpaid_day','breakfast_rate','lunch_rate'
         ,'dinner_rate','breakfast_status','lunch_status','dinner_status')->first();
     
         if ($data->payment_status1 == 1) {
             $status1 = 0;
             $paymenttime = date('2010-10-10 10:10:10');
             $paymenttype = 'Offline';
             $payment_method = $manager_username;
             $mealstatus = 0;
             $payment_status = "Unpaid";
           } else {
             $status1 = 1;
             $paymenttime = date('Y-m-d H:i:s');
             $paymenttype = 'Offline';
             $payment_method = $manager_username;
             $mealstatus = 1;
             $payment_status = "paid";
           }
     
           $payment_date = date('Y-m-d');
           $payment_day = date('j');
           $today = $data->first_pay_mealon;
           $unpaid_day = $hallinfo->unpaid_day;
           $current_time = date('Y-m-d H:i:s');
     
           $from_day = getDaysBetween2Dates(new DateTime($payment_date), new DateTime($data->meal_start_date), false) + 2;
           if ($from_day < 1) {
               $fromday = 1;
           } else {
               $fromday = $from_day;
           }
     
          if($data->payment_status1  == 1 && (strtotime($current_time)-strtotime($data->payment_time1)) >= ($unpaid_day*60*60)) {
               return response()->json([
                   'status' => 300,
                   'message' => 'You can not Unpaid this Invoice because time over Or Seccond Payment has already been paid',
                 ]);
           }else if($fromday>=$today){
                return response()->json([
                    'status' => 400,
                    'message' => 'First Payment Time Over. Please pay second payment',
                ]);
           }else if($data->payment_status2==1){
               return response()->json([
                   'status' => 400,
                   'message' =>  'You can not Unpaid this Invoice because Seccond Payment has already been paid',
              ]);
          }else if($data->payment_status1==1 && $data->payment_type1=="Online"){
             return response()->json([
                  'status' => 400,
                  'message' =>  'You can not Unpaid this Invoice because Online Payment already Exist',
             ]);
           }else{ 
             DB::update("update invoices set payment_status1 ='$status1' , payment_time1='$paymenttime',payment_type1='$paymenttype' 
                 ,payment_day1='$payment_day',payment_date1='$payment_date' ,payment_method1='$payment_method' where id ='$id' ");
              $invoice = Invoice::find($id);
              if($hallinfo->breakfast_status==1){
                 for ($x = $fromday; $x <= $today; $x++) {
                    $day = "b" . $x;
                    $invoice->$day = $mealstatus;
                 }
                }
               
               if($hallinfo->lunch_status==1){
                 for ($x = $fromday; $x <= $today; $x++) {
                    $day = "l" . $x;
                    $invoice->$day = $mealstatus;
                  }
               }

               if($hallinfo->dinner_status==1){
                for ($x = $fromday; $x <= $today; $x++) {
                   $day = "d" . $x;
                   $invoice->$day = $mealstatus;
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
                where id ='$id'");

              $member=Member::where('id',$invoice->member_id)->first();
              //member_meal_update(Invoice::find($id));

              $subject="Payment 1 Invoice Summary: ".$invoice->invoice_year.'-'.$invoice->invoice_month.'-'.$invoice->invoice_section;
              $details = [
                  'subject' =>$subject,
                  'otp_code' =>255,
                  'payment' => $data->payble_amount1,
                  'payment_status' => $payment_status,
                  'paymenttime' => $paymenttime,
                  'paymenttype' =>'Offline',
                  'payment_method' =>$payment_method,
                  'name' => 'ANCOVA',
                ];
             // Mail::to($member->email)->send(new \App\Mail\paymentMail($details));   
           $mess = "Invoice No: " . $id . "Card No: " . $member->card . ".  First Payable Amount  " . $data->payble_amount1 . "TK " . $payment_status;
           
           DB::commit();  
           return response()->json([
               'status' => 200,
               'message' => $mess,
             ]);
          }

      
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json([
            'status' => 'fail',
          'message' => 'Some error occurred. Please try again',
        ],200);
     }  
       
       }


       public function payment2_update(Request $request)
       {

        DB::beginTransaction();
          try {
         $manager_username = $request->header('manager_username');
         $hall_id = $request->header('hall_id');
         $id = $request->input('payment2_id');
     $data = Invoice::Where('invoices.id', $id)->select('payble_amount1','payment_status1' ,'payment_time1','payment_type1','payment_type2'
      ,'payble_amount2' ,'payment_status2' ,'withdraw' ,'withdraw_status','meal_start_date','first_pay_mealon','payment_time2')->first();

        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('section_day','unpaid_day','breakfast_rate','breakfast_status',
        'lunch_rate','lunch_status','dinner_rate','dinner_status','first_payment_meal')->first();
     
         if($data->payment_status2==1) {
             $status1 = 0;
             $paymenttime = date('2010-10-10 10:10:10');
             $paymenttype = 'Offline';
             $payment_method = $manager_username;
             $mealstatus = 0;
             $payment_status = "Unpaid";
           } else {
             $status1 = 1;
             $paymenttime = date('Y-m-d H:i:s');
             $paymenttype = 'Offline';
             $payment_method = $manager_username;
             $mealstatus = 1;
             $payment_status = "Paid";
           }
     
           $payment_date = date('Y-m-d');
           $payment_day = date('j');
           $today = $hallinfo->section_day;
           $unpaid_day = $hallinfo->unpaid_day;
           $current_time = date('Y-m-d H:i:s');
     
           $from_day = getDaysBetween2Dates(new DateTime($payment_date), new DateTime($data->meal_start_date), false) + 2;
           if ($from_day < 1) {
               $fromday = 1;
           } else {
               $fromday = $from_day;
           }
     
          if($data->payment_status2 == 1 && (strtotime($current_time)-strtotime($data->payment_time2)) >= ($unpaid_day*60*60)) {
                return response()->json([
                    'status' => 300,
                    'message' => 'You can not Unpaid this Invoice because time over',
                  ]);
           }else if($fromday>=$today){
                return response()->json([
                    'status' => 400,
                    'message' => 'Second Payment Time Over',
                ]);

           }else if($data->payment_status2==1 && $data->payment_type2=="Online"){
               return response()->json([
                  'status' => 400,
                  'message' =>  'You can not Unpaid this Invoice because Online Payment already Exist',
               ]);
           } else{ 
             DB::update("update invoices set payment_status2 ='$status1',payment_time2='$paymenttime',payment_type2='$paymenttype' 
                ,payment_day2='$payment_day' ,payment_date2='$payment_date' ,payment_method2='$payment_method' where id ='$id'");

              $invoice = Invoice::find($id);
              if($hallinfo->breakfast_status==1){
                 for ($x = $fromday; $x <= $today; $x++) {
                    $day = "b".$x;
                    $invoice->$day = $mealstatus;
                  }
                }
               
               if($hallinfo->lunch_status==1){
                  for ($x = $fromday; $x <= $today; $x++){
                     $day = "l".$x;
                     $invoice->$day = $mealstatus;
                   }
               }

               if($hallinfo->dinner_status==1){
                  for ($x = $fromday; $x <= $today; $x++) {
                     $day = "d".$x;
                     $invoice->$day = $mealstatus;
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
                where id ='$id'");

                $member=Member::where('id',$invoice->member_id)->first();
                $subject="Payment 2 Invoice Summary: ".$invoice->invoice_year.'-'.$invoice->invoice_month.'-'.$invoice->invoice_section;
                $details = [
                    'subject' =>$subject,
                    'otp_code' =>255,
                    'payment' => $data->payble_amount2,
                    'payment_status' => $payment_status,
                    'paymenttype' =>'Offline',
                    'paymenttime' => $paymenttime,
                    'payment_method' =>$payment_method,
                    'name' => 'ANCOVA',
                  ];
               //  Mail::to($member->email)->send(new \App\Mail\paymentMail($details));  
                // member_meal_update(Invoice::find($id));
            $mess = " Invoice No : " . $id ." Card No: " . $member->card . ".  Second Payable Amount  " . $data->payble_amount2 . "TK " . $payment_status;
             
            DB::commit();  
            return response()->json([
                'status' => 200,
                'message' => $mess,
             ]);

          }

        } catch (\Exception $e) {
          DB::rollback();
          return response()->json([
            'status' => 'fail',
          'message' => 'Some error occurred. Please try again',
        ],200);

           }
       }


       public function withdraw_update(Request $request) { 
        DB::beginTransaction();
        try {
         $manager_username = $request->header('manager_username');
         $hall_id = $request->header('hall_id');
        
         $id = $request->input('withdraw_id');
         $data = Invoice::Where('id', $id)->select('payble_amount1','payment_status1' ,'payment_time1' ,'payment_time2' ,'invoice_status'
             ,'payble_amount2' ,'payment_status2' ,'withdraw' ,'withdraw_status','withdraw_time','meal_start_date'
             ,'first_pay_mealon','invoice_year','invoice_month','invoice_section')->first();

         $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','section_day','unpaid_day','breakfast_rate','lunch_rate','dinner_rate','first_payment_meal')->first();
     
         if($data->withdraw_status == 1) {
             $status1 = 0;
             $paymenttime = date('2010-10-10 10:10:10');
             $paymenttype = '';
             $mealstatus = 0;
             $payment_status = "Unpaid";
           } else {
             $status1 = 1;
             $paymenttime = date('Y-m-d H:i:s');
             $paymenttype = $manager_username;
             $payment_status = "Paid";
           }
     
           $payment_date = date('Y-m-d');
           $payment_day = date('j');
      
      if($data->payment_status1==1 || $data->payment_status2==1){
         return response()->json([
            'status' => 200,
            'message' => 'You can not refund withdraw beacuse 1st or 2nd payment already paid',
          ]);

       }else if($data->withdraw<=0 && $data->invoice_status==1){
            return response()->json([
                'status' => 200,
                'message' => 'You can not refund withdraw beacuse withdraw amount negative',
            ]);
         }else if($hallinfo->cur_section==$data->invoice_section && 
                  $hallinfo->cur_year==$data->invoice_year &&
                  $hallinfo->cur_month==$data->invoice_month){


              DB::update("update invoices set withdraw_status ='$status1' , withdraw_time='$paymenttime',withdraw_type='$paymenttype' 
              ,withdraw_day='$payment_day' where id ='$id'");
    
      
              DB::update("update invoices set 
              payble_amount=(CASE 
              WHEN withdraw_status>=1 THEN cur_total_amount-inmeal_amount 
              ELSE cur_total_amount-(inmeal_amount+withdraw)  END),
    
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
                    where id ='$id'");
    
                  $mess = " Invoice No: " . $id . ".  Withdraw Amount  " . $data->withdraw . "TK " . $payment_status;
                
                  DB::commit();  
                  return response()->json([
                    'status' => 200,
                    'message' => $mess,
                  ]);
      
         } else {
              return response()->json([
                   'status' => 200,
                   'message' => 'Current Module Does Not Match',
                 ]);
           }

           } catch (\Exception $e) {
             DB::rollback();
             return response()->json([
               'status' => 'fail',
              'message' => 'Some error occurred. Please try again',
           ],200);
        }
       
       }



    public function payment_show($id)
      {
      $value = Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
       ->Where('invoices.id', $id)->select('members.name', 'members.phone','members.registration','members.card' ,'invoices.*')->first();
         if ($value) {
           return response()->json([
             'status' =>200,
             'value' =>$value,
           ]);
         } else {
           return response()->json([
             'status' =>404,
             'message' =>'Student not found',
           ]);
         }
       }


       public function ex_payment_view(Request $request , $invoice_status)
       {
           try{
                $hall_id = $request->header('hall_id');
                $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
                return view('manager.ex_payment',['hallinfo'=>$hallinfo,'invoice_status'=>$invoice_status]);
             }catch (Exception $e) {  return  view('errors.error', ['error' => $e]);} 
        }
 
 
        public function ex_payment_fetch(Request $request, $invoice_status)
         {
           $hall_id = $request->header('hall_id');
           $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
             $data = Invoice::leftjoin('members', 'members.id','=','invoices.member_id')
              ->Where('invoices.hall_id',$hall_id)->Where('members.member_status',5)
              ->Where('invoices.invoice_status',5)
              ->select('members.name','members.phone','members.registration','members.card','invoices.*')
              ->orderBy('id','desc')
              ->paginate(10);
             return view('manager.ex_payment_data', ['hallinfo'=>$hallinfo,'data'=>$data,'invoice_status'=>$invoice_status]);
        }
 
 
        function ex_payment_fetch_data(Request $request , $invoice_status)
        {
            $hall_id=$request->header('hall_id');
            $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
          
        if($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
    
            $data = Invoice::leftjoin('members','members.id','=','invoices.member_id')
              ->Where('invoices.hall_id',$hall_id)->Where('members.member_status',5)
              ->Where('invoices.invoice_status',5)->where(function ($query) use ($search) {
                 $query->where('members.card', 'like', '%' . $search . '%')
                   ->orWhere('name', 'like', '%' . $search . '%')
                   ->orWhere('registration', 'like', '%' . $search . '%')
                   ->orWhere('invoices.id', 'like', '%' . $search . '%')
                   ->orWhere('phone', 'like', '%' . $search . '%');
               })->select('members.name', 'members.phone','members.registration','members.card', 'invoices.*')
               ->orderBy($sort_by,$sort_type)
               ->paginate(10);
              return view('manager.ex_payment_data', ['data'=>$data,'hallinfo'=>$hallinfo,'invoice_status'=>$invoice_status])->render();
          }
        }
 
 
        public function ex_payment_delete(Request $request , $id){
          try{ 
            $data = Invoice::find($id);
            $data->delete();
            return back()->with('success','Data Deleted');  
          } catch (Exception $e) {  return  view('errors.error', ['error' => $e]);  }
      }




    //   public function member_block(Request $request)
    //   {
    //     $manager_username = $request->header('manager_username');
    //     $hall_id = $request->header('hall_id');
    //     $id = $request->input('member_block_id');
    //     $data = Invoice::Where('id', $id)->select('payble_amount1','payment_status1' ,'payment_time1' ,'payment_time2' ,'invoice_status'
    //         ,'payble_amount2' ,'payment_status2' ,'withdraw' ,'withdraw_status','withdraw_time','meal_start_date','first_pay_mealon','block_status')->first();

    //     $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('section_day','unpaid_day','breakfast_rate','lunch_rate','dinner_rate','first_payment_meal')->first();
    
    //     if($data->block_status == 1) {
    //         $status1 = 0;
    //       } else {
    //         $status1 = 1;
    //       }

    // //  if($data->payment_status1==1 || $data->payment_status2==1){
    // //     return response()->json([
    // //        'status' => 200,
    // //        'message' => 'You can not refund withdraw beacuse 1st or 2nd payment already paid',
    // //      ]);

    // //   }else{
    //       DB::update("update invoices set block_status ='$status1'  where id ='$id'");

    //         return response()->json([
    //           'status' => 200,
    //           'message' => 'Data saved successfully',
    //         ]);

    //       // }
    //   }

    public function payment_link_view(Request $request)
     {
        try {
              $hall_id = $request->header('hall_id');
              $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
              return view('manager.payment_link',['hallinfo'=>$hallinfo]);
          }catch (Exception $e) {  return  view('errors.error', ['error' => $e]);} 
      }



      public function payment_link_fetch(Request $request)
      {
      
        $hall_id = $request->header('hall_id');
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
    
        $data = Invoice::leftjoin('members','members.id','=','invoices.member_id')
           ->Where('invoices.hall_id',$hall_id)->Where('invoices.invoice_year', $hallinfo->cur_year)
           ->Where('invoices.invoice_month', $hallinfo->cur_month)->Where('invoices.invoice_section', $hallinfo->cur_section)
           ->Where('invoices.invoice_status',1)
           ->select('members.name','members.phone','members.registration','members.card', 'invoices.*')
           ->orderBy('card','asc')
           ->paginate(10);
    
           return view('manager.payment_link_data', compact('data'));
      }
  

      function payment_link_fetch_data(Request $request)
      {
          $hall_id = $request->header('hall_id');
          $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
        
        if($request->ajax()) {
           $sort_by = $request->get('sortby');
           $sort_type = $request->get('sorttype');
           $search = $request->get('search');
           $search = str_replace(" ", "%", $search);
  
          $data = Invoice::leftjoin('members','members.id', '=', 'invoices.member_id')
          ->Where('invoices.hall_id',$hall_id)->Where('invoices.invoice_year', $hallinfo->cur_year)
          ->Where('invoices.invoice_month', $hallinfo->cur_month)->Where('invoices.invoice_section', $hallinfo->cur_section)
          ->Where('invoices.invoice_status', 1)
          ->where(function ($query) use ($search) {
              $query->where('members.card', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->orWhere('registration', 'like', '%' . $search . '%')
                ->orWhere('invoices.id', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->select('members.name', 'members.phone','members.registration','members.card', 'invoices.*')
            ->orderBy('card','asc')
            ->paginate(10);
           return view('manager.payment_link_data', compact('data'))->render();
        }
  
      }
     
  

      public function module_summary_view(Request $request)
      {
       // try {

        $hall_id = $request->header('hall_id');
         
        $data = Invoice::Where('invoices.hall_id',$hall_id)->Where('invoices.invoice_status',1)
        ->select('meal_start_date',DB::raw('count(id) as id_total'),DB::raw('sum(pre_refund) as pre_refund')
        ,DB::raw('max(invoice_month) as invoice_month') ,DB::raw('max(invoice_year) as invoice_year')
        ,DB::raw('max(invoice_section) as invoice_section'),DB::raw('sum(pre_monthdue) as pre_monthdue')
        ,DB::raw('sum(pre_refund) as pre_refund')
        ,DB::raw('sum(pre_reserve_amount) as pre_reserve_amount') ,DB::raw('max(section_day) as section_day')
        ,DB::raw('sum(case when payment_status1 > 0 and payble_amount1 > 0 then payble_amount1 else 0 end) as payble_amount1')
        ,DB::raw('sum(case when payment_status2 > 0 and payble_amount2 > 0 then payble_amount2 else 0 end) as payble_amount2')
        ,DB::raw('sum(total_due) as total_due')
        ,DB::raw('sum(reserve_amount) as reserve_amount')
        ,DB::raw('sum(total_refund) as total_refund')
        ,DB::raw('max(meal_end_date) as meal_end_date') 
        ,DB::raw('max(hall_id) as hall_id') 
        )->orderBy('meal_start_date','desc')->groupBy('meal_start_date')->get();

      
          return view('manager.module_summary',['data'=>$data]);
          // }catch (Exception $e) {  return  view('errors.error', ['error' => $e]);} 
          }
 
 
   
    
}
