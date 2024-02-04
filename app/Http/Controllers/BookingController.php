<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Seat;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\validator;

class BookingController extends Controller
{


    public function index($category)
    {
        try {
            return view('manager.booking',['category' =>$category]);
        } catch (Exception $e) {
            return  view('errors.error', ['error' => $e]);
        }
    }

    public function fetch(Request $request ,$category)
    {
        $hall_id = $request->header('hall_id');
        $data = Booking::where('bookings.hall_id',$hall_id)->where('booking_status',$category)
        ->leftjoin('seats','seats.id', '=','bookings.seat_id')
        ->leftjoin('rooms','rooms.id', '=','seats.room_id')
        ->leftjoin('buildings','buildings.id', '=','rooms.building_id')
        ->leftjoin('booking_members','booking_members.id', '=','bookings.booking_member_id')
        ->select('phone','seat_name','room_name','building_name','floor_name','flat_name','bookings.*')
        ->orderBy('bookings.id','asc')->paginate(10);
       
        return view('manager.booking_data', compact('data'));
    }




    public function edit($id)
    {
        $edit_value = Booking::where('id', $id)->first();
         if ($edit_value) {
             return response()->json([
                'status' => 200,
                'edit_value' => $edit_value,
             ]);
          } else {
             return response()->json([
                'status' => 404,
                'message' => 'Student not found',
             ]);
          }
    }


    public function update(Request $request,$id)
    {
        $hall_id = $request->header('hall_id');
        $validator = \Validator::make($request->all(), [
            'booking_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        } else {
            if ($id) {
                $booking_status = $request->input('booking_status');
                $seat_id = $request->input('seat_id');
                DB::update("update bookings set booking_status = '$booking_status' where id ='$id'");
            if($booking_status==0 || $booking_status==5){
               DB::update("update seats set seat_booking_status = '0' where id ='$seat_id'");
           }else{
               DB::update("update seats set seat_booking_status = '$booking_status' where id ='$seat_id'");
             }
               
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Updated'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                ]);
            }
        }
    }


    public function payment_update(Request $request,$id)
    {
        $hall_id = $request->header('hall_id');
        $manager_username = $request->header('manager_username');
        $validator = \Validator::make($request->all(), [
            'amount1' => 'required',
            'amount2' => 'required',
            'amount3' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        } else {
               $amount1 = $request->input('amount1');
               $amount2 = $request->input('amount2');
               $amount3 = $request->input('amount3');
                 $model = Booking::find($id);
            if($model){
                  if($model->amount1 != $amount1){
                      $model->time1 = date('Y-m-d H:i:s');
                      $model->date1 = date('Y-m-d');
                      $model->type1 = $manager_username;

                  }

                  if($model->amount2 != $amount2){
                      $model->time2 = date('Y-m-d H:i:s');
                      $model->date2 = date('Y-m-d');
                      $model->type2 = $manager_username;

                  }

                  if($model->amount3 != $amount3){
                     $model->time3 = date('Y-m-d H:i:s'); 
                     $model->date3 = date('Y-m-d');
                     $model->type3= $manager_username;

                  }

                $model->amount1 = $amount1;
                $model->amount2 = $amount2;
                $model->amount3 = $amount3;
                $model->due_amount = $model->total_amount-$amount1-$amount2-$amount3;
                
                $model->update();   
              
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Updated'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                ]);
            }
        }
    }



    public function destroy($id)
    {
        $id = $id;
        DB::delete("delete  from apps  where id ='$id'");
        return response()->json([
            'status' => 200,
            'message' => 'Deleted Data',
        ]);
    }



    function fetch_data(Request $request,$category)
    {
        $hall_id = $request->header('hall_id');
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $data =Booking::where('bookings.hall_id',$hall_id)->where('booking_status',$category)
             ->leftjoin('seats','seats.id', '=','bookings.seat_id')
             ->leftjoin('rooms','rooms.id', '=','seats.room_id')
             ->leftjoin('buildings','buildings.id', '=','rooms.building_id')
             ->leftjoin('booking_members','booking_members.id', '=','bookings.booking_member_id')
             ->where(function ($query) use ($search) {
                    $query->where('seat_name', 'like', '%' . $search . '%')
                        ->orWhere('building_name', 'like', '%' . $search . '%')
                        ->orWhere('floor_name', 'like', '%' . $search . '%')
                        ->orWhere('flat_name', 'like', '%' . $search . '%')
                        ->orWhere('room_name', 'like', '%' . $search . '%');
                })->orderBy($sort_by, $sort_type)
                ->select('phone','seat_name','room_name','building_name','floor_name','flat_name','bookings.*')->paginate(10);
            return view('manager.app_data', compact('data'))->render();
        }
    }


}
