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
          ->orderBy('registration','asc')
          ->paginate(10);
         return view('manager.section_data', compact('data'))->render();
      }

    }
   



    public function section_update(Request $request){

       $hall_id = $request->header('hall_id');
       $data=Hallinfo::where('hall_id_info',$hall_id)->first();
       $friday1=$data->friday1;
       $friday2=$data->friday2;
       $friday3=$data->friday3;
       $friday4=$data->friday4;
       $friday5=$data->friday5;
       $feast_day=$data->feast_day;
     
       $friday1t=$data->friday1t;
       $friday2t=$data->friday2t;
       $friday3t=$data->friday3t;
       $friday4t=$data->friday4t;
       $friday5t=$data->friday5t;
       $feast=$data->feast;

       $invoice = Invoice::where('invoice_month',$data->cur_month)->where('invoice_year',$data->cur_year)
          ->where('invoice_section',$data->cur_section)->where('invoice_status',1)->where('hall_id',$hall_id)->get();

       $payment_date = date('Y-m-d');
       $inactive_day1 = getDaysBetween2Dates(new DateTime($payment_date), new DateTime($data->meal_start_date), false) + 1;
       if($inactive_day1<=31){
             $inactive_day=$inactive_day1;
       }else{
             $inactive_day=31;
        }

       foreach($invoice as $row){
               $lunch_off=0;
               $dinner_off=0;
               $breakfast_off=0;
               $lunch_on=0;
               $dinner_on=0;
               $breakfast_on=0;

                  for($y = 1; $y <= $data->section_day; $y++) {
                       $l_off=Invoice::where('id',$row->id)->where('l'.$y,0)->count(); 
                       $lunch_off+=$l_off;
    
                       $l_on=Invoice::where('id',$row->id)->where('l'.$y,1)->count(); 
                       $lunch_on+=$l_on;
                    }

                   for($y = 1; $y <= $data->section_day; $y++) {
                          $d=Invoice::where('id',$row->id)->where('d'.$y,0)->count(); 
                          $dinner_off+=$d;
        
                          $d_on=Invoice::where('id',$row->id)->where('d'.$y,1)->count(); 
                          $dinner_on+=$d_on;
                      }


                      for($y = 1; $y <= $data->section_day; $y++) {
                            $b=Invoice::where('id',$row->id)->where('b'.$y,0)->count(); 
                            $breakfast_off+=$b;

                            $b_on=Invoice::where('id',$row->id)->where('b'.$y,1)->count(); 
                            $breakfast_on+=$b_on;
                       }


                $invoiceupdate = Invoice::find($row->id);
                $invoiceupdate->lunch_offmeal = $lunch_off;
                $invoiceupdate->lunch_onmeal = $lunch_on;
                $invoiceupdate->lunch_inmeal = $data->section_day-($lunch_off+$lunch_on);
                $invoiceupdate->dinner_offmeal = $dinner_off;
                $invoiceupdate->dinner_onmeal = $dinner_on;
                $invoiceupdate->dinner_inmeal = $data->section_day-($dinner_off+$dinner_on);
                $invoiceupdate->breakfast_offmeal = $breakfast_off;
                $invoiceupdate->breakfast_onmeal = $breakfast_on;
                $invoiceupdate->breakfast_inmeal = $data->section_day-($breakfast_off+$breakfast_on);
            if($invoiceupdate->payment_status1==1 || $invoiceupdate->payment_status2==1 || $invoiceupdate->onmeal_amount>1){

             }else{ 
                
                      for($y=$inactive_day;$y>=1; $y--){ 
                           $day = "b" . $y;
                        if($invoiceupdate->breakfast_rate>0){
                              $invoiceupdate->$day = 9;
                            }else{
                              $invoiceupdate->$day = 0;
                            }
                         }

                       for($y=$inactive_day;$y>=1; $y--){ 
                             $day = "l" . $y;
                           if($invoiceupdate->lunch_rate>0){
                               $invoiceupdate->$day = 9;
                            }else{
                               $invoiceupdate->$day = 0;
                            }
                        } 
                         
                    for($y=$inactive_day;$y>=1; $y--){ 
                        $day = "d" . $y;
                          if($invoiceupdate->dinner_rate>0){
                              $invoiceupdate->$day = 9;
                          }else{
                             $invoiceupdate->$day = 0;
                          }
                     }
                  }
                
                $invoiceupdate->save();

            }
        
    if($data->first_payment_meal>0){
              if($data->fridayf==1){$friday_value=$data->friday;}else{$friday_value=0;}
              if($data->feastf==1){$feast_value=$data->feast;}else{$feast_value=0;}
              if($data->welfaref==1){$welfare_value=$data->welfare;}else{$welfare_value=0;}
              if($data->othersf==1){$others_value=$data->others;}else{$others_value=0;}
              if($data->waterf==1){$water_value=$data->water;}else{$water_value=0;}
              if($data->wifif==1){$wifi_value=$data->wifi;}else{$wifi_value=0;}
              if($data->dirtf==1){$dirt_value=$data->dirt;}else{$dirt_value=0;}
              if($data->gassf==1){$gass_value=$data->gass;}else{$gass_value=0;}
              if($data->electricityf==1){$electricity_value=$data->electricity;}else{$electricity_value=0;}
              if($data->tissuef==1){$tissue_value=$data->tissue;}else{$tissue_value=0;}
              if($data->employeef==1){$employee_value=$data->employee;}else{$employee_value=0;}
  
             $first_others_amount=$friday_value+$feast_value+$welfare_value+$others_value+$water_value+$wifi_value+$dirt_value
                +$gass_value+$electricity_value+$tissue_value+$employee_value;
        }else{
             $first_others_amount=0;
        }
   
       
       $cur_meal_amount=($data->section_day*($data->breakfast_rate+$data->lunch_rate+$data->dinner_rate));
      
      DB::update(
          "update invoices set  
           breakfast_rate='$data->breakfast_rate',
           lunch_rate='$data->lunch_rate',
           dinner_rate='$data->dinner_rate',
           breakfast_status='$data->breakfast_status',
           lunch_status='$data->lunch_status',
           dinner_status='$data->dinner_status',
           refund_breakfast_rate='$data->refund_breakfast_rate',
           refund_lunch_rate='$data->refund_lunch_rate',
           refund_dinner_rate='$data->refund_dinner_rate',
           friday='$data->friday',
           section_day='$data->section_day',
           employee='$data->employee',
           feast='$data->feast',
           welfare='$data->welfare',
           others='$data->others',
           water='$data->water',
           electricity='$data->electricity',
           tissue='$data->tissue',
           wifi='$data->wifi',
           dirt='$data->dirt',
           gass='$data->gass',
           cur_meal_amount='$cur_meal_amount',
           meal_start_date='$data->meal_start_date',
           meeting_amount='$data->meeting_amount',
           cur_others_amount=friday+employee+feast+welfare+others+water+electricity
           +tissue+dirt+gass+wifi+card_fee+service_charge+security+hostel_fee+meeting_penalty,

            cur_total_amount=cur_meal_amount+cur_others_amount,
            withdraw=pre_reserve_amount+pre_refund-pre_monthdue,
           inmeal_amount=(breakfast_inmeal*breakfast_rate+lunch_inmeal*lunch_rate+dinner_inmeal*dinner_rate),


           meeting_penalty=(CASE 
             WHEN pre_meeting_present>=1 THEN meeting_amount 
             ELSE 0  END),

           payble_amount=(CASE 
                 WHEN withdraw_status>=1 THEN cur_total_amount-inmeal_amount 
                 ELSE cur_total_amount-(inmeal_amount+withdraw)  END),


           first_pay_mealon=(CASE 
                  WHEN  $data->first_payment_meal<=0 THEN 0 
                  WHEN  $data->first_payment_meal<=lunch_inmeal THEN 0 
                  WHEN  payment_status1<=0 && payment_status2>=1 THEN 0   
                  ELSE $data->first_payment_meal  END),
           first_pay_mealamount=first_pay_mealon*(breakfast_rate+lunch_rate+dinner_rate),    

           first_others_amount=(CASE 
                 WHEN first_pay_mealon<=0 THEN 0 
                 ELSE '$first_others_amount'+security+service_charge+card_fee  END),

           payble_amount1=(CASE 
                 WHEN first_pay_mealon<=0 THEN 0
                 WHEN withdraw_status>=1 THEN  first_pay_mealamount+first_others_amount-inmeal_amount
                 ELSE first_pay_mealamount+first_others_amount-(inmeal_amount+withdraw) END),


           second_pay_mealon=section_day-first_pay_mealon,
           second_pay_mealamount=cur_meal_amount-first_pay_mealamount,
           second_others_amount=cur_others_amount-first_others_amount,
           
           payble_amount2=(CASE 
                WHEN payment_status1>=1 THEN second_pay_mealamount+second_others_amount
                WHEN withdraw_status>=1 THEN cur_total_amount-inmeal_amount
                ELSE cur_total_amount-(inmeal_amount+withdraw)  END),

            onmeal_amount=breakfast_onmeal*breakfast_rate+lunch_onmeal*lunch_rate+dinner_onmeal*dinner_rate,
           
          
            mealreducetk=breakfast_offmeal*(breakfast_rate-refund_breakfast_rate)
            +lunch_offmeal*(lunch_rate-refund_lunch_rate)+dinner_offmeal*(dinner_rate-refund_dinner_rate),

            offmeal_amount=(breakfast_offmeal*breakfast_rate+lunch_offmeal*lunch_rate+dinner_offmeal*dinner_rate)-mealreducetk,

            friday1='$friday1', friday2='$friday2', friday3='$friday3', friday4='$friday4', friday5='$friday5'

           , fridayt1=(CASE WHEN $friday1=1  THEN 0 ELSE $friday1t END)
           , fridayt2=(CASE WHEN $friday2=1  THEN 0 ELSE $friday2t END)
           , fridayt3=(CASE WHEN $friday3=1  THEN 0 ELSE $friday3t END)
           , fridayt4=(CASE WHEN $friday4=1  THEN 0 ELSE $friday4t END)
           , fridayt5=(CASE WHEN $friday5=1  THEN 0 ELSE $friday5t END)

           , refund_feast=(CASE WHEN $feast_day<=0 OR $feast_day>=9 THEN $feast ELSE 0 END)
           , refund_friday=fridayt1+fridayt2+fridayt3+fridayt4+fridayt5
           , refund_welfare=(CASE WHEN onmeal_amount<=0 THEN $data->refund_welfare ELSE 0 END)
           , refund_employee=(CASE WHEN onmeal_amount<=0 THEN $data->refund_employee ELSE 0 END)
           , refund_others=(CASE WHEN onmeal_amount<=0 THEN $data->refund_others ELSE 0 END)

           , refund_tissue=(CASE WHEN onmeal_amount<=0 THEN $data->refund_tissue ELSE 0 END)
           , refund_gass=(CASE WHEN onmeal_amount<=0 THEN $data->refund_gass ELSE 0 END)
           , refund_electricity=(CASE WHEN onmeal_amount<=0 THEN $data->refund_electricity ELSE 0 END)
           , refund_water=(CASE WHEN onmeal_amount<=0 THEN $data->refund_water ELSE 0 END)
           , refund_wifi=(CASE WHEN onmeal_amount<=0 THEN $data->refund_wifi ELSE 0 END)
           , refund_dirt=(CASE WHEN onmeal_amount<=0 THEN $data->refund_dirt ELSE 0 END)

           , total_refund=offmeal_amount+refund_feast+refund_friday+refund_welfare+refund_employee+refund_others
                     +refund_tissue+refund_gass+refund_electricity+refund_water+refund_wifi+refund_dirt  

           , first_payment_due=(CASE 
                     WHEN payment_status1<=0 THEN payble_amount1 
                     ELSE 0 END)

           , second_payment_due=(CASE 
                    WHEN payment_status2<=0 THEN payble_amount2 
                    ELSE 0 END)

          , total_due=(CASE 
              WHEN payment_status1<=0 AND payment_status2<=0 THEN payble_amount
              WHEN payment_status1<=0 AND payment_status2>=0 THEN first_payment_due+second_payment_due
              WHEN payment_status1>=1 AND payment_status2<=0 THEN first_payment_due+second_payment_due
              ELSE 0 END)

          , reserve_amount=(CASE 
                WHEN payble_amount2<0 THEN -payble_amount2
             ELSE 0  END)
          
          ,date1='$data->date1',date2='$data->date2',date3='$data->date3',date4='$data->date4',date5='$data->date5'
          ,date6='$data->date6',date7='$data->date7',date8='$data->date8',date9='$data->date9',date10='$data->date10'
          ,date11='$data->date11',date12='$data->date12',date13='$data->date13',date14='$data->date14',date15='$data->date15'
          ,date16='$data->date16',date17='$data->date17',date18='$data->date18',date19='$data->date19',date20='$data->date20'
          ,date21='$data->date21',date22='$data->date22',date23='$data->date23',date24='$data->date24',date25='$data->date25'
          ,date26='$data->date26',date27='$data->date27',date28='$data->date28',date29='$data->date29',date30='$data->date30'
          ,date31='$data->date31'            
           where invoice_status=1 AND invoice_month=$data->cur_month AND invoice_year=$data->cur_year  AND invoice_section='$data->cur_section' AND hall_id='$hall_id'");

    if($data->refresh_date==$payment_date){
          $number=$data->refresh_no+1;
          DB::update("update hallinfos set refresh_date='$payment_date', refresh_no='$number'  where hall_id_info = '$hall_id' ");
      }else{
         DB::update("update hallinfos set refresh_date='$payment_date', refresh_no='0'  where hall_id_info = '$hall_id' ");
      }   

       return back()->with('success','Update Information');
     }




     public function mealsheet_view(Request $request)
     {
       try {
           $hall_id = $request->header('hall_id');
           $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->first();
           return view('manager.mealsheet', ['data' => $hallinfo]);
          }catch (Exception $e) {  return  view('errors.error', ['error' => $e]);} 
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
         $manager_username = $request->header('manager_username');
         $hall_id = $request->header('hall_id');
         $id = $request->input('payment1_id');
         $data = Invoice::Where('invoices.id', $id)->select('payble_amount1','payment_status1' ,'payment_time1' 
             ,'payble_amount2' ,'payment_status2' ,'withdraw' ,'withdraw_status','meal_start_date','first_pay_mealon')->first();

       $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('section_day','unpaid_day','breakfast_rate','lunch_rate'
       ,'dinner_rate','breakfast_status','lunch_status','dinner_status')->first();
     
         if ($data->payment_status1 == 1) {
             $status1 = 0;
             $paymenttime = date('2010-10-10 10:10:10');
             $paymenttype = '';
             $mealstatus = 0;
             $payment_status = "Unpaid";
           } else {
             $status1 = 1;
             $paymenttime = date('Y-m-d H:i:s');
             $paymenttype = $manager_username;
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
     
          if($data->payment_status1 == 1 && (strtotime($current_time)-strtotime($data->payment_time1)) >= ($unpaid_day*60*60)) {
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
          }
           else{ 
             DB::update("update invoices set payment_status1 ='$status1' , payment_time1='$paymenttime',payment_type1='$paymenttype' 
                 ,payment_day1='$payment_day' where id ='$id' ");
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
              member_meal_update(Invoice::find($id));

              $subject="Payment 1 Invoice Summary: ".$invoice->invoice_year.'-'.$invoice->invoice_month.'-'.$invoice->invoice_section;
              $details = [
                  'subject' =>$subject,
                  'otp_code' =>255,
                  'payment' => $data->payble_amount1,
                  'payment_status' => $payment_status,
                  'paymenttime' => $paymenttime,
                  'paymenttype' => $paymenttype,
                  'name' => 'ANCOVA',
                ];
               Mail::to($member->email)->send(new \App\Mail\paymentMail($details));   
           $mess = "Invoice No: " . $id . "Card No: " . $member->card . ".  First Payable Amount  " . $data->payble_amount1 . "TK " . $payment_status;
             return response()->json([
               'status' => 200,
               'message' => $mess,
             ]);


          }
       
       }


       public function payment2_update(Request $request)
       {
         $manager_username = $request->header('manager_username');
         $hall_id = $request->header('hall_id');
         $id = $request->input('payment2_id');
         $data = Invoice::Where('id', $id)->select('payble_amount1','payment_status1' ,'payment_time1' ,'payment_time2'
             ,'payble_amount2' ,'payment_status2' ,'withdraw' ,'withdraw_status','withdraw_time','meal_start_date','first_pay_mealon')->first();

       $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('section_day','unpaid_day','breakfast_rate','breakfast_status',
       'lunch_rate','lunch_status','dinner_rate','dinner_status','first_payment_meal')->first();
     
         if ($data->payment_status2 == 1) {
             $status1 = 0;
             $paymenttime = date('2010-10-10 10:10:10');
             $paymenttype = '';
             $mealstatus = 0;
             $payment_status = "Unpaid";
           } else {
             $status1 = 1;
             $paymenttime = date('Y-m-d H:i:s');
             $paymenttype = $manager_username;
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
           }else{ 
             DB::update("update invoices set payment_status2 ='$status1',payment_time2='$paymenttime',payment_type2='$paymenttype' 
                ,payment_day2='$payment_day' where id ='$id'");

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
                    'paymenttime' => $paymenttime,
                    'paymenttype' => $paymenttype,
                    'name' => 'ANCOVA',
                  ];
                 Mail::to($member->email)->send(new \App\Mail\paymentMail($details));  
                 member_meal_update(Invoice::find($id));
            $mess = " Invoice No : " . $id ." Card No: " . $member->card . ".  Second Payable Amount  " . $data->payble_amount2 . "TK " . $payment_status;
             return response()->json([
                'status' => 200,
                'message' => $mess,
             ]);
 
          }
       
       }


       public function withdraw_update(Request $request)
       {
         $manager_username = $request->header('manager_username');
         $hall_id = $request->header('hall_id');
         $id = $request->input('withdraw_id');
         $data = Invoice::Where('id', $id)->select('payble_amount1','payment_status1' ,'payment_time1' ,'payment_time2' ,'invoice_status'
             ,'payble_amount2' ,'payment_status2' ,'withdraw' ,'withdraw_status','withdraw_time','meal_start_date','first_pay_mealon')->first();

         $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('section_day','unpaid_day','breakfast_rate','lunch_rate','dinner_rate','first_payment_meal')->first();
     
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

       }else{
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
             return response()->json([
               'status' => 200,
               'message' => $mess,
             ]);

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



   
    
}
