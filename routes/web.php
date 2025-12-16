<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\ClientDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\FiscalDeviceController;
use App\Http\Controllers\CustomerController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::prefix('settings')->middleware(['auth'])->group(function () {
    Route::get('/client-details', [ClientDetailController::class, 'index'])
        ->name('client-details.index');

    Route::get('/client-details/create', [ClientDetailController::class, 'create'])
        ->name('client-details.create');

    Route::post('/client-details', [ClientDetailController::class, 'store'])
        ->name('client-details.store');

    Route::get('/client-details/{id}/edit', [ClientDetailController::class, 'edit'])
        ->name('client-details.edit');

    Route::put('/client-details/{id}', [ClientDetailController::class, 'update'])
        ->name('client-details.update');

    Route::delete('/client-details/{id}', [ClientDetailController::class, 'destroy'])
        ->name('client-details.destroy');

    Route::resource('device', FiscalDeviceController::class);
    
});



Route::middleware(['auth'])->group(function () {

    // Product Index
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    // Create Product
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store');

    // Edit Product (hashed ID)
    Route::get('/products/{hashedId}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    // Update Product (hashed ID)
    Route::put('/products/{hashedId}', [ProductController::class, 'update'])
        ->name('products.update');

    // Delete Product (hashed ID)
    Route::delete('/products/{hashedId}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

});

Route::middleware(['auth'])->group(function () {

    // Generate hashed POS URL dynamically
    Route::get('/p/{hash}', [POSController::class, 'index'])
        ->name('pos.hashed');

});


Route::middleware(['auth'])->group(function () {

    Route::resource('customers', CustomerController::class);

});

require __DIR__.'/auth.php';
