<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function getProducts($id)
    {
        $product = DB::table('products')->where('category_id', $id)->get();
        return response()->json($product);
    }
}
