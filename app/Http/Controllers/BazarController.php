<?php

namespace App\Http\Controllers;

use App\Models\Bazar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Models\Hallinfo;
use Exception;

class BazarController extends Controller
{
   
    public function index(Request $request){
        $hall_id = $request->header('hall_id');
        $product=DB::table('products')->where('hall_id',$hall_id)->orderBy('product','asc')->get();
        return view('manager.bazar',['product'=>$product]);
    }


    public function fetch(Request $request){
        $hall_id = $request->header('hall_id');
        $data=Bazar::leftjoin('products','products.id','=','bazars.product_id')
         ->Where('bazars.hall_id',$hall_id)
         ->select('products.product','bazars.*')->orderBy('bazars.id','desc')
         ->paginate(10);
         return view('manager.bazar_data',['data'=>$data ]);
    }

    public function store(Request $request){
     
        $validator=\Validator::make($request->all(),[
            'product_id'=>'required',
            'date'=>'required',
            'unit'=>'required',
            'qty' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
        ],
        [
            'qty.regex'=>'Qty must be a decimal with up to three decimal places',
            'price.regex'=>'Qty must be a decimal with up to three decimal places',
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
             $bazar= new Bazar;
             $bazar->hall_id=$hallinfo->hall_id_info;
             $bazar->date=$request->input('date');
             $bazar->bazar_day=date('d',strtotime($request->input('date')));
             $bazar->bazar_month=$hallinfo->cur_month;
             $bazar->bazar_year=$hallinfo->cur_year;
             $bazar->bazar_type=$manager_username;
             $bazar->bazar_section=$hallinfo->cur_section;
             $bazar->product_id=$request->input('product_id');
             $bazar->category=$request->input('category');
             $bazar->qty=$request->input('qty');
             $bazar->unit=$request->input('unit');
             $bazar->price=$request->input('price');
             $bazar->total=$request->input('price')*$request->input('qty');
             $bazar->save();
            return response()->json([
             'status'=>200,  
             'message'=>'Inserted Data',
           ]);

        }
         
    }


    public function edit($id){
       $edit_value=Bazar::find($id);
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
            'product_id'=>'required',
            'date'=>'required',
            'unit'=>'required',
            'qty' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
            'price' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
        ],
        [
            'qty.regex'=>'Qty must be a decimal with up to three decimal places',
            'price.regex'=>'Qty must be a decimal with up to three decimal places',
         ]);

         if($validator->fails()){
            return response()->json([
              'status'=>700,
              'message'=>$validator->messages(),
            ]);
      }else{     
           $manager_username = $request->header('manager_username');
           $bazar=Bazar::find($id);
           if($bazar){
              $bazar->date=$request->input('date');
              $bazar->bazar_day=date('d',strtotime($request->input('date')));
              $bazar->updated_by=$manager_username;
              $bazar->bazar_month=$request->input('bazar_month');
              $bazar->bazar_year=$request->input('bazar_year');
              $bazar->bazar_section=$request->input('bazar_section');
              $bazar->product_id=$request->input('product_id');
              $bazar->category=$request->input('category');
              $bazar->qty=$request->input('qty');
              $bazar->unit=$request->input('unit');
              $bazar->price=$request->input('price');
              $bazar->total=$request->input('price')*$request->input('qty');
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
       $notice=Bazar::find($id);
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
           $data=Bazar::leftjoin('products','products.id','=','bazars.product_id')
            ->select('products.product','bazars.*')->Where('bazars.hall_id',$hall_id)
            ->where(function($query) use ($search) {
                $query->where('product', 'like', '%'.$search.'%')
                          ->orWhere('date', 'like', '%'.$search.'%')
                          ->orWhere('price', 'like', '%'.$search.'%')
                          ->orWhere('total', 'like', '%'.$search.'%');
               })->orderBy($sort_by, $sort_type)
                   ->paginate(10);
                    return view('manager.bazar_data', compact('data'))->render();        
          }
     }



}
