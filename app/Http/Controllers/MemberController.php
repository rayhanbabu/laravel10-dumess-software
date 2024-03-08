<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Helpers\ForgetJWTToken;
use App\Helpers\MemberJWTToken;


use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Hallinfo;
use App\Models\Hall;
use App\Models\Invoice;
use Exception;

class MemberController extends Controller
{

  public function hall_information()
  {
    try {
      $data = Hall::where('role','admin')->where('web_status',1)->select(
        'university_id',
        'hall_id',
        'hall',
        'level_custom1',
        'level_custom2',
        'level_custom3',
        'level_registration',
        'level_profile_image',
        'level_file_name',
        'frontend_link'
      )->orderBy('id','asc')->get();
        return response()->json([
           'status' => 200,
           'data' => $data,
         ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 900,
        'message' => 'Somting Error',
      ]);
    }
  }


  public function custom1_information($hall_id)
  {
    try {     
         $data = App::where('hall_id', $hall_id)->where('category','Session')->orderBy('serial','desc')->get();
         return response()->json([
            'status' => 200,
            'data' => $data,
         ]);
    } catch (Exception $e) {
      return response()->json([
        'status' => 900,
        'message' => 'Somting Error',
      ]);
    }
  }


  public function application_memebr(Request $request)
  {
    try { 
      $validator = \Validator::make(
      $request->all(),
       [
        'name' => 'required',
        'hall_id' => 'required',
        'password' => 'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'phone' => 'required|min:8|unique:members,phone',
        'registration' => 'required|numeric|min:8|unique:members,registration',
        'email' => 'required|unique:members,email',
        'profile_image' => 'image|mimes:jpeg,png,jpg|max:400',
        'file_name' => 'mimes:jpeg,png,jpg,pdf|max:500',      
        ],

        [
        'password.regex' => 'password minimum six characters including one uppercase letter, one lowercase letter and one number ',
        ]
    );

       // 'registration' => 'required|unique:members,registration,NULL,id,hall_id,'.$request->hall_id,
       // 'registration.unique' =>'Registration Or Seat No Must Be Unique'
       //  registartion number/Seat Number /Du registration = registration 

     $hall_info = Hall::where('role','admin')->where('hall_id',$request->hall_id)->select('application_verify','email_send','web_link','storage')->first();
     if($hall_info->application_verify=='Yes'){
          $application = App::where('hall_id', $request->hall_id)->where('category','Application')
            ->where('phone', $request->input('phone'))->count('id'); 
      }else{
           $application=12;
      }
     
     if(empty($request->registration)){
         $member=Member::where('hall_id',$request->hall_id)->get();
         if($member){
          $registration=$member->max('id')+1;
         }else{
          $registration=1;
         }
         $registration_info = Member::where('hall_id', $request->hall_id)->where('registration', $registration)->first();
     }else{
         $registration_info = Member::where('hall_id', $request->hall_id)->where('registration', $request->input('registration'))->where('member_status',1)->first();
         $registration=$request->input('registration');
      }

      $session=$request->input('custom1');
      $count_session=Member::where('hall_id',$request->hall_id)->where('session',$session)->count('id');

      if($count_session>=1){
           $data_max=Member::where('hall_id',$request->hall_id)->where('session',$session)->max('card');
           $max=substr($data_max,4,3);
           $card=$session*1000+1+$max;
       }else{
           $card=$session*1000+1;
        }
    
    if ($validator->fails()) {
      return response()->json([
        'status' => 700,
        'message' => $validator->messages(),
      ]);
    } else if (empty($hall_info)) {
      return response()->json([
        'status' => 600,
        'message' =>'Invalid hall ID',
      ]);
    } else if ($application<=0) {
      return response()->json([
         'status' => 600,
         'message' => 'Phone Number Not Registered',
      ]);
    }
    else if ($registration_info) {
      return response()->json([
        'status' => 400,
        'message' => "Registration Or Seat No Already Exists",
      ]);
    } else {
      $model = new Member;
      $model->hall_id = $request->hall_id;
      $model->card = $card;
      $model->name = $request->input('name');
      $model->session = $session;
      $model->custom2 = $request->input('custom2');
      $model->custom3 = $request->input('custom3');
      $model->phone = $request->input('phone');
      $model->email = $request->input('email');
      $model->registration = $registration;
       if($hall_info->storage=='Yes'){
           $model->password=Hash::make($request->input('password'));
       }else{
          $model->password = $request->input('password');
       }
      $model->email2 = md5($request->input('email'));
      $model->email_verify = 0;
      $model->verify_time = strtotime(date('Y-m-d H:i:s'));
      $model->admin_verify = 0;
      $model->status = 1;

      if ($request->hasfile('profile_image')) {
          $file = $_FILES['profile_image']['tmp_name'];
          $hw = getimagesize($file);
          $w = $hw[0];
          $h = $hw[1];
       if ($w < 310 && $h < 310) {
           $image = $request->file('profile_image');
           $file_name = 'profile' . rand() . '.' . $image->getClientOriginalExtension();
           $image->move(public_path('uploads/profile'), $file_name);
           $model->profile_image = $file_name;
        } else {
           return response()->json([
              'status' => 300,
              'message' => 'Profile Image size must be 300*300px ',
            ]);
         }
      }

 
      if ($request->hasfile('file_name')) {
        $image1 = $request->file('file_name');
        $file_name1 = 'file' . rand() . '.' . $image1->getClientOriginalExtension();
        $image1->move(public_path('uploads/file_name'), $file_name1);
        $model->file_name = $file_name1;
      }
    

       $model->save();
       
       if($hall_info->email_send=='Yes'){
           $body = 'Please Click URL and verify your email to complete your account setup.';
           $link = $hall_info->web_link . 'emailVerify/' . md5($request->input('email'));
           $body1 = 'Alternatively, paste the following URL into your browser:';
           SendEmail($model->email, $body, $link, $body1, "ANCOVA");
       }

      return response()->json([
         'status' => 200,
         'message' => 'Data Added Successfull',
      ]);
    }

  } catch (Exception $e) {
    return response()->json([
      'status' => $e,
      'message' => 'Somting Error',
    ],501);
  }
  }


