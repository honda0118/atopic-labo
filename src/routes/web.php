<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [IndexController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'showProductsByCategory'])->name('categories.products');

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand}', [BrandController::class, 'showProductsByBrand'])->name('brands.products');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::resource('/products', ProductController::class)->except(['update', 'show']);
    Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    Route::resource('/reviews', ReviewController::class)->except('show');

    Route::resource('/favorites', FavoriteController::class)->except(['store', 'show', 'update', 'create', 'edit']);

    Route::get('/mypage', function () {
        return Inertia::render('Mypage');
    })->name('mypage');
});

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

require __DIR__ . '/auth.php';
