<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');

    // Routes for User
    Route::post('/admin/store', [HomeController::class, 'store'])->name('admin.store');
    Route::put('/admin/update/{id}', [HomeController::class, 'update'])->name('admin.update');
    Route::post('/admin/destroy/{id}', [HomeController::class, 'destroy'])->name('admin.destroy');

    // Routes for Category
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::put('/admin/category/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::post('/admin/category/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');


    Route::get('/admin/product', [ProductController::class, 'index'])->name('admin.product');
    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.product.store');
    Route::put('/admin/product/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::post('/admin/product/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

    Route::get('/admin/product/exportData', [ProductController::class, 'exportData'])->name('admin.product.exportData');
});


/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
// Route::middleware(['auth', 'user-access:manager'])->group(function () {

//     Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
// });
