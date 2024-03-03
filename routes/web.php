<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('create');
});

Route::get('/list', function () {

    $product = Product::all();

    return view(
        'list',
        [
            'product' => $product,
        ]
    );
})->name('list.product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(ProductController::class)->group(function () {
    Route::post('/product-store', 'store')->name('product.store');
    Route::get('/product/edit/{id}', 'productEdit')->name('product.edit');
    Route::post('/product/update{id}', 'update')->name('product.update');
    Route::get('/product/delete/{id}', 'destroy')->name('product.destroy');

});

require __DIR__ . '/auth.php';
