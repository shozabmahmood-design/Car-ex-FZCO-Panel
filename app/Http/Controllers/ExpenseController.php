<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        // Fetching all the expenses List
        $expenses = Expense::all();
        foreach ($expenses as $expense) {
            $expense->category;
        }
        return $expenses->toArray();
    }

    public function store(Request $request)
    {
        // Defining Validation Rules
        $validations = [
            'date' => 'required',
            'category' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required',
        ];
        // Applying Validation Rules
        $request->validate($validations);
        // Creating Expense Object
        // Checking Expense ID 
        if($request->id){
            $expense = Expense::find($request->id);
        }else{
            $expense = new Expense();
        }
        $expense->date = $request->date;
        $expense->expenses_categories_id = $request->category;
        $expense->amount = $request->amount;
        $expense->description = $request->description;
        // Saving Object
        $expense->save();
        // Returning Back with Success Response
        return response()->json([
            'message' => 'Expense saved successfully!',
        ]);
    }

    public function destroy($id, Request $request)
    {
        // Deleting Expense on ID
        Expense::find($id)->delete();
        // Returning Back with Success Response
        return response()->json([
            'message' => 'Expense deleted successfully!',
        ]);
    }
}
