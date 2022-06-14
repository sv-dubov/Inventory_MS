<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use DB;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function getProducts($id)
    {
        $product = DB::table('products')->where('category_id', $id)->get();
        return response()->json($product);
    }

    public function orderDone(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required',
            'pay_by' => 'required'
        ]);

        $data = array();
        $data['customer_id'] = $request->customer_id;
        $data['qty'] = $request->qty;
        $data['sub_total'] = $request->subtotal;
        $data['vat'] = $request->vat;
        $data['total'] = $request->total;
        $data['pay'] = $request->pay;
        $data['due'] = $request->due;
        $data['pay_by'] = $request->pay_by;
        $data['order_date'] = date('d/m/Y');
        $data['order_month'] = date('F');
        $data['order_year'] = date('Y');
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        $order_id = DB::table('orders')->insertGetId($data);

        $contents = DB::table('pos')->get();
        $order_data = array();
        foreach ($contents as $content) {
            $order_data['order_id'] = $order_id;
            $order_data['product_id'] = $content->prod_id;
            $order_data['product_quantity'] = $content->prod_quantity;
            $order_data['product_price'] = $content->prod_price;
            $order_data['sub_total'] = $content->sub_total;
            $order_data['created_at'] = Carbon::now();
            $order_data['updated_at'] = Carbon::now();
            DB::table('order_details')->insert($order_data);

            DB::table('products')
                ->where('id', $content->prod_id)
                ->update(['product_quantity' => DB::raw('product_quantity -' . $content->prod_quantity)]);
        }
        DB::table('pos')->delete();
        return response('Order done');
    }

    public function searchOrder(Request $request)
    {
        $order_date = $request->date;
        $new_date = new DateTime($order_date);
        $done = $new_date->format('d/m/Y');
        $order = DB::table('orders')
            ->join('customers', 'orders.customer_id', 'customers.id')
            ->select('customers.name', 'orders.*')
            ->where('orders.order_date', $done)
            ->get();
        return response()->json($order);
    }
}
