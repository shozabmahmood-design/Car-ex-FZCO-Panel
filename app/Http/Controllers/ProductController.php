<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Image;


class ProductController extends Controller
{
    
    public function addNewProduct(Request $request){
        // Validations
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'brand' => 'required',
            'type' => 'required',
            

            
        ]);
        // $userId = Auth::id();
        if($request->id){
             $product = Product::find($request->id);
            //  ProductImage::where('product_id', $request->id)->delete();
        }else{
            $product = new Product();
            // $product->user_id = $userId;
        }
        
     
        if($request->hasFile('image')){
            $image0 = $request->file('image');
            $image1 = Image::make($image0);
            $image = $image1->insert(public_path('assets/logo.png'), 'bottom-right', 15, 15);
            $imgName = time() ."-". str_replace(" ", "_", $image0->getClientOriginalName());
            $image->save(public_path('uploads').'/'.$imgName);
            // dd($image);
            $product->image = $imgName;
        }
        if($request->hasFile('image2')){
            $image0 = $request->file('image2');
            $image1 = Image::make($image0);
            $image = $image1->insert(public_path('assets/logo.png'), 'bottom-right', 15, 15);
            $imgName = time() ."-". str_replace(" ", "_", $image0->getClientOriginalName());
            $image->save(public_path('uploads').'/'.$imgName);
            $product->image2 = $imgName;
        }
        if($request->hasFile('image3')){
            $image0 = $request->file('image3');
            $image1 = Image::make($image0);
            $image = $image1->insert(public_path('assets/logo.png'), 'bottom-right', 15, 15);
            $imgName = time() ."-". str_replace(" ", "_", $image0->getClientOriginalName());
            $image->save(public_path('uploads').'/'.$imgName);
            $product->image3 = $imgName;
        }
        if($request->hasFile('image4')){
            $image0 = $request->file('image4');
            $image1 = Image::make($image0);
            $image = $image1->insert(public_path('assets/logo.png'), 'top-right', 15, 15);
            $imgName = time() ."-". str_replace(" ", "_", $image0->getClientOriginalName());
            $image->save(public_path('uploads').'/'.$imgName);
            $product->image4 = $imgName;
        }

        if($request->hasFile('video')){
            $video =$request->file('video');
            $fileName = time() ."-". str_replace(" ", "_", $video->getClientOriginalName());
            $video->move(public_path('uploads'), $fileName);
            $product->video = $fileName;
        }

        if($request->hasFile('pdf_file')){
            $pdf_file =$request->file('pdf_file');
            $fileName = time() ."-". str_replace(" ", "_", $pdf_file->getClientOriginalName());
            $pdf_file->move(public_path('uploads'), $fileName);
            $product->pdf_file = $fileName;
        }
        
        $product->brand_id = $request->brand;
        $product->type_id = $request->type;
        $product->title = $request->title;
        $product->description = $request->description;
        $product->model = $request->model;
        $product->man_year = $request->man_year;
        $product->color = $request->color;
        $product->drive_type = $request->drive_type;
        $product->transmission = $request->transmission;
        $product->fuel_type = $request->fuel_type;
        $product->engine_size = $request->engine_size;
        $product->doors = $request->doors;
        $product->cylenders = $request->cylenders;
        $product->steering = $request->steering;
        $product->price = $request->price;
        $product->save();
        if ($request->attachments != null){
            // dd($request->attachments);
            foreach ($request->attachments as $file) {
                $image0 = $file;
                $image1 = Image::make($image0);
                $image = $image1->insert(public_path('assets/logo.png'), 'bottom-right', 5, 5);
                $imgName = time() . rand(100000, 9999999) . "-" . str_replace(" ", "_", $image0->getClientOriginalName());
                $image->save(public_path('uploads').'/'.$imgName);
                // Saving Image to Database
                $product_img = new ProductImage();
                $product_img->image_name = $imgName;
                $product_img->product_id = $product->id;
                $product_img->save();
            }
        }

        return response()->json(['message' => 'Product saved successfully']);
    }

    public function allProducts(){
        $products = Product::with('brand','type')->orderBy('id', 'DESC')->get();

        return $products->toArray();
    }

    public function singleProduct($id){
        $product = Product::with('brand','type')->where('id', $id)->first();
        $product_img = ProductImage::where('product_id', $id)->get();
        $product = $product->toArray();
        $product_img = $product_img->toArray();
        return response()->json(['product' => $product, 'product_img' => $product_img]);
    }

    public function deletProduct($id){
        $product = Product::with('product_images')->find($id);
        $image_path = 'uploads/'.$product->image;
        $image_path2 = 'uploads/'.$product->image2;
        $image_path3 = 'uploads/'.$product->image3;
        $image_path4 = 'uploads/'.$product->image4;
        $video_path = 'uploads/'.$product->video;
        File::delete($image_path);
        File::delete($image_path2);
        File::delete($image_path3);
        File::delete($image_path4);
        File::delete($video_path);

        if($product->product_images != null){
            foreach($product->product_images as $image){
                $image_path = 'uploads/'.$image->image_name;
                File::delete($image_path);
            }
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function makeFeatured($id, $status)
    {
        $product = Product::find($id);
        $product->isfeatured = $status;
        $product->save();
        // $product->update(['isfeatured' => $status]);
        return response()->json(['message' => 'Status updated successfully']);
    }

    public function removeImage($id){
        $image = ProductImage::find($id);
        $image_path = 'uploads/'.$image->image_name;
        File::delete($image_path);
        $image->delete();
        return response()->json(['message'=>'Image Removed Successfully']);
    }
}
