<?php

namespace App\Http\Controllers;

use App\Models\Expayemnt;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Models\Hallinfo;


class ExpayemntController extends Controller
{

      public function index(Request $request){
          $hall_id = $request->header('hall_id');
          return view('manager.extra_payment');
      }

     public function fetch(Request $request){
         $hall_id = $request->header('hall_id');
         $data=Expayemnt::Where('hall_id',$hall_id)->orderBy('id','desc')
          ->paginate(10);
          return view('manager.extra_payment_data',['data'=>$data ]);
     }

    public function store(Request $request){
     
        $validator=\Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'amount' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
        ],
        [
            'amount.regex'=>'Qty must be a decimal with up to three decimal places',
         ]);

         if($validator->fails()){
            return response()->json([
              'status'=>700,
              'message'=>$validator->messages(),
            ]);
      }else{     

        $hall_id = $request->header('hall_id');
        $manager_username = $request->header('manager_username');
        $hallinfo=HallInfo::where('hall_id_info',$hall_id)->first();
             $bazar= new Expayemnt;
             $bazar->hall_id=$hallinfo->hall_id_info;
             $bazar->cur_month=$hallinfo->cur_month;
             $bazar->cur_year=$hallinfo->cur_year;
             $bazar->payment_type=$manager_username;
             $bazar->cur_section=$hallinfo->cur_section;
             $bazar->name=$request->input('name');
             $bazar->description=$request->input('description');
             $bazar->amount=$request->input('amount');
             $bazar->save();
            return response()->json([
             'status'=>200,  
             'message'=>'Inserted Data',
           ]);
        }   
    }


    public function edit($id){
       $edit_value=Expayemnt::find($id);
       if($edit_value){
          return response()->json([
               'status'=>200,  
               'edit_value'=>$edit_value,
             ]);
        }else{
            return response()->json([
               'status'=>404,  
               'message'=>'Student not found',
             ]);
        }
    }



    public function update(Request $request, $id){

        $validator=\Validator::make($request->all(),[
            'name'=>'required',
            'description'=>'required',
            'amount'=>'required',
            'amount' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
        ],
        [
            'price.regex'=>'Qty must be a decimal with up to three decimal places',
         ]);

         if($validator->fails()){
            return response()->json([
              'status'=>700,
              'message'=>$validator->messages(),
            ]);
      }else{     

           $bazar=Expayemnt::find($id);
           if($bazar){
              $bazar->cur_month=$request->input('cur_month');
              $bazar->cur_year=$request->input('cur_year');
              $bazar->cur_section=$request->input('cur_section');
              $bazar->name=$request->input('name');
              $bazar->description=$request->input('description');
              $bazar->amount=$request->input('amount');
              $bazar->update();   
            return response()->json([
                 'status'=>200,
                 'message'=>'Data Updated'
             ]);
           }else{
               return response()->json([
                   'status'=>404,  
                   'message'=>'Student not found',
                 ]);
           }
        }
     
    }  

    public function destroy($id){

       $notice=Expayemnt::find($id);
       $notice->delete();
       return response()->json([
          'status'=>200,  
          'message'=>'Deleted Data',
        ]);
   }
   



    function fetch_data(Request $request)
    {
      
       $hall_id = $request->header('hall_id');
    if($request->ajax())
      {
     $sort_by = $request->get('sortby');
     $sort_type = $request->get('sorttype'); 
           $search = $request->get('search');
           $search = str_replace(" ", "%", $search);
           $data=Expayemnt::Where('hall_id',$hall_id)
            ->where(function($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                          ->orWhere('description', 'like', '%'.$search.'%')
                          ->orWhere('amount', 'like', '%'.$search.'%');
               })->orderBy($sort_by, $sort_type)
                   ->paginate(10);
                    return view('manager.extra_payment_data', compact('data'))->render();        
          }
     }


}
