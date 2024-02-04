<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\validator;
use Exception;
use App\Models\Building;
use App\Models\Room;

class SeatController extends Controller
{
   
    public function seat_view(Request $request){
        try{ 
              $hall_id = $request->header('hall_id');
              $building=Building::where('hall_id',$hall_id)->orderBy('id','asc')->get(); 
              return view('manager.seat',['building'=>$building]);
           }catch (Exception $e) { return  view('errors.error',['error'=>$e]);}
      }


      public function room_fetch_building(Request $request){
        $hall_id = $request->header('hall_id');
        $room =Room::where('building_id', $request->id)->where('hall_id',$hall_id)->get();
         if(count($room) > 0){
            return response()->json($room);
          }
       }
 
      public function store(Request $request){

       $hall_id = $request->header('hall_id');
       $validator=\Validator::make($request->all(),[        
            'seat_no'=>'required',
            'room_id'=>'required',
            'building_id'=>'required',
            'seat_price'=>'required|numeric',
            'service_charge'=>'required|numeric',
        ]);
 
      if($validator->fails()){
             return response()->json([
               'status'=>700,
               'message'=>$validator->messages(),
            ]);
      }else{

            // $room =Room::where('id', $request->input('room_id'))->where('hall_id',$hall_id)->first();
             $model= new Seat;
             $model->hall_id=$hall_id;
             $model->building_id=$request->input('building_id');
             $model->room_id=$request->input('room_id');
             $model->seat_price=$request->input('seat_price');
             $model->service_charge=$request->input('service_charge');
             $model->seat_name=$request->input('seat_no');
             $model->seat_status=1;
             $model->save();
 
             return response()->json([
                   'status'=>200,  
                   'message'=>'Data Added Successfull',
              ]);     
         }
     }
 

    public function seat_edit(Request $request) {
       $id = $request->id;
       $data = Seat::leftjoin('buildings','buildings.id', '=','seats.building_id')
       ->leftjoin('rooms','rooms.id','=','seats.room_id')
       ->where('seats.id',$id)
       ->select('buildings.building_name','rooms.room_name','rooms.floor_name'
       ,'rooms.flat_name','seats.*')->first();
        return response()->json([
           'status'=>200,  
           'data'=>$data,
        ]);
    }
 
 
    public function seat_update(Request $request ){
       $hall_id = $request->header('hall_id');
       $validator=\Validator::make($request->all(),[    
          'seat_name'=>'required',
          'seat_price'=>'required|numeric',
          'service_charge'=>'required|numeric',
       ]);
 
     if($validator->fails()){
           return response()->json([
             'status'=>700,
             'message'=>$validator->messages(),
          ]);
    }else{
             $model=Seat::find($request->input('edit_id'));
      if($model){
            if(!empty($request->input('edit_room_id')) && !empty($request->input('edit_building_id'))){
                 $model->room_id=$request->input('edit_room_id');
                 $model->building_id=$request->input('edit_building_id');
             }
           $model->seat_name=$request->input('seat_name');
           $model->seat_price=$request->input('seat_price');
           $model->seat_status=$request->input('seat_status');
           $model->price_status=$request->input('price_status');
           $model->service_charge=$request->input('service_charge');
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
 
 
   public function seat_delete(Request $request) { 
 
       // $hallinfo=Building::where('id',$request->input('id'))->count('id');
       //  if($hallinfo>0){
       //     return response()->json([
       //       'status'=>200,  
       //       'message'=>'Can not delete this record. This hall is used in hall info table.',
       //      ]);
       //   }else{
           $model=Seat::find($request->id);
           $model->delete();
           return response()->json([
              'status'=>300,  
              'message'=>'Data Deleted Successfully',
         ]);
     // }
    } 
   

 
   public function fetch(Request $request){
      $hall_id = $request->header('hall_id');
      $data=Seat::leftjoin('buildings','buildings.id', '=','seats.building_id')
       ->leftjoin('rooms','rooms.id', '=','seats.room_id')
       ->where('seats.hall_id',$hall_id)
       ->select('buildings.building_name','rooms.room_name','rooms.floor_name'
       ,'rooms.flat_name','seats.*')->paginate(10);
        return view('manager.seat_data',compact('data'));
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
         $data=Seat::leftjoin('buildings','buildings.id', '=','seats.building_id')
          ->leftjoin('rooms','rooms.id', '=','seats.room_id')
          ->where('seats.hall_id',$hall_id)
           ->where(function($query) use ($search) {
                 $query->where('seat_name', 'like', '%'.$search.'%')
                     ->orWhere('building_name', 'like', '%'.$search.'%')
                     ->orWhere('floor_name', 'like', '%'.$search.'%')
                     ->orWhere('room_name', 'like', '%'.$search.'%')
                     ->orWhere('seat_price', 'like', '%'.$search.'%');
               })->paginate(10);
                   return view('manager.seat_data', compact('data'))->render();
                  
       }
   }



}
