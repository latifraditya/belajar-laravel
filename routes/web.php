<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\DashboardController;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupermarketController;


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

/*
|--------------------------------------------------------------------------
| Navbar header
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('home',[
        "title" => "Home",
    ]);
});

Route::get('/about', function () {
    return view('about',[
        "title" => "About",
        "name" => "Latif Raditya",
        "email" => "latifradityarusdi@gmail.com",
        "image" => "latif.jpg"
    ]);
});

Route::get('/posts', [PostController::class, 'index']);

// Halaman Single Post
Route::get('/posts/{post:slug}', [PostController::class, 'show']);

// Halaman Categories
Route::get('/categories', function(){
    return view('categories', [
        'title' => 'Post Categories',
        'categories' => Category::all()
    ]);
});

// Tidak dipakai karena sudah pakai Route Model Binding

// Route::get('/categories/{category:slug}', function(Category $category){
//     return view('posts', [
//         'title' => "Post By Category : $category->name",
//         'active' => 'categories',
//         'posts' => $category->posts->load('category','author')
//     ]);
// });


// Tidak dipakai karena sudah pakai Route Model Binding

// Route::get('/authors/{author:username}', function(User $author) {
//   return view('posts',[
//     'title' => "Post By Author : $author->name",
//     'active' => 'posts',
//     'posts' => $author->posts->load('category','author'),
//   ]);
// });


// ******
// Login
// ******

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// ******
// Register
// ******

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);


// *************
// Dashboard
// *************
Route::get('/dashboard', function(){
  return view('dashboard.index',[
    "title" => "Dashboard",
  ]);
})->middleware('auth');

Route::post('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');


// Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');

Route::resource('/dashboard/posts', DashboardPostController::class)
    ->except(['destroy'])->middleware('auth');

// ADMINISTRATOR
Route::middleware('admin')->group(function () {
  
    Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('admin');
    Route::delete('/dashboard/posts/{post}', [DashboardPostController::class, 'destroy'])->name('dashboard.posts.destroy');
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/dashboard/users/{user}', [UserController::class, 'show']);
    Route::post('/dashboard/categories/update', [AdminCategoryController::class, 'update']);
    // Route::get('/dashboard', [DashboardController::class, 'index']);
});


Route::resource('/dashboard/sales', SaleController::class);

// **********************
// Supermarket
// **********************

// Route::resource('/dashboard/supermarkets', SupermarketController::class);
// Route::get('/dashboard/supermarkets/chart', [SupermarketController::class, 'chart'])->name('supermarkets.chart');
Route::prefix('/dashboard/supermarkets')->group(function () {
  Route::get('/chart', [SupermarketController::class, 'chart'])->name('supermarkets.chart');
  Route::resource('/', SupermarketController::class);
  Route::get('/exportPdf', [SupermarketController::class, 'exportPdf'])->name('supermarkets.exportPdf');
  Route::get('/exportExcel', [SupermarketController::class, 'exportExcel'])->name('supermarkets.exportExcel');
});