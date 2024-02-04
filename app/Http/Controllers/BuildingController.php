<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Exception;

class BuildingController extends Controller
{
  
     public function building_view(Request $request){
         try{ 
              
               return view('manager.building');
            }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
       }
  
       public function store(Request $request){

        $hall_id = $request->header('hall_id');
        $validator=\Validator::make($request->all(),[    
             'building_name' => 'required|unique:buildings,building_name,' . 'NULL,id,hall_id,' . $hall_id,
             'building_address'=>'required',
             'image' => 'required|image|mimes:jpeg,png,jpg|max:500',
         ]);
  
       if($validator->fails()){
              return response()->json([
                'status'=>700,
                'message'=>$validator->messages(),
             ]);
       }else{
  
              $model= new Building;
              $model->hall_id=$hall_id;
              $model->building_name=$request->input('building_name');
              $model->building_address=$request->input('building_address');
              $model->building_details=$request->input('building_details');
              if ($request->hasfile('image')) {
                $imgfile = 'booking-';
                $size = $request->file('image')->getsize();
                $file = $_FILES['image']['tmp_name'];
                $hw = getimagesize($file);
                $w = $hw[0];
                $h = $hw[1];
                if ($w < 410 && $h < 410) {
                    $image = $request->file('image');
                    $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/booking'), $new_name);
                    $model->building_image = $new_name;
                 } else {
                    return response()->json([
                        'status' => 300,
                        'message' => 'Image size must be 400*400px',
                    ]);
                  }
              }
             
              $model->save();
  
              return response()->json([
                    'status'=>200,  
                    'message'=>'Data Added Successfull',
               ]);     
          }
      }
  
     public function building_edit(Request $request) {
       $id = $request->id;
       $data = Building::find($id);
       return response()->json([
           'status'=>200,  
           'data'=>$data,
        ]);
     }
  
  
     public function building_update(Request $request ){

      $hall_id = $request->header('hall_id');
      $validator=\Validator::make($request->all(),[    
        'building_name' => 'required|unique:buildings,building_name,'.$request->input('edit_id') . 'NULL,id,hall_id,' . $hall_id,
        'building_address'=>'required',
        'image' => 'image|mimes:jpeg,png,jpg|max:500',
      ]);
  
    if($validator->fails()){
           return response()->json([
             'status'=>700,
             'message'=>$validator->messages(),
          ]);
    }else{
           $model=Building::find($request->input('edit_id'));
      if($model){
           $model->building_name=$request->input('building_name');
           $model->building_address=$request->input('building_address');
           $model->building_details=$request->input('building_details');
           $model->building_status=$request->input('building_status');

          if ($request->hasfile('image')) {
            $imgfile = 'booking-';
            $size = $request->file('image')->getsize();
            $file = $_FILES['image']['tmp_name'];
            $hw = getimagesize($file);
            $w = $hw[0];
            $h = $hw[1];
             if ($w < 410 && $h < 410) {

              $path = public_path('uploads/booking') . '/' . $model->building_image;
              if(File::exists($path)){
                File::delete($path);
                }
                $image = $request->file('image');
                $new_name = $imgfile . rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/booking'), $new_name);
                $model->building_image = $new_name;
             } else {
                return response()->json([
                    'status' => 300,
                    'message' => 'Image size must be 400*400px',
                ]);
              }
          }
         
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
  
  
    public function building_delete(Request $request) { 
  
        // $hallinfo=Building::where('id',$request->input('id'))->count('id');
        //  if($hallinfo>0){
        //     return response()->json([
        //       'status'=>200,  
        //       'message'=>'Can not delete this record. This hall is used in hall info table.',
        //      ]);
        //   }else{
            $model=Building::find($request->input('id'));
            $filePath = public_path('uploads/booking') . '/' . $model->building_image;
            if(File::exists($filePath)){
                  File::delete($filePath);
             }
            $model->delete();
            return response()->json([
               'status'=>300,  
               'message'=>'Data Deleted Successfully',
          ]);
          
      // }
     } 
    
  
  
    public function fetch(Request $request){
     
        $hall_id = $request->header('hall_id');
        $data=Building::where('hall_id',$hall_id)->orderBy('id','desc')->paginate(10);
        return view('manager.building_data',compact('data'));
     }
  
  
  
    function fetch_data(Request $request)
    {
     if($request->ajax())
     {
           $hall_id = $request->header('hall_id');
           $sort_by = $request->get('sortby');
           $sort_type = $request->get('sorttype'); 
              $search = $request->get('search');
              $search = str_replace("","%", $search);
           $data = Building::where('hall_id',$hall_id)
            ->where(function($query) use ($search) {
                  $query->where('building_address', 'like', '%'.$search.'%')
                      ->orWhere('building_name', 'like', '%'.$search.'%')
                      ->orWhere('building_details', 'like', '%'.$search.'%');
                })->paginate(10);
                    return view('manager.building_data', compact('data'))->render();
                   
        }
    }



    


}
