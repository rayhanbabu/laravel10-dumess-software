<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        try {
            return view('manager.product');
        } catch (Exception $e) {
            return  view('errors.error', ['error' => $e]);
        }
    }

    public function fetch(Request $request)
    {
        $hall_id = $request->header('hall_id');
        $data = Product::where('hall_id', $hall_id)->orderBy('id', 'desc')->paginate(10);
        return view('manager.product_data', compact('data'));
    }

    public function store(Request $request)
    {

        $hall_id = $request->header('hall_id');
        $value = Product::where('hall_id', $hall_id)
            ->where('product', $request->input('product'))->get();

        if ($value->count() > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Product Already taken',
            ]);
        } else {
            $product = new Product;
            $product->hall_id = $hall_id;
            $product->code = $request->input('code');
            $product->product = $request->input('product');
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Inserted Data',
            ]);
        }
    }


    public function edit($id)
    {
        $edit_value = Product::where('id', $id)->first();
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
        $id = $request->input('id');
        if ($id) {
            $product = $request->input('product');
            DB::update("update products set product = '$product' where id ='$id'");
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


    public function destroy($id)
    {
         $id = $id;
         DB::delete("delete  from products  where id ='$id'");
         return response()->json([
            'status' => 200,
            'message' => 'Deleted Data',
         ]);
    }



    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search = $request->get('search');
            $search = str_replace(" ", "%", $search);
            $hall_id = $request->header('hall_id');
            $data = Product::where('hall_id', $hall_id)
                ->where(function ($query) use ($search) {
                    $query->where('id', 'like', '%' . $search . '%')
                        ->orWhere('product', 'like', '%' . $search . '%');
                })->orderBy($sort_by, $sort_type)
                ->paginate(10);
            return view('manager.product_data', compact('data'))->render();
        }
    }
}
