<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\validator;

class FeedbackController extends Controller
{
      
public function member_feedback(Request $request,$category){    
       $validator=\Validator::make($request->all(),[    
         'subject'=>'required',
         'text'=>'required',
      ]);
  
      $member_id=$request->header('member_id');
      $hall_id=$request->header('hall_id');

      if($validator->fails()){
           return response()->json([
             'status'=>700,
             'message'=>$validator->messages(),
          ]);
     }else{
        $time=date('Y-m-d H:i:s');
        $model= new Feedback;
        $model->hall_id=$hall_id;
        $model->member_id=$member_id;
        $model->submited_time=$time; 
        $model->category=$category; 
        $model->subject=$request->input('subject');
        $model->text=$request->input('text');
        $model->resign_month=$request->input('resign_month');
        $model->save();

        return response()->json([
            'status'=>200,
            'message'=>"Data saved successfully",
       ]); 

     }

    }


    public function member_feedback_view(Request $request,$category){
           $member_id=$request->header('member_id');
           $hall_id=$request->header('hall_id');
           $data= Feedback::where('category',$category)->where('member_id',$member_id)->where('hall_id',$hall_id)->get();
           return response()->json([
           'status'=>200,
            'data'=>$data,
       ]);
    }

    public function member_feedback_delete(Request $request,$id){
           $member_id=$request->header('member_id');
           $hall_id=$request->header('hall_idr');
           $data= Feedback::where('id',$id)->where('member_id',$member_id)->where('hall_id',$hall_id)->delete();
           return response()->json([
             'status'=>200,
             'message'=>"data deleted successfully",
       ]);  
    }



    public function contact_form(Request $request){    
      $validator=\Validator::make($request->all(),[    
        'subject'=>'required',
        'text'=>'required',
        'text1'=>'required',
     ]);
 
     $member_id=1;
     $hall_id='Message';

     if($validator->fails()){
          return response()->json([
            'status'=>700,
            'message'=>$validator->messages(),
         ]);
    }else{
       $time=date('Y-m-d H:i:s');
       $model= new Feedback;
       $model->hall_id=$hall_id;
       $model->member_id=$member_id;
       $model->submited_time=$time; 
       $model->category='Message'; 
       $model->subject=$request->input('subject');
       $model->text=$request->input('text');
       $model->text1=$request->input('text1');
       $model->save();

       return response()->json([
           'status'=>200,
           'message'=>"Data saved successfully",
      ]); 

    }

   }

   

}
