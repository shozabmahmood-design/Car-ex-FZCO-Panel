<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\Setting;
use App\Models\Message;
use App\Models\Brand;
use App\Models\Type;
use App\Models\Product;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\Note;
use Auth;

class DashboardController extends Controller
{
    public function index(){
        $messages = Message::where('product_id', '=', null)->get();
        $t_messages = count($messages);
        $p_messages = Message::where('product_id', '!=', null)->get();
        $tp_messages = count($p_messages);
        $brands = Brand::all();
        $t_brands = count($brands);
        $types = Type::all();
        $t_types = count($types);
        $products = Product::all();
        $t_products = count($products);
        $blog_cat = BlogCategory::all();
        $t_cats = count($blog_cat);
        $blogs = Blog::all();
        $t_blogs = count($blogs);
        $notes = Note::all();
        $t_notes = count($notes);
        $expenses = Expense::all();
        $t_expenses = count($expenses);

        $stats = array(
            'messages' => $t_messages,
            'product_msg' => $tp_messages,
            'brands' => $t_brands,
            'types' => $t_types,
            'products' => $t_products,
            'blog_cats' => $t_cats,
            'blogs' => $t_blogs,
            'notes' => $t_notes,
            'expenses' => $t_expenses,
        );

        return $stats;
    }
}
