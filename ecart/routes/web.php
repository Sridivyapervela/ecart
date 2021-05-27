<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    if(auth()->user()){
        return view('home');
    }
    else{return view('login');}
});

Route::resource("user",UserController::class);
Route::resource("category",CategoryController::class);
Route::resource("product",ProductController::class);


Auth::routes();
Route::get('/users', [App\Http\Controllers\UserController::class,'index'])->name('user_profile');
Route::get('/users/edit/{user_id}', [App\Http\Controllers\UserController::class,'edit']);
Route::get('/users/create', [App\Http\Controllers\UserController::class,'create']);
Route::get('/users/delete/{user_id}', [App\Http\Controllers\UserController::class,'destroy']);
Route::get('/users/show/{user_id}', [App\Http\Controllers\UserController::class,'show']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categories', [App\Http\Controllers\CategoryController::class,'index'])->name('all_categories');
Route::get('/categories/edit/{category_id}', [App\Http\Controllers\Controllerntroller::class,'edit']);
Route::get('/categories/create', [App\Http\Controllers\CategoryController::class,'create']);
Route::get('/categories/delete/{category_id}', [App\Http\Controllers\CategoryController::class,'destroy']);
Route::get('/categories/show/{category_id}', [App\Http\Controllers\CategoryController::class,'show']);

Route::get('/products', [App\Http\Controllers\ProductController::class,'index'])->name('all_products');
Route::get('/products/edit/{product_id}', [App\Http\Controllers\ProductController::class,'edit']);
Route::get('/products/create', [App\Http\Controllers\ProductController::class,'create']);
Route::get('/products/delete/{product_id}', [App\Http\Controllers\ProductController::class,'destroy']);
Route::get('/products/show/{product_id}', [App\Http\Controllers\ProductController::class,'show']);