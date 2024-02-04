<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Exception;

class RoomController extends Controller
{
    public function room_view(Request $request){
        try{ 
              $hall_id = $request->header('hall_id');
              $building=Building::where('hall_id',$hall_id)->orderBy('id','asc')->get(); 
              return view('manager.room',['building'=>$building]);
           }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
      }
 
      public function store(Request $request){

       $hall_id = $request->header('hall_id');
       $validator=\Validator::make($request->all(),[    
            'room_name' => 'required|unique:rooms,room_name,' . 'NULL,id,hall_id,' . $hall_id,
            'building_id'=>'required',
            'floor_name'=>'required',
            'image1' => 'required|image|mimes:jpeg,png,jpg|max:500',
            'image2' => 'image|mimes:jpeg,png,jpg|max:500',
            'image3' => 'image|mimes:jpeg,png,jpg|max:500',
        ]);
 
      if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);
      }else{
 
             $model= new Room;
             $model->hall_id=$hall_id;
             $model->room_name=$request->input('room_name');
             $model->building_id=$request->input('building_id');
             $model->floor_name=$request->input('floor_name');
             $model->flat_name=$request->input('flat_name');
             $model->room_details=$request->input('room_details');
             $model->youtube_link=$request->input('youtube_link');

             if ($request->hasfile('image1')) {
               $imgfile = 'booking-';
               $size = $request->file('image1')->getsize();
               $file = $_FILES['image1']['tmp_name'];
               $hw = getimagesize($file);
               $w = $hw[0];
               $h = $hw[1];
               if ($w < 610 && $h < 410) {
                   $image1 = $request->file('image1');
                   $new_name = $imgfile . rand() . '.' . $image1->getClientOriginalExtension();
                   $image1->move(public_path('uploads/booking'), $new_name);
                   $model->image1 = $new_name;
                } else {
                   return response()->json([
                       'status' => 300,
                       'message' => 'Image size must be 400*600px',
                   ]);
                 }
             }


             if ($request->hasfile('image2')) {
                $imgfile = 'booking22-';
                $size = $request->file('image2')->getsize();
                $file = $_FILES['image2']['tmp_name'];
                $hw = getimagesize($file);
                $w = $hw[0];
                $h = $hw[1];
                if ($w < 610 && $h < 410) {
                    $image2 = $request->file('image2');
                    $new_name = $imgfile . rand() . '.' . $image2->getClientOriginalExtension();
                    $image2->move(public_path('uploads/booking'), $new_name);
                    $model->image2 = $new_name;
                 } else {
                    return response()->json([
                        'status' => 300,
                        'message' => 'Image size must be 400*600px',
                    ]);
                  }
              }


              if ($request->hasfile('image3')) {
                $imgfile = 'booking33-';
                $size = $request->file('image3')->getsize();
                $file = $_FILES['image3']['tmp_name'];
                $hw = getimagesize($file);
                $w = $hw[0];
                $h = $hw[1];
                if ($w < 610 && $h < 410) {
                    $image3 = $request->file('image3');
                    $new_name = $imgfile . rand() . '.' . $image3->getClientOriginalExtension();
                    $image3->move(public_path('uploads/booking'), $new_name);
                    $model->image3 = $new_name;
                 } else {
                    return response()->json([
                        'status' => 300,
                        'message' => 'Image size must be 400*600px',
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
 
    public function room_edit(Request $request) {
      $id = $request->id;
      $data = Room::find($id);
      return response()->json([
          'status'=>200,  
          'data'=>$data,
       ]);
    }
 
 
    public function room_update(Request $request ){

     $hall_id = $request->header('hall_id');
     $validator=\Validator::make($request->all(),[    
       'room_name' => 'required|unique:rooms,room_name,'.$request->input('edit_id') . 'NULL,id,hall_id,' . $hall_id,
       'building_id'=>'required',
       'floor_name'=>'required',
       'image1' => 'image|mimes:jpeg,png,jpg|max:500',
       'image2' => 'image|mimes:jpeg,png,jpg|max:500',
       'image3' => 'image|mimes:jpeg,png,jpg|max:500',
     ]);
 
   if($validator->fails()){
          return response()->json([
            'status'=>700,
            'message'=>$validator->messages(),
         ]);
   }else{
          $model=Room::find($request->input('edit_id'));
     if($model){
        $model->room_name=$request->input('room_name');
        $model->building_id=$request->input('building_id');
        $model->floor_name=$request->input('floor_name');
        $model->flat_name=$request->input('flat_name');
        $model->room_details=$request->input('room_details');
        $model->room_status=$request->input('room_status');
        $model->youtube_link=$request->input('youtube_link');

       

         if ($request->hasfile('image1')) {
            $imgfile = 'booking-';
            $size = $request->file('image1')->getsize();
            $file = $_FILES['image1']['tmp_name'];
            $hw = getimagesize($file);
            $w = $hw[0];
            $h = $hw[1];
            if ($w < 610 && $h < 410) {
                $path = public_path('uploads/booking') . '/' . $model->image1;
                if(File::exists($path)){
                  File::delete($path);
                  }
                $image1 = $request->file('image1');
                $new_name = $imgfile . rand() . '.' . $image1->getClientOriginalExtension();
                $image1->move(public_path('uploads/booking'), $new_name);
                $model->image1 = $new_name;
             } else {
                return response()->json([
                    'status' => 300,
                    'message' => 'Image size must be 400*600px',
                ]);
              }
          }


          if ($request->hasfile('image2')) {
             $imgfile = 'booking22-';
             $size = $request->file('image2')->getsize();
             $file = $_FILES['image2']['tmp_name'];
             $hw = getimagesize($file);
             $w = $hw[0];
             $h = $hw[1];
             if ($w < 610 && $h < 410) {
                $path = public_path('uploads/booking') . '/' . $model->image2;
                if(File::exists($path)){
                  File::delete($path);
                  }

                 $image2 = $request->file('image2');
                 $new_name = $imgfile . rand() . '.' . $image2->getClientOriginalExtension();
                 $image2->move(public_path('uploads/booking'), $new_name);
                 $model->image2 = $new_name;
              } else {
                 return response()->json([
                     'status' => 300,
                     'message' => 'Image size must be 400*600px',
                 ]);
               }
           }


           if ($request->hasfile('image3')) {
             $imgfile = 'booking33-';
             $size = $request->file('image3')->getsize();
             $file = $_FILES['image3']['tmp_name'];
             $hw = getimagesize($file);
             $w = $hw[0];
             $h = $hw[1];
             if ($w < 610 && $h < 410) {
                $path = public_path('uploads/booking') . '/' . $model->image3;
                if(File::exists($path)){
                  File::delete($path);
                  }

                 $image3 = $request->file('image3');
                 $new_name = $imgfile . rand() . '.' . $image3->getClientOriginalExtension();
                 $image3->move(public_path('uploads/booking'), $new_name);
                 $model->image3 = $new_name;
              } else {
                 return response()->json([
                     'status' => 300,
                     'message' => 'Image size must be 400*600px',
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
 
 
   public function room_delete(Request $request) { 
 
        //   $hallinfo=Building::where('id',$request->input('id'))->count('id');
        //   if($hallinfo>0){
        //     return response()->json([
        //       'status'=>200,  
        //       'message'=>'Can not delete this record. This hall is used in hall info table.',
        //      ]);
        //   }else{
           $model=Room::find($request->input('id'));
           $filePath1 = public_path('uploads/booking') . '/' . $model->image1;
           $filePath2 = public_path('uploads/booking') . '/' . $model->image2;
           $filePath3 = public_path('uploads/booking') . '/' . $model->image3;

             if(File::exists($filePath1)){
                  File::delete($filePath1);
             }

             if(File::exists($filePath2)){
                 File::delete($filePath2);
             }

             if(File::exists($filePath3)){
                 File::delete($filePath3);
              }

           $model->delete();
           return response()->json([
              'status'=>300,  
              'message'=>'Data Deleted Successfully',
         ]);
         
         //}
    } 
   
 
 
   public function fetch(Request $request){
    
       $hall_id = $request->header('hall_id');
       $data=Room::leftjoin('buildings','buildings.id', '=','rooms.building_id')
       ->where('rooms.hall_id',$hall_id)
       ->select('buildings.building_name','rooms.*')->paginate(10);
       return view('manager.room_data',compact('data'));
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
          $data = Room::leftjoin('buildings','buildings.id', '=','rooms.building_id')
          ->where('rooms.hall_id',$hall_id)
           ->where(function($query) use ($search) {
                 $query->where('room_name', 'like', '%'.$search.'%')
                     ->orWhere('floor_name', 'like', '%'.$search.'%')
                     ->orWhere('buildings.building_name', 'like', '%'.$search.'%')
                     ->orWhere('flat_name', 'like', '%'.$search.'%');
               })->paginate(10);
                   return view('manager.room_data', compact('data'))->render();
                  
       }
   }

}
