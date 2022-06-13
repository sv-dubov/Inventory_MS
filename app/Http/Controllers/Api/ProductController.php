<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $product = DB::table('products')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('suppliers', 'products.supplier_id', 'suppliers.id')
            ->select('categories.name as category_name', 'suppliers.name as supplier_name', 'products.*')
            ->orderBy('products.id', 'DESC')
            ->get();
        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required|unique:products|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'buying_date' => 'required',
            'product_quantity' => 'required|numeric'
        ]);

        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($request->image)->resize(380, 300);
            $upload_path = 'backend/photos/product/';
            $image_url = $upload_path . $name;
            $img->save($image_url);

            $product = new Product;
            $product->category_id = $request->category_id;
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->supplier_id = $request->supplier_id;
            $product->buying_date = $request->buying_date;
            $product->product_quantity = $request->product_quantity;
            $product->image = $image_url;
            $product->save();
        } else {
            $product = new Product;
            $product->category_id = $request->category_id;
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->root = $request->root;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->supplier_id = $request->supplier_id;
            $product->buying_date = $request->buying_date;
            $product->product_quantity = $request->product_quantity;
            $product->save();
        }
    }

    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['root'] = $request->root;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['buying_date'] = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;
        $data['updated_at'] = Carbon::now();
        $image = $request->new_image;

        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time() . "." . $ext;
            $img = Image::make($image)->resize(380, 300);
            $upload_path = 'backend/photos/product/';
            $image_url = $upload_path . $name;
            $success = $img->save($image_url);

            if ($success) {
                $data['image'] = $image_url;
                $img = DB::table('products')->where('id', $id)->first();
                $image_path = $img->image;
                if($image_path) {
                    unlink($image_path);
                }
                DB::table('products')->where('id', $id)->update($data);
            }

        } else {
            $old_image = $request->image;
            $data['image'] = $old_image;
            DB::table('products')->where('id', $id)->update($data);
        }
    }

    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $image = $product->image;
        if ($image) {
            unlink($image);
            DB::table('products')->where('id', $id)->delete();
        } else {
            DB::table('products')->where('id', $id)->delete();
        }
    }

    public function updateStock(Request $request, $id)
    {
        $data = array();
        $data['product_quantity'] = $request->product_quantity;
        DB::table('products')->where('id', $id)->update($data);
    }
}
