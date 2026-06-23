<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
// use Auth;

class BlogController extends Controller
{
    public function addBlogCategory(Request $request){
        $request->validate([
            'title' => 'required',
        ]);
        if($request->id){
            $cat = BlogCategory::find($request->id);
        }else{
            $cat = new BlogCategory();
        }
        $cat->title = $request->title;
        $cat->save();
        return response()->json(['message' => 'Category saved successfully']);
    }

    public function allCategories(){
        $cats = BlogCategory::all();
        return $cats->toArray(); 
    }

    public function singleCategory($id){
        $cat = BlogCategory::find($id);
        return $cat->toArray();
    }

    public function deleteCategory($id){
        BlogCategory::find($id)->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }

    public function deleteMultiple(Request $request){ 
        foreach($request->all() as $id){
            BlogCategory::find($id)->delete();
        }
        return response()->json(['message' => 'Categories deleted successfully']);
    }

    public function addNewBlog(Request $request){
        // Validations
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'blog_category' => 'required',
        ]);
        $userId = Auth::id();
        if($request->id){
            $blog = Blog::find($request->id);
        }else{
            $blog = new Blog();
            $blog->user_id = $userId;
        }
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imgName = time() ."-". str_replace(" ", "_", $image->getClientOriginalName());
            $image->move(public_path('uploads'), $imgName);
            $blog->image = $imgName;
        }
        $blog->blog_category_id = $request->blog_category;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->tags = $request->tags;
        $blog->save();

        return response()->json(['message' => 'Blog saved successfully']);
    }

    public function allBlogs(){
        $blogs = Blog::with('blog_category')->orderBy('id', 'DESC')->get();

        return $blogs->toArray();
    }

    public function singleBlog($id){
        $blog = Blog::with('blog_category')->where('id', $id)->first();
        return $blog->toArray();
    }

    public function deletBlog($id){
        Blog::find($id)->delete();
        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
