<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::all();
        return response()->json($expense);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'details' => 'required',
            'amount' => 'required',
        ]);

        $expense = new Expense;
        $expense->details = $request->details;
        $expense->amount = $request->amount;
        $expense->expense_date = date('y/m/d');
        $expense->save();
    }

    public function show($id)
    {
        $expense = DB::table('expenses')->where('id', $id)->first();
        return response()->json($expense);
    }

    public function update(Request $request, $id)
    {
        $data = array();
        $data['details'] = $request->details;
        $data['amount'] = $request->amount;
        $data['updated_at'] = Carbon::now();
        DB::table('expenses')->where('id', $id)->update($data);
    }

    public function destroy($id)
    {
        DB::table('expenses')->where('id', $id)->delete();
    }
}
