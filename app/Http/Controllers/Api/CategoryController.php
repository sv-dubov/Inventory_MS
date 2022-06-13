<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:categories|max:255'
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->save();
    }

    public function show($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $data = array();
        $data['name'] = $request->name;
        $data['updated_at'] = Carbon::now();
        DB::table('categories')->where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();
    }
}