  public function member_email_verify(Request $request, $emailmd5)
  {
    $data = Member::where('email2', $emailmd5)->first();
    if ($data) {
      $status = 1;
      if ($data->email_verify == 1) {
        return response()->json([
          'status' => 400,
          'message' => 'E-mail already verified',
        ]);
      } else {
        DB::update(
          "update members set email_verify ='$status' where email2 ='$emailmd5'"
        );
        return response()->json([
          'status' => 200,
          'message' => 'E-mail verify Successfull',
        ]);
      }
    } else {
      return response()->json([
        'status' => 600,
        'message' => "Invalid Email",
      ]);
    }
  }



  public function forget_password(request $request)
  {
    $email = $request->email;
    $rand = rand(11111, 99999);
    $email_exist = Member::where('email', $email)->where('member_status', 1)->count('email');
    if ($email_exist >= 1) {
      DB::update("update members set forget_code ='$rand' where email = '$email'");

      SendEmail($email, "Password Recovary code", "One Time  Code", $rand, "ANCOVA");

      $TOKEN_FORGET = ForgetJWTToken::CreateToken($email);

      return response()->json([
        'status' => 200,
        'TOKEN_FORGET' => $TOKEN_FORGET,
        'message' => 'Recovery code send your E-mail',
      ]);
    } else {
      return response()->json([
        'status' => 600,
        'message' => 'Invalid  Email ',
      ]);
    }
  }



  public function forget_code(request $request)
  {

    $email = $request->header('email');
    $code = $request->forget_code;
    $email_exist = Member::where('email', $email)->where('member_status', 1)->count('email');
    if ($email_exist >= 1 or $code > 11) {
      $code_exist = Member::where('email', $email)->where('forget_code', $code)->count('email');

      if ($code_exist >= 1) {
        DB::update("update members set  forget_code ='nullvalue' where email = '$email'");
        return response()->json([
          'status' => 200,
          'message' => 'Code Match',
        ]);
      } else {
        return response()->json([
          'status' => 400,
          'message' => 'Invalid Recovery Code',
        ]);
      }
    } else {
      return response()->json([
        'status' => 600,
        'message' => 'Recovery code not empty ',
      ]);
    }
  }


