<?php

namespace App\Http\Controllers;

use App\Models\Booking_member;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\Hall;
use Exception;
use App\Helpers\BookingJWTToken;
use DB;

class BookingMemberController extends Controller
{
    
    public function hall_view($hall_id)
  {
    try {
      $data = Hall::where('role', 'admin')->where('hall_id',$hall_id)->select(
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
      )->first();

      
        return response()->json([
           'status' => 'success',
           'data' => $data,
         ],200);
    } catch (Exception $e) {
      return response()->json([
        'status' => 501,
        'message' => 'Somting Error',
      ],501);
    }
  }


    public function building_view($hall_id)
    {
      try {     
           $data = Building::where('hall_id', $hall_id)->orderBy('id', 'asc')->get();
            return response()->json([
               'status' => 'success',
               'data' => $data,
            ],200);
       } catch (Exception $e) {
           return response()->json([
              'status' => 501,
              'message' => 'Somting Error',
           ],501);
      }
    }


    public function room_view($hall_id,$building_id)
    {
      try {     
           //$data = Room::where('hall_id', $hall_id)->orderBy('id', 'asc')->get();
           $data=Seat::where('seats.hall_id',$hall_id)->where('seats.building_id',$building_id)
               ->leftjoin('buildings','buildings.id','=','seats.building_id')
               ->leftjoin('rooms','rooms.id','=','seats.room_id')
               ->select('room_id',DB::raw('count(seats.id) as total'),DB::raw('sum(seat_status) as seat_status')
               ,DB::raw('max(building_name) as building_name'),DB::raw('max(room_name) as room_name')
               ,DB::raw('max(floor_name) as floor_name'),DB::raw('max(flat_name) as flat_name'))
               ->orderBy('seats.id','asc')->groupBy('room_id')->get();
            return response()->json([
               'status' => 'success',
               'data' => $data,
            ],200);
       } catch (Exception $e) {
           return response()->json([
              'status' => 'fail',
              'message' => 'Somting Error',
           ],501);
      }
    }


    public function room_details($hall_id,$room_id)
    {
      try {     
           $data = Room::where('hall_id',$hall_id)->where('id',$room_id)->get();
              return response()->json([
                   'status' => 'success',
                   'data' => $data,
                ],200);
         } catch (Exception $e) {
              return response()->json([
                  'status' => 501,
                  'message' => 'Somting Error',
              ],501);
          }
    }


    public function seat_details($hall_id,$room_id)
    {
      try {     
           $data = Seat::where('hall_id',$hall_id)->where('room_id',$room_id)->orderBy('id','asc')->get();
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ],200);
       } catch (Exception $e) {
           return response()->json([
              'status' => 501,
              'message' => 'Somting Error',
           ],501);
      }
    }



    public function booking_member_login(Request $request, $hall_id,$phone)
    {
      try {                 
         $otp=rand (1000,9999);
         Booking_member::updateOrCreate(['phone' => $phone,'hall_id'=>$hall_id], ['phone'=>$phone,'otp'=>$otp]);
              return response()->json([
                 'status' => 'success',
                 'message' => "4 digit OTP Send ".$otp,
              ],200);
       } catch (Exception $e) {
            return response()->json([
              'status' => 'fail',
              'message' => 'Somting Error',
            ],501);
       }
    }


    public function Booking_VerifyLogin(Request $request ,$hall_id,$phone,$otp)
    {
            $booking= Booking_member::where('hall_id',$hall_id)->where('phone',$phone)->where('otp',$otp)->first();
            if($booking){
                 Booking_member::updateOrCreate(['phone' => $phone,'hall_id'=>$hall_id], ['phone'=>$phone,'otp'=>'0']);
                  $booking_token = BookingJWTToken::CreateToken($booking->id, $booking->hall_id, $booking->phone);
                   return response()->json([
                       'status' => "success",
                       'booking_token' => $booking_token,
                   ],200);
             }else{
                  return response()->json([
                    'status' =>'fail',
                    'data' => "Invalid OTP Code ",
                  ],421);
            }
    }


    public function booking_seat(request $request,$hall_id){
      
          $booking_member_id=$request->header('booking_member_id');
          $validator=\Validator::make($request->all(),[    
               'seat_id'  => 'required',
                   ]
           );

      if($validator->fails()){
            return response()->json([
               'status'=>427,
               'message'=>$validator->messages(),
             ]);
        }else{
           $data = Seat::where('hall_id',$hall_id)->where('id',$request->seat_id)->orderBy('id', 'asc')->first();
           $total_amount=$data->seat_price+$data->service_charge;
           $model= new Booking;
           $model->hall_id=$data->hall_id;
           $model->booking_member_id=$booking_member_id;
           $model->seat_id=$data->id;
           $model->seat_amount=$data->seat_price;
           $model->service_amount=$data->service_charge;
           $model->total_amount=$total_amount;
           $model->due_amount=$total_amount;
           $model->save();

           return response()->json([
              'status' => "success",
              'messsage' => "Booking Successfully Completed",
           ],200);

         }
     }



     public function booking_view(request $request , $hall_id)
     {
       try {     
            $booking_member_id=$request->header('booking_member_id');
            $data = Booking::where('bookings.hall_id',$hall_id)->where('booking_member_id',$booking_member_id)
            ->leftjoin('seats','seats.id', '=','bookings.seat_id')
            ->leftjoin('rooms','rooms.id', '=','seats.room_id')
            ->leftjoin('buildings','buildings.id', '=','rooms.building_id')
            ->select('seat_name','room_name','building_name','floor_name','flat_name','bookings.*')
            ->orderBy('bookings.id','asc')->get();
             return response()->json([
                'status' => 'success',
                'data' => $data,
             ],200);
        } catch (Exception $e) {
            return response()->json([
               'status' => 'fail',
               'message' => 'Somting Error',
            ],501);
       }
     }



     public function booking_profile_view(request $request ,$hall_id)
     {
       try {   
            $booking_member_id=$request->header('booking_member_id');  
            $data = Booking_member::where('hall_id',$hall_id)->where('id',$booking_member_id)->orderBy('id', 'asc')->first();
             return response()->json([
                'status' => 'success',
                'data' => $data,
             ],200);
        } catch (Exception $e) {
            return response()->json([
               'status' => 501,
               'message' => 'Somting Error',
            ],501);
       }
     }

     public function booking_cencel(request $request ,$hall_id,$booking_id)
     {
        try{   
             $booking_member_id=$request->header('booking_member_id');  
             $data=Booking::where('id',$booking_id)->where('booking_member_id',$booking_member_id)->where('hall_id',$hall_id)->first();
            
            
             if($data->booking_status==1){
               return response()->json([
                   'status'=>410,
                   'message'=>"Seat Already  Booked",
                ],410);
             }else{
               Booking::where('id',$booking_id)->where('hall_id',$hall_id)->where('booking_member_id',$booking_member_id)->delete();
               return response()->json([
                  'status'=>200,
                  'message'=>"Booking Seat Delete Successfull",
                ],200);
            }
           
        } catch (Exception $e) {
            return response()->json([
               'status' => 501,
               'message' => 'Somting Error',
            ],501);
       }
     }
 
 



}
