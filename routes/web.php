<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\ProductController;
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

Route::get('/', function () {
    // ウェブサイトのホームページ（'/'のURL）にアクセスした場合のルートです
    if (Auth::check()) {
        // ログイン状態ならば
        return redirect()->route('products.index');
        // 商品一覧ページ（ProductControllerのindexメソッドが処理）へリダイレクトします
    } else {
        // ログイン状態でなければ
        return redirect()->route('login');
        //　ログイン画面へリダイレクトします
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/products', [App\Http\Controllers\ProductController::class,'index'])->name('product.index');

Route::get('/product/create', [App\Http\Controllers\ProductController::class,'create'])->name('product.create');

Route::post('/product/store', [App\Http\Controllers\ProductController::class,'store'])->name('product.store');

Route::get('/product/edit/{product}', [App\Http\Controllers\ProductController::class,'edit'])->name('product.edit');

Route::put('/product/edit/{product}',[App\Http\Controllers\ProductController::class,'update'])->name('product.update');

Route::delete('/products/{product}',[App\Http\Controllers\ProductController::class,'destroy'])->name('product.destroy');

Route::get('/product/show/{product}', [App\Http\Controllers\ProductController::class,'show'])->name('product.show');

Route::get('/product/getlistAjax', [App\Http\Controllers\ProductController::class,'getlistAjax'])->name('product.getlistAjax');

Route::post('/product/destroyAjax/{id}', [App\Http\Controllers\ProductController::class,'destroyAjax'])->name('product.destroyAjax');
