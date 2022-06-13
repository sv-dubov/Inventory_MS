<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        if ($request->photo) {
            $position = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($request->photo)->resize(240, 200);
            $upload_path = 'backend/photos/supplier/';
            $image_url = $upload_path . $name;
            $img->save($image_url);

            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shop_name = $request->shop_name;
            $supplier->photo = $image_url;
            $supplier->save();
        } else {
            $supplier = new Supplier;
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shop_name = $request->shop_name;
            $supplier->save();
        }
    }

    public function show($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['shop_name'] = $request->shop_name;
        $data['updated_at'] = Carbon::now();
        $image = $request->new_photo;

        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_path = 'backend/photos/supplier/';
            $image_url = $upload_path . $name;
            $success = $img->save($image_url);

            if ($success) {
                $data['photo'] = $image_url;
                $img = DB::table('suppliers')->where('id', $id)->first();
                $image_path = $img->photo;
                if($image_path) {
                    unlink($image_path);
                }
                $supplier = DB::table('suppliers')->where('id', $id)->update($data);
            }
        } else {
            $old_photo = $request->photo;
            $data['photo'] = $old_photo;
            $supplier = DB::table('suppliers')->where('id', $id)->update($data);
        }
    }

    public function destroy($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        $photo = $supplier->photo;
        if ($photo) {
            unlink($photo);
            DB::table('suppliers')->where('id', $id)->delete();
        } else {
            DB::table('suppliers')->where('id', $id)->delete();
        }
    }
}
