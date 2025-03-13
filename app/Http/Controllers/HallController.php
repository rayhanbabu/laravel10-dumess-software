<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Univer;
use App\Models\Hallinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class HallController extends Controller
{
   
    public function hall_view(){
      try{ 
          $data=Univer::orderBy('id','asc')->get();
          return view('maintain.hall',["data"=>$data]);
       }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
     }

     public function store(Request $request){
      $validator=\Validator::make($request->all(),[    
         'hall'=>'required',
         'phone'=>'required|unique:halls,phone',
         'email'=>'required|unique:halls,email',
         'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
         'image' => 'image|mimes:jpeg,png,jpg|max:400',
       ],
        [
         'password.regex'=>'password minimum six characters including one uppercase letter, 
          one lowercase letter and one number'
       ]);

     if($validator->fails()){
            return response()->json([
              'status'=>700,
              'message'=>$validator->messages(),
           ]);
     }else{

            $model= new Hall;
            $model->university_id=$request->input('university_id');
            $model->hall=$request->input('hall');
            $model->password=$request->input('password');
            $model->email=$request->input('email');
            $model->phone=$request->input('phone');
            $model->manager_username=Str::slug(substr($request->input('hall'),0,8),'_');
            $model->level_custom1=$request->input('level_custom1');
            $model->level_custom2=$request->input('level_custom2');
            $model->level_custom3=$request->input('level_custom3');
            $model->status=1;
            $model->hall_id=Str::random(8);
            $model->role='admin';
            $model->save();


            $hallinfo=new Hallinfo;
            $hallinfo->hall_id_info=$model->hall_id;
            $hallinfo->hall_name=$model->hall;
            $hallinfo->cur_date=date('Y-m-d');
            $hallinfo->cur_month=date('n');
            $hallinfo->cur_year=date('Y');
            $hallinfo->cur_section='A';
            $hallinfo->save();

            return response()->json([
                  'status'=>200,  
                  'message'=>'Data Added Successfull',
             ]);     
        }
    }

   public function hall_edit(Request $request) {
     $id = $request->id;
     $data = Hall::find($id);
     return response()->json([
         'status'=>200,  
         'data'=>$data,
      ]);
   }


   public function hall_update(Request $request ){
    $validator=\Validator::make($request->all(),[    
      'hall'=>'required',
      'phone'=>'required|unique:halls,phone,'.$request->input('edit_id'),
      'email'=>'required|unique:halls,email,'.$request->input('edit_id'),
      'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
      'image' => 'image|mimes:jpeg,png,jpg|max:400',
    ],
     [
      'password.regex'=>'password minimum six characters including one uppercase letter, 
       one lowercase letter and one number'
    ]);

  if($validator->fails()){
         return response()->json([
           'status'=>700,
           'message'=>$validator->messages(),
        ]);
  }else{
         $model=Hall::find($request->input('edit_id'));
    if($model){
         $model->university_id=$request->input('university_id');
         $model->hall=$request->input('hall');
         $model->manager_username=Str::slug(substr($request->input('hall'),0,8),'_');
         $model->password=$request->input('password');
         $model->email=$request->input('email');
         $model->phone=$request->input('phone');
         $model->status=$request->input('status');
         $model->level_custom1=$request->input('level_custom1');
         $model->level_custom2=$request->input('level_custom2');
         $model->level_custom3=$request->input('level_custom3');
         $model->level_registration=$request->input('level_registration');
         $model->level_profile_image=$request->input('level_profile_image');
         $model->level_file_name=$request->input('level_file_name');
         $model->level_email_name=$request->input('level_email_name');
         $model->frontend_link=$request->input('frontend_link');
         $model->meal=$request->input('meal');
         $model->member=$request->input('member'); 
         $model->member_edit=$request->input('member_edit'); 
         $model->payment=$request->input('payment');
         $model->bazar=$request->input('bazar'); 
         $model->application=$request->input('application');
         $model->application_verify=$request->input('application_verify');
         $model->resign=$request->input('resign');
         $model->booking=$request->input('booking');
         $model->others_access=$request->input('others_access');
         $model->storage=$request->input('storage');
         $model->refund_status=$request->input('refund_status');
         $model->email_send=$request->input('email_send');
         $model->web_link=$request->input('web_link');
         $model->web_status=$request->input('web_status');

         $model->gateway_fee=$request->input('gateway_fee');
         $model->online_payment=$request->input('online_payment');
         $model->bank_name=$request->input('bank_name');
         $model->bank_account_name=$request->input('bank_account_name');
         $model->bank_account=$request->input('bank_account');
         $model->bank_route=$request->input('bank_route');
         $model->two_factor=$request->input('two_factor');

         $model->update();   
          return response()->json([ 
             'status'=>200,
             'message'=>'Data Updated Successfull'
          ]);
      }else{
        return response()->json([
            'status'=>404,  
            'message'=>'Student not found',
          ]);
    }

    }
  }


  public function hall_delete(Request $request) { 
      $hallinfo=Hallinfo::where('hall_id_info',$request->input('id'))->count('id');
       if($hallinfo>0){
          return response()->json([
            'status'=>200,  
            'message'=>'Can not delete this record. This hall is used in hall info table.',
           ]);
        }else{
          $model=Hall::find($request->input('id'));
          $model->delete();
          return response()->json([
             'status'=>300,  
             'message'=>'Data Deleted Successfully',
        ]);
        
      }
   } 
  


  public function fetch(){
    $data=Hall::leftjoin('univers','univers.id', '=','halls.university_id')
      ->where('role','admin')
    ->select('univers.university','halls.*')->paginate(10);
   
      return view('maintain.hall_data',compact('data'));
 }



  function fetch_data(Request $request)
  {
   if($request->ajax())
   {
         $sort_by = $request->get('sortby');
         $sort_type = $request->get('sorttype'); 
            $search = $request->get('search');
            $search = str_replace("","%", $search);
         $data = Hall::leftjoin('univers','univers.id', '=','halls.university_id')
          ->where('role','admin')
          ->where(function($query) use ($search) {
                $query->where('univers.university', 'like', '%'.$search.'%')
                    ->orWhere('hall', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('hall_id', 'like', '%'.$search.'%')
                    ->orWhere('phone', 'like', '%'.$search.'%');
              })->select('univers.university','halls.*')->paginate(10);
                  return view('maintain.hall_data', compact('data'))->render();
                 
      }
  }

    


}