  public function confirm_password(request $request)
  {
    $email = $request->header('email');
    $validator = \Validator::make(
      $request->all(),
      [
        'new_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'confirm_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
      ],
      [
        'new_password.regex' => 'password minimum six characters including one uppercase 
              letter, one lowercase letter and one number ',
        'confirm_password.regex' => 'password minimum six characters including one uppercase letter, one 
                       lowercase letter and one number '
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'status' => 700,
        'message' => $validator->messages(),
      ]);
    } else {
      $rend = rand();
      $new_password = $request->new_password;
      $confirm_password = $request->confirm_password;
      $hash_password=Hash::make($new_password);
      if ($new_password == $confirm_password) {
        $code_exist = Member::where('email', $email)->where('member_status', 1)->where('forget_code', 'nullvalue')->count('email');
        if ($code_exist >= 1) {
          DB::update("update members set password ='$hash_password', forget_code ='$rend' where email = '$email'");
          return response()->json([
            'status' => 200,
            'message' => 'Password Change Successfull',
          ]);
        } else {
          return response()->json([
            'status' => 600,
            'message' => 'Invalid Verification code',
          ]);
        }
      } else {
        return response()->json([
          'status' => 300,
          'message' => 'New Passsword & Confirm Passsword is not match',
        ]);
      }
    }
  }



  public function member_login(Request $request)
  {

    $validator = \Validator::make(
      $request->all(),
      [
        'registration' => 'required',
        'password' => 'required',
      ],
      [
        'password.required' => 'Password is required',
      ]
    );

    if ($validator->fails()) {
      return response()->json([
        'status' => 700,
        'message' => $validator->messages(),
      ]);
    } else {
      $status = 1;
      $member = Member::where('registration',$request->registration)->first();
      if ($member) {
        if (Hash::check($request->password,$member->password)) {
          if ($member->status == $status && $member->member_status==$status) {
            if ($member->email_verify == $status) {
              if ($member->admin_verify == $status) {
              $token = MemberJWTToken::CreateToken($member->name, $member->email, $member->id, $member->hall_id, $member->role);
            
              $hall = Hall::leftjoin('univers','univers.id','=','halls.university_id')
              ->where('role','admin')->where('hall_id',$member->hall_id)
              ->select('univers.university','halls.hall')->first();
              $memberinfo = Member::where('registration',$request->registration)->select('name','email','hall_id','card','registration','profile_image')->first();
              //Cookie::queue('token_login',$token,60*24);
              //->cookie('TOKEN_LOGIN',$token,60*24*30)
              return response()->json([
                'status' => 200,
                'message' => 'success login',
                'TOKEN_MEMBER' => $token,
                'hall_info'=>$hall,
                'member_info'=>$memberinfo
              ]);

            } else {
               return response()->json([
                  'status' => 900,
                  'message' => 'Waiting for Hall Varification',
               ]);
            }

            } else {
              return response()->json([
                'status' => 900,
                'message' => 'Pending  Email Verification',
              ]);
            }
          } else {
            return response()->json([
              'status' => 800,
              'message' => 'Acount Inactive Or Resign Member',
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
          'message' => 'Invalid Registration Number',
        ]);
      }
    }
  }


  public function profile_view(Request $request)
   {
     $member_id = $request->header('member_id');
     $member = Member::where('id', $member_id)->first();
     return response()->json([
         'status' => 200,
         'data' => $member,
       ]);
   }


  public function profile_update(Request $request)
  {

    $member_id = $request->header('member_id');

    $validator = \Validator::make(
      $request->all(),
      [
        'name' => 'required',
        'phone' => 'required|min:11|unique:members,phone,' . $member_id,
        'email' => 'required|unique:members,email,' . $member_id,
        
      ],
    );

    //'profile_image' => 'image|mimes:jpeg,png,jpg|max:412000',

    if ($validator->fails()) {
      return response()->json([
        'status' => 700,
        'message' => $validator->messages(),
      ]);
    } else {

      $model = Member::find($member_id);

      $model->name = $request->input('name');
      // $model->email = $request->input('email');
      //$model->phone = $request->input('phone');
      $model->birth_date = $request->input('birth_date');
      $model->father = $request->input('father');
      $model->mother = $request->input('mother');
      $model->dept = $request->input('dept');
      $model->nation = $request->input('nation');
      $model->religion = $request->input('religion');
      $model->division = $request->input('division');
      $model->zila = $request->input('zila');
      $model->upazila = $request->input('upazila');
      $model->postcode = $request->input('postcode');
      $model->village = $request->input('village');


      if ($request->hasfile('profile_image')) {
        $file = $_FILES['profile_image']['tmp_name'];
        $hw = getimagesize($file);
        $w = $hw[0];
        $h = $hw[1];
        if ($w < 310 && $h < 310) {
          $filePath = public_path('uploads/profile') . '/' . $model->profile_image;
          if (file_exists($filePath)) {
            unlink($filePath);
          }
          $image = $request->file('profile_image');
          $file_name = 'profile' . rand() . '.' . $image->getClientOriginalExtension();
          $image->move(public_path('uploads/profile'), $file_name);
          $model->profile_image = $file_name;
        } else {
          return response()->json([
            'status' => 600,
            'message' => 'Profile Image size must be 300*300px ',
          ]);
        }
      }

      $model->save();
      return response()->json([
        'status' => 200,
        'data' => $model,
      ]);
    }
  }



  public function password_update(request $request)
   {
    $validator = \Validator::make(
      $request->all(),
       [
        'old_password'  => 'required',
        'new_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        'confirm_password'  => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
       ],
       [
        'new_password.regex' => 'password minimum six characters including one uppercase letter, one lowercase letter and one number '
       ]
    );

    if ($validator->fails()) {
      return response()->json([
           'status' => 700,
           'message' => $validator->messages(),
      ]);
    } else {
      $member_id = $request->header('member_id');
      $oldpassword = $request->input('old_password');
      $npass = $request->input('new_password');
      $cpass = $request->input('confirm_password');

      $member = Member::where('id', $member_id)->first();
     
     
      if (Hash::check($oldpassword,$member->password)) {
        if ($npass == $cpass) {
          $student = Member::find($member_id);
          $student->password=Hash::make($npass);
          //$student->password = $npass;
          $student->update();
          return response()->json([
            'status' => 200,
            'message' => 'Passsword change  successfully',
          ]);
        } else {
          return response()->json([
            'status' => 600,
            'message' => 'New Passsword & Confirm Passsword is not match',
          ]);
        }
      } else {

        return response()->json([
          'status' => 400,
          'message' => 'Invalid Old Password',
        ]);
      }
     }
  
   }




   public function invoice_view(Request $request)
   {
      $member_id = $request->header('member_id');
      $hall_id = $request->header('hall_id');
      $data = Invoice::where('member_id', $member_id)->where('hall_id', $hall_id)
      ->orderBy('id','desc')->get();
        return response()->json([
           'status' => 200,
           'data' => $data,
        ]);
   }


   public function cur_invoice_view(Request $request)
    {
       $member_id = $request->header('member_id');
       $hall_id = $request->header('hall_id');
       $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section')->first();
       $data = Invoice::where('member_id', $member_id)->where('hall_id', $hall_id)->where('invoice_year', $hallinfo->cur_year)
         ->where('invoice_month', $hallinfo->cur_month)->where('invoice_section', $hallinfo->cur_section)->first();
             return response()->json([
                'status' => 200,
                'data' => $data,
             ]);
    }



    public function meal_off_on(request $request){
         
           $meal_status=$request->input('meal_status');
           $meal_name=$request->input('meal_name');
           $member_id = $request->header('member_id');
           $hall_id = $request->header('hall_id');
           $email = $request->header('email');
           $name = $request->header('name');
           $hallinfo=Hallinfo::where('hall_id_info',$hall_id)->select('cur_month','cur_year','cur_section','add_minute'
           ,'mealon_without_payment','max_meal_off','last_meal_off','section_day')->first();
           $data = Invoice::where('member_id',$member_id)->where('hall_id',$hall_id)->where('invoice_year', $hallinfo->cur_year)
           ->where('invoice_month',$hallinfo->cur_month)->where('invoice_section',$hallinfo->cur_section)->first();

          

              $next=$hallinfo->add_minute;
              $cur_time=strtotime(date('Y-m-d H:i:s',strtotime("+".$next." minute")));
              $meal_no=substr($meal_name,1,2);
              $date='date'.$meal_no;
              $meal_date=strtotime($data->$date);

              if($meal_status==1){
                    $status=0;
                    $body="Your Meal Will OFF on ". date('d-F-Y',strtotime($data->$date));
                }else if($meal_status==0){
                    $status=1;
                    $body="Your Meal Will ON on ". date('d-F-Y',strtotime($data->$date));
                }

             $sum1=0;
             $max_meal=$hallinfo->max_meal_off;
             $section_day=$hallinfo->section_day;
             for($x=1; $x<=$section_day; $x++){
                 $sum = Invoice::where('member_id',$member_id)->where('hall_id',$hall_id)->where('invoice_year',$hallinfo->cur_year)
                ->where('invoice_month',$hallinfo->cur_month)->where('invoice_section',$hallinfo->cur_section)->sum('l'.$x);
                   if($sum==9){
                       $sum2=1;
                   }else{
                       $sum2=$sum;
                    }
                    $sum1+=$sum2;
                }
            $meal_total_on= $sum1;  

    
           if($meal_status==9){
                return response()->json([
                   'status' => 400,
                   'message' => "This Meal Inactive",
               ]);
            }else if($meal_date<$cur_time){
                return response()->json([
                   'status' => 400,
                   'message' => "Time Over",
                ]);
            }else if($meal_no<=$hallinfo->mealon_without_payment){
                  $diff=$data->pre_monthdue-($data->pre_refund+$data->pre_refund);
                  $payment = $data->payment_status1+$data->payment_status2;         
                  if($diff>0 && $payment==0){    
                      return response()->json([
                         'status' => 400,
                         'message' => " Please pay the security deposit you have consumed"
                      ]);
                  }else{
                        DB::update("update invoices set  $meal_name = $status where id=$data->id");
                        member_meal_update($data);
                        SendEmail($email, $body, $name, $body, "ANCOVA");
                        return response()->json([
                           'status' => 200,
                           'message' => " Meal Status updated"
                        ]);
                    }
           }else if($hallinfo->mealon_without_payment<=0 && ($section_day-($meal_total_on-$meal_status))>$max_meal){
               return response()->json([
                      'status'=>200,  
                      'alert'=>'danger',   
                      'message'=>'Can Not Meal Off more than '.$max_meal.' meals',
                ]);

           } else{
                if($data->payment_status2==1){  //2nd Payment Status
                 
                    DB::update("update invoices set  $meal_name = $status  where  id= $data->id");
                       member_meal_update($data);
                       SendEmail($email, $body, $name, $body, "ANCOVA");
                      return response()->json([
                         'status' => 200,
                          'message' => "Meal Status updated"
                        ]);

                 }else if($data->payment_status1==1){  //1st Payment Status
                         if($meal_no<=$data->first_pay_mealon){ //1st Payment Meal Number 
                            DB::update("update invoices set  $meal_name = $status  where  id= $data->id");
                            member_meal_update($data);
                            SendEmail($email, $body, $name, $body, "ANCOVA");
                            return response()->json([
                                'status' => 200,
                                'message' => "Meal Status updated"
                             ]);
                         }else{
                              return response()->json([
                                   'status' => 400,
                                   'message' => "Please Paid 2nd Payment",
                                 ]);
                          }
                  }else{
                     return response()->json([
                         'status' => 400,
                         'message' => "Please Payment at First",
                      ]);
                 }

             }
       }

 







}
