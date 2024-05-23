<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Models\Hall;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\File;

class WithdrawController extends Controller
{
    
    public function withdraw_index(){
        $admin= Hall::where('role','admin')->get();
        return view('maintain.withdraw',['admin'=>$admin]);
    }

  public function withdraw_fetch(){
     $data=Withdraw::orderBy('id', 'desc')->paginate(15);
       return view('maintain.withdraw_data',compact('data'));
  }

function withdraw_fetch_data(Request $request,$admin_category)
{

if($request->ajax())
    {
     $sort_by = $request->get('sortby');
     $sort_type = $request->get('sorttype'); 
       $search = $request->get('search');
       $search = str_replace(" ", "%", $search);
      $data = Withdraw::where(function($query) use ($search) {
              $query->orwhere('admin_name','like','%'.$search.'%');
              $query->orWhere('bank_account','like', '%'.$search.'%');
              $query->orWhere('bank_name','like', '%'.$search.'%');
              $query->orWhere('bank_info','like', '%'.$search.'%');
              })->orderBy($sort_by, $sort_type)->paginate(15);
         return view('maintain.withdraw_data', compact('data'))->render();          
       }

  }


   public function withdraw_add(Request $request){
  
        $validator=\Validator::make($request->all(),[  
           'withdraw_amount' => 'required|numeric',
         ],
       );
       $hall_id=$request->input('hall_id');
       $month = date('n', strtotime($_POST['month']));
       $year = date('Y', strtotime($_POST['month']));
       $hall= Hall::where('role','admin')->where('hall_id',$hall_id)->first();
       if($validator->fails()){
          return response()->json([
              'status'=>700,
              'message'=>$validator->messages(),
            ]);
        }else{
              $app= new Withdraw;
              $app->withdraw_amount=$request->input('withdraw_amount');
              $app->bank_route=$hall->bank_route;
              $app->hall_name=$hall->hall;
              $app->bank_account=$hall->bank_account;
              $app->withdraw_year=$year; 
              $app->withdraw_month=$month;
              $app->withdraw_section=$request->input('section');
              $app->bank_account_name=$hall->bank_account_name;
              $app->bank_name=$hall->bank_name;
              $app->withdraw_submited_time=date('Y-m-d H:i:s');
              $app->hall_id=$request->input('hall_id');
              $app->save();
              return response()->json([
                 'status'=>200,  
                 'message'=>'Inserted Data',
              ]);   
       }
     
    }



public function withdraw_status(Request $request,$operator,$status,$id){
 
     $maintain_id = $request->header('maintain_id');
     if($operator=='status'){  
        if($status=='deactive'){
              $type=0;
              $payment_time=date('2010-10-10 10:10:10');
              $payment_type='';
         }else{
              $type=1;
              $payment_time=date('Y-m-d H:i:s');
              $payment_type=$maintain_id;
          }

        $payment_date = date('Y-m-d');
   
        $model=Withdraw::find($id);
        $model->withdraw_status=$type; 
        $model->withdraw_type=$payment_type; 
        $model->withdraw_time=$payment_time;
        $model->withdraw_date=$payment_date;
        $model->updated_by=$maintain_id;
        $model->updated_by_time=date('Y-m-d H:i:s');  
        $model->update();

        return back()->with('success','Status update Successfull');        
   }
   else if($operator=='verify'){
        if($status=='deactive'){
             $type=0;
        }else{
             $type=1;
         }
      return back()->with('success','Status update Successfull');     
         
 }else{ return back()->with('fail','Something Rong');}


   //}catch (Exception $e) { return  'something is Rong'; }
 }


 public function withdraw_update(Request $request)
 {
     $maintain_id = $request->header('maintain_id');
      $validated = $request->validate([
          'image' =>'image|mimes:jpeg,png,jpg|max:512000',
          'withdraw_info'=>'required',
      ]);

    $model = Withdraw::find($request->input('id'));
    $model->withdraw_info=$request->input('withdraw_info');
    $model->withdraw_info_update=$maintain_id;
    $model->updated_by='';
    $model->updated_by_time=date('Y-m-d H:i:s');

    if($request->hasfile('image')){
        $path=public_path('uploads/admin/').$model->image;
         if(File::exists($path)){
            File::delete($path);
          }
         $image= $request->file('image');
         $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('uploads/admin'), $file_name);
         $model->image=$file_name;
     }
    $model->save();

    return redirect()->back()->with('success','Data Updated Successfuly');
}




   public function manager_withdraw_index(){ 
      return view('manager.withdraw');
    }

    public function manager_withdraw_fetch(Request $request){
         $hall_id = $request->header('hall_id');
         $data=Withdraw::orderBy('id','desc')->where('hall_id',$hall_id)->paginate(15);
         return view('manager.withdraw_data',compact('data'));
      }



function manager_withdraw_fetch_data(Request $request)
  {
   if($request->ajax())
    {
     $hall_id = $request->header('hall_id');
     $sort_by = $request->get('sortby');
     $sort_type = $request->get('sorttype'); 
     $search = $request->get('search');
     $search = str_replace(" ", "%", $search);
     $data = Withdraw::where('hall_id',$hall_id)->where(function($query) use ($search) {
         $query->orwhere('hall_name','like','%'.$search.'%');
         $query->orWhere('bank_account','like', '%'.$search.'%');
         $query->orWhere('bank_name','like', '%'.$search.'%');
         })->orderBy($sort_by, $sort_type)->paginate(15);
        return view('maintain.withdraw_data', compact('data'))->render();          
       }
    }


}
