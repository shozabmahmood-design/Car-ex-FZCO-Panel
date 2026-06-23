<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BrandsImport;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function index()
    {
        // Getting Brands
        $brands = Brand::all()->toArray();
        // Returning with Brands in Reverse Order
        return $brands;
    }
    public function store(Request $request)
    {
        // Defining Validation Rules 
        $validations = [
            'brandName' => 'required',
        ]; 
        // Checking Validation Rules
        $request->validate($validations);
        // Creating Object for Brand

        if($request->id){
            $brand = Brand::find($request->id);
        }
        else{
            $brand = new Brand();
        }

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imgName = time() ."-". str_replace(" ", "_", $image->getClientOriginalName());
            $image->move(public_path('uploads'), $imgName);
            $brand->image = $imgName;
        }
        // Adding Values to $brand Object
        $brand->brandName = $request->brandName;
        $brand->note = $request->note;
        // Saving data to Database
        $brand->save();
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Brand saved successfully!',
        ]);
    }
    public function show($id)
    {
        // Getting Single Category from database using ID of Category
        $brand = Brand::find($id);
        // Returning with Single Category back to View
        return response()->json($brand);
    }
    public function update(Request $request, $id)
    {
        dd($request->all());
        // Defining Validation Rules 
        $validations = [
            'brandName' => 'required',
            'image' => 'required'
        ];
        // Checking Validation Rules
        $request->validate($validations);
        // Creating Object for Brand
        $brand = Brand::find($id);
        // Adding Values to $brand Object
        $brand->brandName = $request->brandName;
        $brand->note = $request->note;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imgName = time() ."-". str_replace(" ", "_", $image->getClientOriginalName());
            $image->move(public_path('uploads'), $imgName);
            $brand->image = $imgName;
        }
        // Saving data to Database
        $brand->save();
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Brand updated successfully!',
        ]);
    }
    public function destroy($id)
    {
        // Deleting Category using Category Id
        $brand = Brand::with('product')->find($id);

        // Returning with JSON Response back to View
        // dd($brand->product == null);
        if($brand->product == null){
            $image_path = 'uploads/'.$brand->image;
            // if(File::exists($image_path)){
                File::delete($image_path);
            // }
            $brand->delete();
            return response()->json(['status'=>'success',
                'message' => 'Brand deleted successfully!',
            ]);
        }
        else{
            return response()->json(['message'=>'This brand has Products in Listing']);
        }
        
    }
    // Upload Brands Function 
    public function uploadBrands(Request $request){
        // Defining Validation Rules and Checking Validations on Uploaded File
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);
        // Uploading CSV File data to Database using Excel & ContactsImport Class
        Excel::import(new BrandsImport(), $request->file('file')->store('temp'));

        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Brands imported successfully!',
        ]);
    }
    // Multiple Brand Delete Function
    public function deleteMultipleBrands(Request $request){
        foreach($request->all() as $record){
            // Deleting Brand using Brand Id
            $brand = Brand::with('product')->find($record);
            if($brand->product == null){
                $image_path = 'uploads/'.$brand->image;
                // if(File::exists($image_path)){
                    File::delete($image_path);
                // }
                $brand->delete();
            }
            
        }
        // Returning with JSON Response back to View
        return response()->json([
            'message' => 'Brands deleted successfully!',
        ]);
    }
}
