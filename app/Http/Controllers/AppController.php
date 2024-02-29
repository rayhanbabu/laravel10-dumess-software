<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Exception;

class AppController extends Controller
{
    public function index($category)
    {
        try {
            return view('manager.app',['category' =>$category]);
        } catch (Exception $e) {
            return  view('errors.error', ['error' => $e]);
        }
    }

    public function fetch(Request $request ,$category)
    {
        $hall_id = $request->header('hall_id');
        $data = App::where('hall_id', $hall_id)->where('category', $category)->orderBy('id', 'desc')->paginate(10);
        return view('manager.app_data', compact('data'));
    }

    public function store(Request $request)
      {
        $hall_id = $request->header('hall_id');
        $validator = \Validator::make(
            $request->all(),
            [ 
                'phone' => 'required|unique:apps,phone,NULL,id,hall_id,'.$hall_id,
            ],
            [
                'phone.required' => ' Phone number is required',
            ]
        );

      if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
       } else {
            $app = new App;
            $app->hall_id = $hall_id;
            $app->serial = $request->input('serial');
            $app->phone = $request->input('phone');
            $app->category = $request->input('category');
            $app->save();
               return response()->json([
                   'status' => 200,
                   'message' => 'Inserted Data',
                ]);
        }
    }


    public function edit($id)
    {
        $edit_value = App::where('id', $id)->first();
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


    public function update(Request $request, $id)
    {
        $hall_id = $request->header('hall_id');
        $validator = \Validator::make($request->all(), [
            'phone' => 'required|unique:apps,phone,' . $id,
            'phone' => 'required|unique:apps,phone,'.$id . 'NULL,id,hall_id,' . $hall_id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        } else {
            $id = $request->input('id');
            if ($id) {
                $phone = $request->input('phone');
                DB::update("update apps set phone = '$phone' where id ='$id'");
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
            $data = App::where('hall_id', $hall_id)->where('category', $category)
                ->where(function ($query) use ($search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                })->orderBy($sort_by, $sort_type)
                ->paginate(10);
            return view('manager.app_data', compact('data'))->render();
        }
    }
}
