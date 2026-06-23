<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TypesImport;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class TypeController extends Controller
{
    public function index()
    {
        // Getting Types
        $types = Type::all()->toArray();
        // Returning with types in Reverse Order
        return $types;
    }
    public function store(Request $request)
    {
        // Defining Validation Rules 
        $validations = [
            'vehicleType' => 'required',
        ];
        // Checking Validation Rules
        $request->validate($validations);
        // Creating Object for Type

        if($request->id){
            $type = Type::find($request->id);
        }
        else{
            $type = new Type();
        }
        // Adding Values to $type Object
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imgName = time() ."-". str_replace(" ", "_", $image->getClientOriginalName());
            $image->move(public_path('uploads'), $imgName);
            $type->image = $imgName;
        }
        $type->vehicleType = $request->vehicleType;
        $type->note = $request->note;
        // Saving data to Database
        $type->save();
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Type saved successfully!',
        ]);
    }
    public function show($id)
    {
        // Getting Single Category from database using ID of Category
        $type = Type::find($id);
        // Returning with Single Category back to View
        return response()->json($type);
    }
    public function update(Request $request, $id)  
    {
        // Defining Validation Rules 
        $validations = [
            'vehicleType' => 'required',
        ];
        // Checking Validation Rules
        $request->validate($validations);
        // Creating Object for Type
        $type = Type::find($id);
        // Adding Values to $type Object
        $type->vehicleType = $request->vehicleType;
        $type->note = $request->note;
        // Saving data to Database
        $type->save();
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Type updated successfully!',
        ]);
    }
    public function destroy($id)
    {
        // Deleting Category using Category Id
        $type = Type::with('Product')->find($id);
        if($type->product == null){
            $image_path = 'uploads/'.$type->image;
            if(File::exists($image_path)){
                File::delete($image_path);
            }
            $type->delete();
            return response()->json(['status'=>'success',
                'message' => 'Type deleted successfully!',
            ]);
        }
        else{
            return response()->json(['message'=>'This Type has Products in Listing']);
        }
        
        // Returning with JSON Response back to View
        
    }
    // Upload Types Function 
    public function uploadTypes(Request $request){
        // Defining Validation Rules and Checking Validations on Uploaded File
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);
        // Uploading CSV File data to Database using Excel & ContactsImport Class
        Excel::import(new TypesImport(), $request->file('file')->store('temp'));

        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Types imported successfully!',
        ]);
    }
    // Multiple Type Delete Function
    public function deleteMultipleTypes(Request $request){
        foreach($request->all() as $record){
            // Deleting Type using Type Id
            $type = Type::with('product')->find($record);
            if($type->product == null){
                $image_path = 'uploads/'.$type->image;
                if(File::exists($image_path)){
                    File::delete($image_path);
                }
                $type->delete();
            }
        }
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Types deleted successfully!',
        ]);
    }
}
