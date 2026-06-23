<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpensesCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\WhatsappController;

Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    // Route::post('logout', [AuthController::class, 'logout']);
});
Route::middleware('api')->group(function () {
    // Routes for Dashboard
    Route::get('/get-stats', [DashboardController::class, 'index']);

    // Routes for Expenses Categories
    Route::resource('expenses_categories', ExpensesCategoryController::class);
    Route::post('/expenses_categories/delete', [ExpensesCategoryController::class, 'deleteMultipleCategories']);
    // Routes for Expenses
    Route::resource('expenses', ExpenseController::class);
    // Routes for Settings
    Route::get('settings/{userId}', [SettingController::class, 'index']);
    Route::post('save_settings', [SettingController::class, 'store']);

    // Notes Routes
    Route::get('/notes', [NoteController::class, 'allNotes']);
    Route::get('/notes/{id}', [NoteController::class, 'deleteNote']);
    Route::post('/notes/save', [NoteController::class, 'saveNote']);
    Route::post('/notes/delete', [NoteController::class, 'deleteMultiple']);

    
    // Routes for Products Brands
    Route::resource('brands', BrandController::class);
    Route::post('/brands/upload/', [BrandController::class, 'uploadBrands']);
    Route::post('/brands/delete', [BrandController::class, 'deleteMultipleBrands']);

        
    // Routes for Products Types
    Route::resource('types', TypeController::class);
    Route::post('/types/upload/', [TypeController::class, 'uploadTypes']);
    Route::post('/types/delete', [TypeController::class, 'deleteMultipleTypes']);

    //Routes for Products
    Route::post('/add-product', [ProductController::class, 'addNewProduct']);
    Route::get('/products', [ProductController::class, 'allProducts']);
    Route::get('/single-product/{id}', [ProductController::class, 'singleProduct']);
    Route::get('/product/delete/{id}', [ProductController::class, 'deletProduct']);
    Route::get('/change-status/{id}/{status}', [ProductController::class,'makeFeatured']);
    Route::get('/remove-Image/{id}',[ProductController::class, 'removeImage']); 

    // Blog Routes
    Route::post('/add-blog-category', [BlogController::class, 'addBlogCategory']);
    Route::get('/blog-categories', [BlogController::class, 'allCategories']);
    Route::get('/blog-category/{id}', [BlogController::class, 'singleCategory']);
    Route::get('/blog-category/delete/{id}', [BlogController::class, 'deleteCategory']);
    Route::post('/blog-categories/delete', [BlogController::class, 'deleteMultiple']);
    Route::post('/add-blog', [BlogController::class, 'addNewBlog']);
    Route::get('/blogs', [BlogController::class, 'allBlogs']);
    Route::get('/single-blog/{id}', [BlogController::class, 'singleBlog']);
    Route::get('/blog/delete/{id}', [BlogController::class, 'deletBlog']);

    //Messages
    Route::get('/messages', [MessageController::class, 'allMessages']);
    Route::get('/product/messages', [MessageController::class, 'Messages']);
    Route::get('/single-message/{id}', [MessageController::class, 'singleMessage']);
    Route::get('/message/delete/{id}', [MessageController::class, 'deletMessage']);

    //Whatsapp messages
    Route::get('whatsapp', [WhatsappController::class, 'index']);
    Route::get('/whatsapp/delete/{id}', [WhatsappController::class, 'deletMessage']);

});
