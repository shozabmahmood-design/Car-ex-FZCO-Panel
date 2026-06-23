<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensesCategory;

class ExpensesCategoryController extends Controller
{
    // Getting All Expense Categories
    public function index()
    {
        $categories = ExpensesCategory::all()->toArray();
        return $categories;
    }

    public function store(Request $request)
    {
        // Defining Validation Rules
        $validations = [
            'categoryName' => 'required',
        ];
        // Checking Validations
        $request->validate($validations);
        // Creating Object
        // Checking If Id is already there?
        if($request->id){
            $category = ExpensesCategory::find($request->id);
        }else{
            $category = new ExpensesCategory();
        }
        $category->categoryName = $request->categoryName;
        $category->categoryDescription = $request->categoryDescription;
        // Saving Object
        $category->save();
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Category saved successfully!',
        ]);
    }

    public function destroy($id,Request $request)
    {
        // Deleting Expense Category
        ExpensesCategory::find($id)->delete();
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Category deleted successfully!',
        ]);
    }

    public function deleteMultipleCategories(Request $request){
        foreach($request->all() as $record){
            // Deleting Category Using Id as $record
            ExpensesCategory::find($record)->delete();
        }
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Categories deleted successfully!',
        ]);
    }
}
