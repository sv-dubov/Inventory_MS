<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $check = DB::table('pos')->where('prod_id', $id)->first();
        if ($check) {
            DB::table('pos')->where('prod_id', $id)->increment('prod_quantity');
            $product = DB::table('pos')->where('prod_id', $id)->first();
            $sub_total = $product->prod_quantity * $product->prod_price;
            $updated_at = Carbon::now();
            DB::table('pos')->where('prod_id', $id)->update(['sub_total' => $sub_total, 'updated_at' => $updated_at]);
        } else {
            $data = array();
            $data['prod_id'] = $id;
            $data['prod_name'] = $product->product_name;
            $data['prod_quantity'] = 1;
            $data['prod_price'] = $product->selling_price;
            $data['sub_total'] = $product->selling_price;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();
            DB::table('pos')->insert($data);
        }
    }

    public function cartProducts()
    {
        $cart = DB::table('pos')->get();
        return response()->json($cart);
    }

    public function removeFromCart($id)
    {
        DB::table('pos')->where('id', $id)->delete();
        return response('Removed from cart');
    }

    public function incrementCart($id)
    {
        $quantity = DB::table('pos')->where('id', $id)->increment('prod_quantity');
        $product = DB::table('pos')->where('id', $id)->first();
        $sub_total = $product->prod_quantity * $product->prod_price;
        $updated_at = Carbon::now();
        DB::table('pos')->where('id', $id)->update(['sub_total' => $sub_total, 'updated_at' => $updated_at]);
        return response('Increment done');
    }

    public function decrementCart($id)
    {
        $quantity = DB::table('pos')->where('id', $id)->decrement('prod_quantity');
        $product = DB::table('pos')->where('id', $id)->first();
        $sub_total = $product->prod_quantity * $product->prod_price;
        $updated_at = Carbon::now();
        DB::table('pos')->where('id', $id)->update(['sub_total' => $sub_total, 'updated_at' => $updated_at]);
        return response('Decrement done');
    }

    public function vats()
    {
        $vat = DB::table('extra')->first();
        return response()->json($vat);
    }
}
