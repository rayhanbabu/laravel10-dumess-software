<?php

namespace App\Http\Controllers;

use App\Models\Managerlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;

class ManagerlistController extends Controller
{
    
    public function index(Request $request)
    {
        $hall_id = $request->header('hall_id');
        if ($request->ajax()) {
            $data = Managerlist::where('hall_id',$hall_id)->latest()->get();
             return Datatables::of($data)
                 ->addIndexColumn()
                 ->addColumn('status', function($row){
                     return $row->invoice_year.'-'.$row->invoice_month.'-'.$row->invoice_section;
                 })
                ->addColumn('edit', function($row){
                 $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm"> Edit </a>';
                 return $btn;
                })
                ->addColumn('delete', function($row){
                  $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm"> Delete</a>';
                  return $btn;
                })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }           
           return view('manager.managerlist');  

      }
 
 

    public function store(Request $request)
      {
        $hall_id = $request->header('hall_id');
        $validator = \Validator::make(
            $request->all(),
            [ 
                'phone' => 'required',
                'name' => 'required',
                'invoice_year' => 'required',
                'invoice_month' => 'required',
                'invoice_section' => 'required',
            ],
           
        );

      if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
       } else {
            $app = new Managerlist;
            $app->hall_id = $hall_id;
            $app->name = $request->input('name');
            $app->role = $request->input('role');
            $app->phone = $request->input('phone');
            $app->invoice_year = $request->input('invoice_year');
            $app->invoice_month = $request->input('invoice_month');
            $app->invoice_section = $request->input('invoice_section');
            $app->department = $request->input('department');
            $app->registration = $request->input('registration');
            $app->save();
               return response()->json([
                   'status' => 200,
                   'message' => 'Inserted Data',
                ]);
        }
    }


    public function edit(Request $request , $id)
    {
        $edit_value = Managerlist::where('id', $id)->first();
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
                 'phone' => 'required',
                 'name' => 'required',
                 'invoice_year' => 'required',
                 'invoice_month' => 'required',
                 'invoice_section' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        } else {
            $id = $request->input('id');
            if ($id) {
            $app =Managerlist::find($id);
            $app->name = $request->input('name');
            $app->role = $request->input('role');
            $app->phone = $request->input('phone');
            $app->invoice_year = $request->input('invoice_year');
            $app->invoice_month = $request->input('invoice_month');
            $app->invoice_section = $request->input('invoice_section');
            $app->department = $request->input('department');
            $app->registration = $request->input('registration');
            $app->save();
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
        DB::delete("delete  from managerlists  where id ='$id'");
        return response()->json([
            'status' => 200,
            'message' => 'Deleted Data',
        ]);
    }

}
