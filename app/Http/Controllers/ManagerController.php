<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Hallinfo;
use App\Models\Maintain;
use App\Models\Hall;
use Illuminate\Support\Facades\Cookie;
use App\Helpers\ManagerJWTToken;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Member;
use App\Models\Feedback;
use App\Models\Invoice;
use App\Models\Expayemnt;
use  DateTime;

class ManagerController extends Controller
{

    public function login(Request $request)
    {
        try {
            return view('manager.login');
        } catch (Exception $e) {
            return  view('errors.error', ['error' => $e]);
        }
    }

    public function dashboard(Request $request)
    {
       try {
            $hall_id = $request->header('hall_id');
            $hallinfo = Hallinfo::where('hall_id_info', $hall_id)->select('cur_month', 'cur_year', 'cur_section',
             'pdf_order','meal_start_date','friday1','friday2','friday3','friday4','friday5','feast_day'
             ,'friday1t','friday2t','friday3t','friday4t','friday5t','feast'
             ,'breakfast_rate','lunch_rate','dinner_rate')->first();
            
            $payment_date= date('Y-m-d');
            $from_day=getDaysBetween2Dates(new DateTime($payment_date), new DateTime($hallinfo->meal_start_date),false)+1;
            if($from_day<=31){
               $fromDay=$from_day;
            }else{
               $fromDay=31;
            }

      $lunch1=0;
      $breakfast1=0;
      $dinner1=0;
        $fri1=0;
        $fri2=0;
        $fri3=0;
        $fri4=0;
        $fri5=0;
         $feast=0; 
      if(substr($hallinfo->friday1,1,2)<=$from_day){
            $fri1=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
            ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where($hallinfo->friday1,1)->count();
        }

      if(substr($hallinfo->friday2,1,2)<=$from_day){
        $fri2=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
            ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where($hallinfo->friday2,1)->count();
        } 
        
        if(substr($hallinfo->friday3,1,2)<=$from_day){
            $fri3=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
            ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where($hallinfo->friday3,1)->count();
        } 
        
        if(substr($hallinfo->friday4,1,2)<=$from_day){
            $fri4=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
            ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where($hallinfo->friday4,1)->count();
        }  

        if(substr($hallinfo->friday5,1,2)<=$from_day){
            $fri5=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
            ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where($hallinfo->friday5,1)->count();
        } 

         if(substr($hallinfo->feast_day,1,2)<=$from_day){
            $feast=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
            ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where($hallinfo->feast_day,1)->count();
          } 

   
       // echo  $fri1+$fri2+$fri3+$fri4+$fri5;

       $fridayfeast= $fri1*$hallinfo->friday1t+$fri2*$hallinfo->friday2t+$fri3*$hallinfo->friday3t
        +$fri4*$hallinfo->friday4t+$fri5*$hallinfo->friday5t+$feast*$hallinfo->feast;
       
      
      for($x =1; $x <=$fromDay ; $x++){

        $lunch=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
         ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where('l'.$x,1)->count();
         
        $dinner=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
          ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where('d'.$x,1)->count();
          
        $breakfast=Invoice::where('hall_id',$hall_id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
          ->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->where('b'.$x,1)->count();
    
         $lunch1+=$lunch;
         $dinner1+=$dinner;
         $breakfast1+=$breakfast;
       }
       $cur_meal= $breakfast1+ $dinner1+$lunch1;
       $estimate_bazar=$breakfast1*$hallinfo->breakfast_rate+$dinner1*$hallinfo->dinner_rate
         +$lunch1*$hallinfo->lunch_rate+$fridayfeast;
     

       $invoice=DB::table('invoices')->where('invoice_month',$hallinfo->cur_month)->where('hall_id',$hall_id)
         ->where('invoice_year',$hallinfo->cur_year)->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)->get();
  
       $active_invoice = Invoice::where('invoice_month',$hallinfo->cur_month)->where('hall_id',$hall_id)
         ->where('invoice_year',$hallinfo->cur_year)->where('invoice_section',$hallinfo->cur_section)
         ->where('onmeal_amount','>=',1)->get();

         $payment1=DB::table('invoices')->where('invoice_month',$hallinfo->cur_month)->where('hall_id',$hall_id)
         ->where('invoice_year',$hallinfo->cur_year)->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)
         ->where('payment_status1',1)->get();
 
        $payment2=DB::table('invoices')->where('invoice_month',$hallinfo->cur_month)->where('hall_id',$hall_id)
        ->where('invoice_year',$hallinfo->cur_year)->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',1)
         ->where('payment_status2',1)->get();   

      $exinvoice=DB::table('invoices')->where('invoice_month', $hallinfo->cur_month)->where('hall_id', $hall_id)
            ->where('invoice_year',$hallinfo->cur_year)->where('invoice_section',$hallinfo->cur_section)->where('invoice_status',5)->get();

     $exinvoice_payment=DB::table('invoices')->where('invoice_month', $hallinfo->cur_month)->where('hall_id', $hall_id)
       ->where('invoice_year', $hallinfo->cur_year)->where('invoice_section', $hallinfo->cur_section)->where('invoice_status',5)
       ->where('withdraw_status',1)->get();

       $reserve_payment2=DB::table('invoices')->where('invoice_month', $hallinfo->cur_month)->where('hall_id', $hall_id)
       ->where('invoice_year', $hallinfo->cur_year)->where('invoice_section', $hallinfo->cur_section)->where('invoice_status',1)
       ->where('payment_status2',1)->where('payble_amount2','<',0)->sum('payble_amount2');

      // $reserve_payment=$reserve_payment2->sum('payble_amount2');

       $bazar=DB::table('bazars')->where('bazar_year',$hallinfo->cur_year)->where('bazar_month',$hallinfo->cur_month)
       ->where('bazar_section',$hallinfo->cur_section)->where('bazars.category','bazar')->where('hall_id',$hall_id)->get();


     $extra_payment=Expayemnt::where('cur_month',$hallinfo->cur_month)->where('cur_year',$hallinfo->cur_year)->where('hall_id',$hall_id)
     ->where('cur_section',$hallinfo->cur_section)->orderBy('id','desc')->get();

            return view('manager.dashboard',['active_invoice'=>$active_invoice,'invoice'=>$invoice,
            'exinvoice'=>$exinvoice,'payment1'=>$payment1,'payment2'=>$payment2,'hallinfo'=>$hallinfo,
            'cur_meal'=>$cur_meal,'bazar'=>$bazar ,'estimate_bazar'=>$estimate_bazar
            ,'extra_payment'=>$extra_payment,'exinvoice_payment'=>$exinvoice_payment,'reserve_payment2'=>$reserve_payment2]);
        } catch (Exception $e) {
            return  view('errors.error', ['error' => $e]);
        }
    }


    public function login_insert(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'phone' => 'required',
                'password' => 'required',
            ],
            [
                'phone.required' => 'Phone is required',
                'password.required' => 'Password is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {

            $username = Hall::where('phone', $request->phone)->first();
            $status = 1;
            if ($username) {
                if ($username->password == $request->password) {
                    if ($username->status == $status) {
                        $rand = rand(11111, 99999);
                        DB::update("update halls set login_code ='$rand' where phone = '$username->phone'");
                        SendEmail($username->email, "Manager Otp code", "One Time OTP Code", $rand, "ANCOVA");
                        return response()->json([
                            'status' => 200,
                            'phone' => $username->phone,
                            'email' => $username->email,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 600,
                            'message' => 'Acount Inactive',
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Invalid Password',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 300,
                    'message' => 'Invalid Phone Number',
                ]);
            }
        }
    }


    public function login_verify(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'otp' => 'required|numeric',
            ],
            [
                'otp.required' => 'OTP is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
            $username = Hall::where('phone', $request->verify_phone)->where('email', $request->verify_email)
                ->where('login_code', $request->otp)->first();
            if ($username) {
                DB::update("update maintains set login_code ='null' where phone = '$username->phone'");
                $token_manager = ManagerJWTToken::CreateToken($username->id, $username->manager_username, $username->email, $username->hall_id, $username->role,$username->role2);
                Cookie::queue('token_manager', $token_manager, 60 * 24*2); //96 hour
              $manager_info = [
                    "hall_name" => $username->hall, "role" => $username->role, "manager_name" => $username->manager_name,
                    "email" => $username->email, "phone" => $username->phone, "hall_id" => $username->hall_id
               ];
                $manager_info_array = serialize($manager_info);
                Cookie::queue('manager_info', $manager_info_array, 60 * 24*2);
                return response()->json([
                    'status' => 200,
                    'message' => 'success',
                ]);
            } else {
                return response()->json([
                    'status' => 300,
                    'message' => "Invalid OTP",
                ]);
            }
        }
    }


    public function logout()
    {
        Cookie::queue('token_manager', '', -1);
        Cookie::queue('token_manager', '', -1);
        return redirect('manager/login');
    }


    public function forget(Request $request)
    {
          try {
                 return view('maintain.forget');
             } catch (Exception $e) {
                 return  view('errors.error', ["error" => $e]);
             }
    }


    public function forgetemail(request $request)
    {
        $email = $request->input('email');
        $rand = rand(11111, 99999);
        $email_exist = Maintain::where('email', $email)->first();
        if ($email_exist) {
            DB::update("update maintains set forget_code ='$rand' where email = '$email'");
            SendEmail($email_exist->email, "Password Recovary code", "One Time  Code", $rand, "Dining Name");
            return response()->json([
                'status' => 500,
                'errors' => 'Email exist',
            ]);
        } else {
            return response()->json([
                'status' => 600,
                'errors' => 'Invalid  Email ',
            ]);
        }
    }



    public function forgetcode(request $request)
    {

        $email_id = $request->input('email_id');
        $forget_code = $request->input('forget_code');
        $code_exist = Maintain::where('email', $email_id)->where('forget_code', $forget_code)->count('email');
        if ($code_exist >= 1) {
            return response()->json([
                'status' => 500,
                'errors' => 'valid code',
            ]);
        } else {
            return response()->json([
                'status' => 600,
                'errors' => 'Invalid  Code',
            ]);
        }
    }


    public function confirmpass(request $request)
    {
        $email_id_pass = $request->input('email_id_pass');
        $forget_code_pass = $request->input('forget_code_pass');
        $npass = $request->input('npass');
        $cpass = $request->input('cpass');
        //$password=Hash::make($npass);
        $rand = rand(11111, 99999);
        if ($npass == $cpass) {
            DB::update("update maintains set password ='$npass' where email = '$email_id_pass' AND forget_code='$forget_code_pass'");
            Cookie::queue('token', '', -1);
            DB::update("update maintains set forget_code ='$rand' where email = '$email_id_pass'");
            return response()->json([
                'status' => 500,
                'errors' => 'valid code',
            ]);
        } else {
            return response()->json([
                'status' => 600,
                'errors' => 'New password & Confirm password Does not match',
            ]);
        }
    }


    public function passwordview(request $request)
    {

        return view('manager.password');
    }


    public function passwordupdate(request $request)
    {
        $this->validate($request, [
            'oldpassword'  => 'required',
            'npass'  => 'required',
            'cpass'  => 'required',
        ]);
        $id = $request->header('id');
        $oldpassword = $request->input('oldpassword');
        $npass = $request->input('npass');
        $cpass = $request->input('cpass');

        $data = Maintain::where('password', $oldpassword)->where('id', $id)->count('email');
        if ($data >= 1) {
            if ($npass == $cpass) {
                $student = Maintain::find($id);
                //$student->password=Hash::make($npass);
                $student->password = $npass;
                $student->update();
                return redirect('/manager/password')->with('success', 'Passsword change  successfully');
            } else {
                return redirect('/manager/password')->with('fail', 'New Passsword & Confirm Passsword is not match');
            }
        } else {
            return redirect('/manager/password')->with('fail', 'Invalid Email');
        }
    }


    public function information_update(request $request)
    {
        try {
             $hall_id = $request->header('hall_id');
             $data = Hallinfo::where('hall_id_info', '=', $hall_id)->get();
             return view('manager.information_update', ['data' => $data]);
        } catch (Exception $e) {
            return  view('errors.error', ['error' => $e]);
        }
    }



    public function information_update_view(request $request, $id)
    {
        $data = Hallinfo::where('id', '=', $id)->first();
        return response()->json([
            'status' => 200,
            'value' => $data,
        ]);
    }



    public function information_update_submit(Request $request)
    {
        //try {
            $start = strtotime($request->input('meal_start_date'));
            $end = strtotime($request->input('meal_end_date'));
            $days = ceil(abs($end - $start) / 86400);
            if ($days < 31) {
                $data = Hallinfo::find($request->input('edit_id'));
                $data->cur_date = $request->input('cur_date');
                $data->pre_date = $request->input('pre_date');
                $data->update_time = $request->input('update_time');
                $data->cur_month = date('m', strtotime($request->input('cur_date')));
                $data->cur_year = date('Y', strtotime($request->input('cur_date')));
                $data->cur_section = $request->input('cur_section');
                $data->pre_section = $request->input('pre_section');
                $data->pre_month = date('m', strtotime($request->input('pre_date')));
                $data->pre_year = date('Y', strtotime($request->input('pre_date')));
                $data->pre_section_last_day = $request->input('last_day_daytype').$request->input('pre_section_last_day');
                $data->meal_start_date = $request->input('meal_start_date');
                $data->meal_end_date = $request->input('meal_end_date');
                $data->mealon_without_payment = $request->input('mealon_without_payment');
               
               

                $data->breakfast_rate = $request->input('breakfast_rate');
                $data->refund_breakfast_rate = $request->input('refund_breakfast_rate');
                $data->lunch_rate = $request->input('lunch_rate');
                $data->refund_lunch_rate = $request->input('refund_lunch_rate');
                $data->dinner_rate = $request->input('dinner_rate');
                $data->refund_dinner_rate = $request->input('refund_dinner_rate');
                $data->max_meal_off = $request->input('max_meal_off');
                $data->last_meal_off = $request->input('last_meal_off');
                $data->first_meal_off = $request->input('first_meal_off');
                $data->add_minute = $request->input('add_minute');

                $data->breakfast_status = $request->input('breakfast_status');
                $data->dinner_status = $request->input('dinner_status');
                $data->lunch_status = $request->input('lunch_status');


                $data->meeting_amount = $request->input('meeting_amount');
                $data->card_fee = $request->input('card_fee');
                $data->service_charge = $request->input('service_charge');
                $data->security_money = $request->input('security_money');

                $data->employee = $request->input('employee');
                $data->refund_employee = $request->input('refund_employee');
                $data->welfare = $request->input('welfare');
                $data->refund_welfare = $request->input('refund_welfare');
                $data->others = $request->input('others');
                $data->refund_others = $request->input('refund_others');

                $data->water = $request->input('water');
                $data->refund_water = $request->input('refund_water');
                $data->wifi = $request->input('wifi');
                $data->refund_wifi = $request->input('refund_wifi');
                $data->dirt = $request->input('dirt');
                $data->refund_dirt = $request->input('refund_dirt');

                $data->electricity = $request->input('electricity');
                $data->refund_electricity = $request->input('refund_electricity');
                $data->tissue = $request->input('tissue');
                $data->refund_tissue = $request->input('refund_tissue');

                $data->gass = $request->input('gass');
                $data->refund_gass = $request->input('refund_gass');
                $data->feast = $request->input('feast');
                $data->feast_day = $request->input('feast_daytype').$request->input('feast_day');
                $data->unpaid_day = $request->input('unpaid_day');


                $data->first_payment_meal = $request->input('first_payment_meal');
                $data->feastf = $request->input('feastf');
                $data->welfaref = $request->input('welfaref');
                $data->othersf = $request->input('othersf');
                $data->employeef = $request->input('employeef');
                $data->fridayf = $request->input('fridayf');

                $data->wifif = $request->input('wifif');
                $data->dirtf = $request->input('dirtf');
                $data->gassf = $request->input('gassf');
                $data->electricityf = $request->input('electricityf');
                $data->tissuef = $request->input('tissuef');
                $data->waterf = $request->input('waterf');

                $data->pdf_order = $request->input('pdf_order');
                $data->breakfast_status = $request->input('breakfast_status');
                $data->lunch_status = $request->input('lunch_status');
                $data->dinner_status = $request->input('dinner_status');

             

                $data->friday1 = $request->input('fridaytype1').$request->input('friday1');
                $data->friday2 = $request->input('fridaytype2').$request->input('friday2');
                $data->friday3 = $request->input('fridaytype3').$request->input('friday3');
                $data->friday4 = $request->input('fridaytype4').$request->input('friday4');
                $data->friday5 = $request->input('fridaytype5').$request->input('friday5');

                $data->friday1t = $request->input('friday1t');
                $data->friday2t = $request->input('friday2t');
                $data->friday3t = $request->input('friday3t');
                $data->friday4t = $request->input('friday4t');
                $data->friday5t = $request->input('friday5t');
                $data->friday = $request->input('friday1t') + $request->input('friday2t') +
                    $request->input('friday3t') + $request->input('friday4t') + $request->input('friday5t');


                $day = $days + 2;
                  for ($i = 1; $i <= $day; $i++) {
                     $date = "date" . $i;
                     $data->$date = date('Y-m-d', strtotime('+' . ($i - 1) . 'day', $start));
                  }

                 for ($i = $day; $i <= 31; $i++) {
                     $date = 'date' . $i;
                     $data->$date = "";
                  }

                $data->section_day = $days + 1;
                $data->update();
                return redirect()->back()->with('status', 'Data Edit Successfuly');
            } else {
                return redirect()->back()->with('danger', 'Meal Day More than 31');
            }
        // } catch (Exception $e) {
        //     return  view('errors.error', ['error' => $e]);
        // }
    }


    public function invoice_create(Request $request)
    {
        //try {
          $hall_id = $request->header('hall_id');
          $data = Hallinfo::where('hall_id_info', $hall_id)->first();

           $invoice1=DB::table('invoices')->where('invoice_month',$data->cur_month)->where('invoice_year',$data->cur_year)
                   ->where('invoice_section',$data->cur_section)->where('invoice_status',1)->where('hall_id',$hall_id)->get();
         if($invoice1->count()>=1){
                   return back()->with('fail','Invoice already exist');   
         }else{     
                $pre_invoice=Invoice::where('invoice_month',$data->pre_month)->where('invoice_year',$data->pre_year)
                ->where('invoice_section',$data->pre_section)->where('invoice_status',1)->where('hall_id',$hall_id)->get();

         $hall=DB::table('halls')->where('hall_id',$hall_id)->where('role','admin')->first();
                if($hall->refund_status=='Yes'){             
                    foreach($pre_invoice as $row){
                        $pre_invoice = new Invoice;
                        $pre_invoice->hall_id=$row['hall_id'];
                        $pre_invoice->invoice_date=$data->cur_date;
                        $pre_invoice->invoice_section=$data->cur_section;
                        $pre_invoice->invoice_month=$data->cur_month;
                        $pre_invoice->invoice_year=$data->cur_year;
                        $pre_invoice->meal_start_date=$data->meal_start_date;
                        $pre_invoice->meal_end_date=$data->meal_end_date;
                        $pre_invoice->gateway_fee=$hall->gateway_fee;
                        $pre_invoice->member_id=$row['member_id'];
                        $pre_invoice->tran_id1=Str::random(8);
                        $pre_invoice->tran_id2=Str::random(10);

                        $pre_invoice->pre_reserve_amount=$row['reserve_amount'];
                        $pre_invoice->pre_refund=$row['total_refund'];
                        $pre_invoice->pre_monthdue=$row['total_due'];
                        $pre_invoice->pre_last_meal=$row[$data->pre_section_last_day]; 
                        $pre_invoice->pre_meeting_present=$row['meeting_present'];
                        $pre_invoice->save();  
                     }
                         return back()->with('success','Invoice Update And Add Previous Refund Due');   
                    }else{
                        foreach($pre_invoice as $row){
                            $pre_invoice = new Invoice;
                            $pre_invoice->hall_id=$row['hall_id'];
                            $pre_invoice->invoice_date=$data->cur_date;
                            $pre_invoice->invoice_section=$data->cur_section;
                            $pre_invoice->invoice_month=$data->cur_month;
                            $pre_invoice->invoice_year=$data->cur_year;
                            $pre_invoice->meal_start_date=$data->meal_start_date;
                            $pre_invoice->meal_end_date=$data->meal_end_date;
                            $pre_invoice->gateway_fee=$hall->gateway_fee;
                            $pre_invoice->member_id=$row['member_id'];
                            $pre_invoice->tran_id1=Str::random(8);
                            $pre_invoice->tran_id2=Str::random(10);
    
                            $pre_invoice->pre_reserve_amount=0;
                            $pre_invoice->pre_refund=0;
                            $pre_invoice->pre_monthdue=0;
                            $pre_invoice->pre_last_meal=$row['pre_section_last_day'];
                            $pre_invoice->pre_meeting_present=$row['meeting_present'];
                            $pre_invoice->save();  
                         }
               
                     return back()->with('success','Invoice Update And No Previous Refund Due Add');   
                 }
             }
            
        //  } catch (Exception $e) {
       //     return  view('errors.error', ['error' => $e]);
       // }
    }



    public function manager_access(Request $request)
    {

        $hall_id = $request->header('hall_id');
        $role = $request->header('role');
        return view('manager.manager_access',['role'=>$role]);
    }


    public function store(Request $request)
    {
        $hall_id = $request->header('hall_id');
        $role = $request->header('role');
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required|unique:halls,phone',
                'email' => 'required|unique:halls,email',
                'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'image' => 'image|mimes:jpeg,png,jpg|max:400',
            ],
            [
              'password.regex' => 'password minimum six characters including one uppercase letter, 
                    one lowercase letter and one number '
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
            $data = Hall::where('role','admin')->where('hall_id',$hall_id)->first();
            $model = new Hall;
            $model->role = 'manager';
            if($role=='admin'){
                $model->role2 = $request->input('access_type');
            } 
            $model->status = 1;
            $model->university_id = $data->university_id;
            $model->hall_id = $data->hall_id;
            $model->hall = $data->hall;
            $model->password = $request->input('password');
            $model->manager_username = Str::slug(substr($request->input('name'), 0, 8), '_');
            $model->manager_name = $request->input('name');
            $model->email = $request->input('email');
            $model->phone = $request->input('phone');
            if($request->hasfile('image')) {
                $imgfile = 'manager-';
                $size = $request->file('image')->getsize();
                $file = $_FILES['image']['tmp_name'];
                $hw = getimagesize($file);
                $w = $hw[0];
                $h = $hw[1];
                if ($w < 310 && $h < 310) {
                    $image = $request->file('image');
                    $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads'), $new_name);
                    $model->image = $new_name;
                } else {
                    return response()->json([
                        'status' => 300,
                        'message' => 'Image size must be 300*300px',
                    ]);
                }
            }
            $model->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data Added Successfull',
            ]);
        }
    }



    public function fetchAll(Request $request)
    {
        $hall_id = $request->header('hall_id');
        $role = $request->header('role');
        $role2 = $request->header('role2');
        if($role=='admin'){
            $data = Hall::where('role','manager')->where('hall_id', $hall_id)->get();
            $output = '';
            if ($data->count() > 0) {
                $output .= ' <h5 class="text-success"> Total Row : ' .$data->count(). ' </h5>';
                $output .= '<table class="table table-bordered table-sm text-start align-middle">
         <thead>
            <tr>
              <th>Image </th>
              <th>Name </th>
              <th>Role </th>
              <th>Role 2</th>
              <th>Phone </th>
              <th>Email </th>
              <th>Passsword </th>
              <th>Login code </th>
              <th>Status </th>
              <th>Action </th>
            </tr>
         </thead>
         <tbody>';
                foreach ($data as $row) {
    
                  
                    if (!$row->image) {
                        $image = "";
                    } else {
                        $image = '<i class="fa fa-download"></i>';
                    }
                    if ($row->status == 1) {
                        $status = '<a href="#"class="btn btn-success btn-sm">Active</a>';
                    } else {
                        $status = '<a href="#"class="btn btn-danger btn-sm">Inactive</a>';
                    }
    
                    $output .= '<tr>
              <td> <a href=/uploads/' . $row->image . ' download id="' . $row->id . '" class="text-success mx-1">' . $image . ' </a></td>
              <td>' . $row->manager_name . '</td>
              <td>' . $row->role . '</td> 
              <td>' . $row->role2 . '</td>
              <td>' . $row->phone . '</td>
              <td>' . $row->email . '</td>
              <td>' . $row->password . '</td>
              <td>' . $row->login_code . '</td>
              <td>' . $status . '</td>
               <td>
                  <a href="#" id="' . $row->id . '"class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i>Edit</a>
                  <a href="#" id="' . $row->id . '"class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i>Delete</a>
               </td>
          </tr>';
                }
             
                $output .= '</tbody></table>';
                echo $output;
            }

        }else{
  
            $data = Hall::where('role','manager')->where('hall_id', $hall_id)->get();
            $output = '';
            if ($data->count() > 0) {
                $output .= ' <h5 class="text-success"> Total Row : ' .$data->count(). ' </h5>';
                $output .= '<table class="table table-bordered table-sm text-start align-middle">
         <thead>
            <tr>
              <th>Image </th>
              <th>Name </th>
              <th>Role </th>
              <th>Role 2</th>
              <th>Phone </th>
              <th>Email </th>
              <th>Passsword </th>
              <th>Login code </th>
              <th>Status </th>
              <th>Action </th>
            </tr>
         </thead>
         <tbody>';
                foreach ($data as $row) {
                 
             if($row->role2=='auditor'){

                    }else{ 
                    if (!$row->image) {
                        $image = "";
                    } else {
                        $image = '<i class="fa fa-download"></i>';
                    }
                    if ($row->status == 1) {
                        $status = '<a href="#"class="btn btn-success btn-sm">Active</a>';
                    } else {
                        $status = '<a href="#"class="btn btn-danger btn-sm">Inactive</a>';
                    }
    
                    $output .= '<tr>
              <td> <a href=/uploads/' . $row->image . ' download id="' . $row->id . '" class="text-success mx-1">' . $image . ' </a></td>
              <td>' . $row->manager_name . '</td>
              <td>' . $row->role . '</td> 
              <td>' . $row->role2 . '</td>
              <td>' . $row->phone . '</td>
              <td>' . $row->email . '</td>
              <td>' . $row->password . '</td>
              <td>' . $row->login_code . '</td>
              <td>' . $status . '</td>
               <td>
                  <a href="#" id="' . $row->id . '"class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i>Edit</a>
                  <a href="#" id="' . $row->id . '"class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i>Delete</a>
               </td>
          </tr>';

                  }
                }
             
                $output .= '</tbody></table>';
                echo $output;
            }


        }
        
      
        
    }


    public function edit(Request $request)
    {
        $id = $request->id;
        $data = Hall::find($id);
        return response()->json([
            'status' => 200,
            'data' => $data,
        ]);
    }


    public function update(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
             [
                'name' => 'required',
                'phone' => 'required|unique:halls,phone,' . $request->input('edit_id'),
                'email' => 'required|unique:halls,email,' . $request->input('edit_id'),
                'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'image' => 'image|mimes:jpeg,png,jpg|max:400',
             ],

             [
                'password.regex' => 'password minimum six characters including one uppercase letter, 
                one lowercase letter and one number '
             ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
            $model = Hall::find($request->input('edit_id'));
            if ($model) {
                $model->password = $request->input('password');
                $model->manager_name = $request->input('name');
                $model->manager_username = Str::slug(substr($request->input('name'), 0, 8), '_');
                $model->email = $request->input('email');
                $model->phone = $request->input('phone');
                $model->status = $request->input('status');
                $model->meal = $request->input('meal');
                $model->member = $request->input('member');
                $model->member_edit = $request->input('member_edit');
                $model->payment = $request->input('payment');
                $model->bazar = $request->input('bazar');
                $model->application = $request->input('application');
                $model->resign = $request->input('resign');
                $model->booking = $request->input('booking');
                $model->others_access = $request->input('others_access');
                $model->storage = $request->input('storage');
                if ($request->hasfile('image')) {
                    $imgfile = 'maintain-';
                    $size = $request->file('image')->getsize();
                    $file = $_FILES['image']['tmp_name'];
                    $hw = getimagesize($file);
                    $w = $hw[0];
                    $h = $hw[1];
                    if ($w < 310 && $h < 310) {
                        $path = public_path('uploads/' . $model->image);
                        if (File::exists($path)) {
                            File::delete($path);
                        }
                        $image = $request->file('image');
                        $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('uploads'), $new_name);
                        $model->image = $new_name;
                    } else {
                        return response()->json([
                            'status' => 300,
                            'message' => 'Image size must be 300*300px',
                        ]);
                    }
                }

                $model->update();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Updated Successfull'
                ]);
            }
        }
    }


    public function manager_delete(Request $request)
    {
        $model = Hall::find($request->input('id'));
        $path = public_path('uploads/' . $model->image);
          if(File::exists($path)) {
              File::delete($path);
           }
        $model->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Deleted Successfully',
        ]);
    }



    public function member(Request $request, $member_status)
    {
       // try {
            $status1 = 0;
            $status = 1;
            $hall_id = $request->header('hall_id');
            $verify = DB::table('members')->where('hall_id', $hall_id)->where('member_status',$member_status)->where('admin_verify', $status)->count('id');
            $not_verify = DB::table('members')->where('hall_id', $hall_id)->where('member_status',$member_status)->where('admin_verify', $status1)->count('id');
            $email_verify = DB::table('members')->where('hall_id', $hall_id)->where('member_status',$member_status)->where('email_verify', $status1)->count('id');
            return view('manager.member', ['member_status'=>$member_status,'verify' => $verify, 'not_verify' => $not_verify, 'email_verify' => $email_verify]);
       // } catch (Exception $e) {  return  view('errors.error', ['error' => $e]);  }
    }




    public function member_fetch(Request $request,$member_status)
    {
       $hall_id = $request->header('hall_id');
       $data = Member::where('hall_id', $hall_id)->where('member_status',$member_status)->orderBy('admin_verify', 'asc')->paginate(10);
       return view('manager.member_data',['data'=>$data,'member_status'=>$member_status]);
    }

    public function member_view($id)
    {
        $value = Member::find($id);
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


    public function member_update(Request $request)
    {
        $hall_id = $request->header('hall_id');
        $validator = \Validator::make(
            $request->all(),
            [
                'phone' => 'required|unique:members,phone,' . $request->input('edit_id'),
                'email' => 'required|unique:members,email,' . $request->input('edit_id'),
                'registration' => 'required|unique:members,registration,' . $request->input('edit_id') . 'NULL,id,hall_id,' . $hall_id,
                'card' => 'required|unique:members,card,' . $request->input('edit_id') . 'NULL,id,hall_id,' . $hall_id,
                'hostel_fee' => 'required|numeric',
            ],
            [
                'phone.required' => 'Phone number is required',
                'email.required' => 'Email is required',
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
            $model = Member::find($request->input('edit_id'));
            if ($model) {
                $model->phone = $request->input('phone');
                $model->name = $request->input('name');
                $model->card = $request->input('card');
                $model->email = $request->input('email');
                $model->session = $request->input('session');
                $model->security_money = $request->input('security_money');
                $model->registration = $request->input('registration');
                $model->hostel_fee = $request->input('hostel_fee');
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

    

    function member_fetch_data(Request $request, $member_status)
    {
        $hall_id = $request->header('hall_id');
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $data = Member::Where('hall_id', $hall_id)->where('member_status',$member_status)->where(function ($query) use ($search) {
                $query->where('registration', 'like', '%' . $search . '%')
                    ->orWhere('card', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            })->orderBy($sort_by, $sort_type)->paginate(10);

            return view('manager.member_data', ['data'=>$data,'member_status'=>$member_status])->render();
        }
    }



    public function memberstatus(Request $request,$operator,$status,$id){
         //try{ 
         $hall_id = $request->header('hall_id');
         $hall=DB::table('halls')->where('hall_id',$hall_id)->where('role','admin')->first();
         $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->first();
          if($operator=='email'){
                 if($status=='deactive'){
                      $type=0;
                 }else{
                     $type=1;
                 }
                DB::update("update members set email_verify ='$type' where id = '$id'");  
               return back()->with('success','Email Verify update Successfull');      
      
        }else if($operator=='status'){  
               if($status=='deactive'){
                      $type=0;
                 }else{
                      $type=1;
                 }
              DB::update("update members set status ='$type' where id = '$id'" );  
               return back()->with('success','Status update Successfull');  

       }else if($operator=='member_status'){ 
              if($status=='deactive'){ $type=5; }else{ $type=5; }
              $member=Member::find($id);
              $invoice=Invoice::where('member_id',$id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
                 ->where('invoice_section',$hallinfo->cur_section)->where('hall_id',$hall_id)->first();
              if($member->admin_verify==1){
                 $payment=$invoice->payment_status1+$invoice->payment_status2;
                    if($invoice->onmeal_amount>0 OR $payment>0){
                         return back()->with('fail','Member Already Paid OR Meal ON');  
                    }else{
                        DB::update( "update members set member_status ='$type' , admin_verify ='$type' where id = '$id'" );
                        $withdraw=$invoice->pre_monthdue-($invoice->pre_reserve_amount+$invoice->pre_refund+$member->security_money);
                        DB::update( "update invoices set invoice_status ='$type', withdraw='$withdraw', security='$member->security_money' where id = '$invoice->id'" );
                        return back()->with('success','Member Status update Successfull');  
                    } 
                
                
              }else {
                   DB::update( "update members set member_status ='$type' where id = '$id'" );
                   return back()->with('success','Member Status update Successfull');  
              }
        
      }else if($operator=='verify'){
 
         if($status=='deactive'){
            $invoice=Invoice::where('member_id',$id)->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)
                ->where('invoice_section',$hallinfo->cur_section)->where('hall_id',$hall_id)->first();
            $pre_refund=$invoice->pre_refund;
            $pre_monthdue=$invoice->pre_monthdue;
            $onmeal_amount=$invoice->onmeal_amount;
            $invoice_id=$invoice->id;
         if($pre_refund==0 && $pre_monthdue==0 && $onmeal_amount==0 ){
              $type=0;
              $member=DB::update("update members set admin_verify ='$type' where id = '$id'"); 
                if($member){
                  DB::delete("delete from invoices  where id='$invoice_id'");  
                      return back()->with('fail','Admin verify updated ');  
                 }else{
                      return back()->with('fail','Admin verify not updated');  
                 } 
              }else{
                  return back()->with('fail','Pre. month refund or pre. month due or cur. month ON meal exist ');  
             }
                
        }else{
         $type=1;
         $status=0;
         $status2=1;
         $member=Member::where('id',$id)->first();
         $cur_meal_amount=$hallinfo->section_day*($hallinfo->breakfast_rate+$hallinfo->lunch_rate+$hallinfo->dinner_rate);

         $cur_others_amount=$hallinfo->friday+$hallinfo->employee+$hallinfo->welfare+$hallinfo->feast
           +$hallinfo->others+$hallinfo->gass+$hallinfo->electricity+$hallinfo->tissue+$hallinfo->water+$hallinfo->dirt
           +$hallinfo->card_fee+$hallinfo->security_money+$hallinfo->service_charge+$hallinfo->wifi+$member->hostel_fee;
          
          $cur_total_amount=$cur_meal_amount+$cur_others_amount;

    if($hallinfo->first_payment_meal>0){
            if($hallinfo->fridayf==1){$friday_value=$hallinfo->friday;}else{$friday_value=0;}
            if($hallinfo->feastf==1){$feast_value=$hallinfo->feast;}else{$feast_value=0;}
            if($hallinfo->welfaref==1){$welfare_value=$hallinfo->welfare;}else{$welfare_value=0;}
            if($hallinfo->othersf==1){$others_value=$hallinfo->others;}else{$others_value=0;}
            if($hallinfo->waterf==1){$water_value=$hallinfo->water;}else{$water_value=0;}
            if($hallinfo->wifif==1){$wifi_value=$hallinfo->wifi;}else{$wifi_value=0;}
            if($hallinfo->dirtf==1){$dirt_value=$hallinfo->dirt;}else{$dirt_value=0;}
            if($hallinfo->gassf==1){$gass_value=$hallinfo->gass;}else{$gass_value=0;}
            if($hallinfo->electricityf==1){$electricity_value=$hallinfo->electricity;}else{$electricity_value=0;}
            if($hallinfo->tissuef==1){$tissue_value=$hallinfo->tissue;}else{$tissue_value=0;}
            if($hallinfo->employeef==1){$employee_value=$hallinfo->employee;}else{$employee_value=0;}

          $first_pay_mealamount=($hallinfo->first_payment_meal*($hallinfo->breakfast_rate+$hallinfo->lunch_rate+$hallinfo->dinner_rate));

          $first_others_amount=$friday_value+$feast_value+$welfare_value+$others_value+$water_value+$wifi_value+$dirt_value
                 +$gass_value+$electricity_value+$tissue_value+$employee_value+$hallinfo->card_fee+$hallinfo->security_money+$hallinfo->service_charge;
          $payble_amount1=$first_pay_mealamount+$first_others_amount;
        }else{
            $first_others_amount=0;
            $first_pay_mealamount=0;
            $payble_amount1=0;
        }

       $second_pay_mealon=$hallinfo->section_day-$hallinfo->first_payment_meal;
       $second_pay_mealamount=$cur_meal_amount-$first_pay_mealamount;
       $second_others_amount=$cur_others_amount-$first_others_amount;
       $payble_amount2=$cur_total_amount;

    
    $member_ver=Invoice::where('member_id',$id)->where('invoice_year',$hallinfo->cur_year)->where('hall_id',$hall_id)
      ->where('invoice_month',$hallinfo->cur_month)->where('invoice_section',$hallinfo->cur_section)->count('id');
      
        if($member_ver>0){
           return back()->with('status','Invoice Alrady  Exist'); 
              }else{
                $tran_id1=Str::random(8);
                $tran_id2=Str::random(10);
           DB::insert("insert into `invoices`( `hall_id`, `member_id`,`invoice_date`
             , `invoice_month`,`invoice_year`,`invoice_section` ,`section_day` ,`breakfast_rate`,`lunch_rate`,`dinner_rate`,`refund_breakfast_rate`,`refund_lunch_rate`,`refund_dinner_rate`
             , `friday` ,`feast` ,`employee` ,`welfare`,`others`,`gass`,`electricity`,`tissue`,`water`,`dirt`,`wifi`
             , `card_fee`,`security`,`service_charge`
             , cur_meal_amount,cur_total_amount
             , friday1,friday2,friday3,friday4,friday5
             , `date1`, `date2`, `date3`, `date4`, `date5`, `date6`, `date7`, `date8`, `date9`, `date10`
             , `date11`, `date12`, `date13`, `date14`, `date15`, `date16`, `date17`, `date18`, `date19`
             , `date20`, `date21`, `date22`, `date23`, `date24`, `date25`, `date26`, `date27`, `date28`
             , `date29`, `date30`, `date31`,`meal_start_date`,`meal_end_date`
             , `cur_others_amount`,`payble_amount`,`first_pay_mealon`,`first_pay_mealamount`,`first_others_amount`,`payble_amount1`
             , `second_pay_mealon`,`second_pay_mealamount`,`second_others_amount`,`payble_amount2`,`hostel_fee`
             ,`breakfast_status`,`lunch_status`,`dinner_status`,`gateway_fee`,`tran_id1`,`tran_id2`,`amount1`,`amount2`
             ) values ( 
              '$hall_id','$member->id','$hallinfo->cur_date'
             ,'$hallinfo->cur_month','$hallinfo->cur_year','$hallinfo->cur_section','$hallinfo->section_day','$hallinfo->breakfast_rate','$hallinfo->lunch_rate','$hallinfo->dinner_rate' ,'$hallinfo->refund_breakfast_rate','$hallinfo->refund_lunch_rate','$hallinfo->refund_dinner_rate'   
             ,'$hallinfo->friday','$hallinfo->feast','$hallinfo->employee','$hallinfo->welfare','$hallinfo->others','$hallinfo->gass','$hallinfo->electricity','$hallinfo->tissue','$hallinfo->water','$hallinfo->dirt','$hallinfo->wifi'
             ,'$hallinfo->card_fee','$hallinfo->security_money','$hallinfo->service_charge'
             ,'$cur_meal_amount','$cur_total_amount' 
             ,'$hallinfo->friday1','$hallinfo->friday2','$hallinfo->friday3','$hallinfo->friday4','$hallinfo->friday5'
             ,'$hallinfo->date1','$hallinfo->date2','$hallinfo->date3','$hallinfo->date4','$hallinfo->date5','$hallinfo->date6','$hallinfo->date7'
             ,'$hallinfo->date8','$hallinfo->date9','$hallinfo->date10','$hallinfo->date11','$hallinfo->date12','$hallinfo->date13','$hallinfo->date14'
             ,'$hallinfo->date15','$hallinfo->date16','$hallinfo->date17','$hallinfo->date18','$hallinfo->date19','$hallinfo->date20','$hallinfo->date21'
             ,'$hallinfo->date22','$hallinfo->date23','$hallinfo->date24','$hallinfo->date25','$hallinfo->date26','$hallinfo->date27','$hallinfo->date28'
             ,'$hallinfo->date29','$hallinfo->date30','$hallinfo->date31','$hallinfo->meal_start_date','$hallinfo->meal_end_date'
             ,'$cur_others_amount' ,'$cur_total_amount','$hallinfo->first_payment_meal','$first_pay_mealamount','$first_others_amount','$payble_amount1'
             , '$second_pay_mealon','$second_pay_mealamount','$second_others_amount','$payble_amount2','$member->hostel_fee'
             ,'$hallinfo->breakfast_status' ,'$hallinfo->lunch_status' ,'$hallinfo->dinner_status','$hall->gateway_fee','$tran_id1' ,'$tran_id2'  ,($payble_amount1+$payble_amount1*$hall->gateway_fee/100)
             ,($payble_amount2+$payble_amount2*$hall->gateway_fee/100)
            )");

       DB::update( "update members set admin_verify ='$type' ,verify_month='$hallinfo->cur_month'
         ,verify_year='$hallinfo->cur_year', verify_section='$hallinfo->cur_section' , security_money='$hallinfo->security_money' where id = '$id'");  
        SendEmail($member->email,"Your Member Card ".$member->card, "Your Hall  Verification Successfull", "Your Member Card ".$member->card, "ANCOVA");            
       return back()->with('success','Member Verify Successful');   
           } 
        }
     }
          //} catch (Exception $e) {  return  view('errors.error', ['error' => $e]);  }
    
    
        }


      public function member_delete(Request $request , $id){
         try{ 
          $data = Member::find($id);
          $data->delete();
          return back()->with('success','Data Deleted');  
          
         } catch (Exception $e) {  return  view('errors.error', ['error' => $e]);  }
     }
        


          public function feedback(Request $request)
           {
               $hall_id = $request->header('hall_id');
               $data = Feedback::leftjoin('members', 'members.id', '=', 'feedback.member_id')
               ->where('category','Feedback')->where('feedback.hall_id',$hall_id)
               ->select('members.card','members.name','feedback.*')->get();
                return view('manager.feedback', ['data' => $data]);
           }
        
           public function feedback_delete(Request $request , $id){
              $data = Feedback::find($id);
              $data->delete();
              return back()->with('success','Data Deleted');   
           }
        
        
           public function resignview(Request $request)
           {
               $hall_id = $request->header('hall_id');
               $data = Feedback::leftjoin('members', 'members.id', '=', 'feedback.member_id')
                 ->where('category','Resign')->where('feedback.hall_id',$hall_id)
                  ->select('members.card','members.name','members.member_status','feedback.*')->get();
                  return view('manager.resign', ['data' => $data]);
            }
        
            public function resign_delete(Request $request , $id){
              $data = Feedback::find($id);
              $data->delete();
              return back()->with('success','Data Deleted');   
           }
         

         public function mealon_update(Request $request){
              $hall_id = $request->header('hall_id');
              $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->first();

              $update_time=strtotime($hallinfo->update_time);
              $cur_time=strtotime(date('Y-m-d H:i:s'));
              $mealon_without_payment=$hallinfo->mealon_without_payment;
    
         if($cur_time - $update_time<=900){	
            for($x =1; $x<=$mealon_without_payment ; $x++) { 
                if($hallinfo->breakfast_status==1){
                    DB::update(
                        "update invoices set  
                         b$x=(CASE WHEN pre_last_meal=1 THEN 1 ELSE 0 END)
                         where invoice_month=$hallinfo->cur_month AND invoice_year=$hallinfo->cur_year
                         AND invoice_section='$hallinfo->cur_section' AND hall_id='$hall_id'"
                      );
                    }     

             if($hallinfo->lunch_status==1){
              DB::update(
                  "update invoices set  
                   l$x=(CASE WHEN pre_last_meal=1 THEN 1 ELSE 0 END)
                   where invoice_month=$hallinfo->cur_month AND invoice_year=$hallinfo->cur_year
                   AND invoice_section='$hallinfo->cur_section' AND hall_id='$hall_id'"
                );
              }

              if($hallinfo->dinner_status==1){
                DB::update(
                    "update invoices set  
                     d$x=(CASE WHEN pre_last_meal=1 THEN 1 ELSE 0 END)
                     where invoice_month=$hallinfo->cur_month AND invoice_year=$hallinfo->cur_year
                     AND invoice_section='$hallinfo->cur_section' AND hall_id='$hall_id' "
                  );
                }
  

          }
    
            return back()->with('success','Update Information');
    
        }else{
            return back()->with('fail','Time Over');
        }
      }



      public function daywise_mealupdate(Request $request){
        $day=$request->input('day');
        $status=$request->input('status');
        $meal_type=$request->input('meal_type');
        $hall_id = $request->header('hall_id');
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->first();

        $s=$meal_type.$day;

        DB::update(
           "update invoices set $s=$status where  invoice_month=$hallinfo->cur_month AND invoice_year=$hallinfo->cur_year
           AND invoice_section='$hallinfo->cur_section' AND hall_id='$hall_id' "
          );  
         return back()->with('success','Meal Status Updated');
   }


      public function invoice_all_delete(Request $request){
           
          $month = date('n', strtotime($_POST['month']));
          $year = date('Y', strtotime($_POST['month']));
          $section = $_POST['section'];
          $hall_id = $request->header('hall_id');

          $invoice = Invoice::where('invoice_month',$month)->where('invoice_year',$year)
          ->where('invoice_section',$section)->where('hall_id',$hall_id)->get();

          if($invoice->sum('payment_status1')>=1 || $invoice->sum('payment_status2')>=1 || $invoice->sum('onmeal_amount')>=1){
                  return back()->with('fail','Meal ON or First Payment or Second Payment Already Exists'); 
           }else{
            $invoice = Invoice::where('invoice_month',$month)->where('invoice_year',$year)
            ->where('invoice_section',$section)->where('hall_id',$hall_id)->delete();

                  return back()->with('success','All Invoice Deleted. Please Create New Invoice');
           }      
     }


     public function meeting(Request $request)
     {
        $hall_id = $request->header('hall_id');
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
          if(isset($_GET['session'])) {
               $session=$_GET['session'];       
    
           $invoice=Member::join('invoices','invoices.member_id','=','members.id')->where('session',$session)->where('invoices.hall_id',$hall_id)
           ->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)->where('invoice_section',$hallinfo->cur_section)->orderBy('card', 'ASC')->get();  
        }else{
              $session='';
             
           }
        return view('manager.meeting',['hallinfo' =>$hallinfo,'session'=>$session]);
     } 

     public function meeting_view(Request $request,$session)
     {
        $hall_id = $request->header('hall_id');
        $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','pdf_order')->first();
             $session=$session;
             $invoice=Invoice::leftjoin('members', 'members.id', '=', 'invoices.member_id')
             ->where('invoice_month',$hallinfo->cur_month)->where('invoice_year',$hallinfo->cur_year)->where('invoices.hall_id',$hall_id)
             ->where('invoice_section',$hallinfo->cur_section)->where('members.session',$session)->select('invoices.*','name','registration','card','session')
             ->orderBy($hallinfo->pdf_order,'asc')->get();
          
           return response()->json([
             'status'=>100,  
             'data'=>$invoice,
            
        ]);  
     } 

     public function meeting_update(Request $request){
      
        foreach($request->id as  $key=>$items){ 
    
                  $meeting_present=$request->meeting_present[$key];
                  $id=$request->id[$key];
              
              DB::update("update invoices set meeting_present='$meeting_present'          
                  where id = '$id'");
              }
    
           return response()->json([
                'status'=>100, 
                'message'=>'Data Updated',  
          ]);
       }
    

}
       
        
      
      


     


