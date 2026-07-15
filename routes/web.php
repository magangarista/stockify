<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductAttributeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::name('index-practice')->get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::name('practice.')->group(function () {
        Route::name('first')->get('practice/1', function () {
            return view('pages.practice.1');
        });
        Route::name('second')->get('practice/2', function () {
            return view('pages.practice.2');
        });
    });

    Route::post('/product-attributes', [ProductAttributeController::class, 'store'])->name('product-attributes.store');
    Route::delete('/product-attributes/{id}/{productId}', [ProductAttributeController::class, 'destroy'])->name('product-attributes.destroy');

    // Route Modul Produk
    Route::resource('products', ProductController::class);

    // Route Modul Kategori
    Route::resource('categories', CategoryController::class);

    // Route Modul Supplier
    Route::resource('suppliers', SupplierController::class);

    // Route Modul Stok
    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', [StockTransactionController::class, 'index'])->name('index');
        Route::get('/in/create', [StockTransactionController::class, 'createIn'])->name('in.create');
        Route::post('/in', [StockTransactionController::class, 'storeIn'])->name('in.store');
        Route::get('/out/create', [StockTransactionController::class, 'createOut'])->name('out.create');
        Route::post('/out', [StockTransactionController::class, 'storeOut'])->name('out.store');
        Route::get('/opname', [StockTransactionController::class, 'opnameForm'])->name('opname.form');
        Route::post('/opname', [StockTransactionController::class, 'storeOpname'])->name('opname.store');

        // Konfirmasi oleh Staff Gudang
        Route::post('/in/{id}/confirm', [StockTransactionController::class, 'confirmIn'])->name('in.confirm');
        Route::post('/out/{id}/confirm', [StockTransactionController::class, 'confirmOut'])->name('out.confirm');
    });

    // Route Modul Pengguna (Admin only)
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Route Modul Laporan
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/stock', [ReportController::class, 'stock'])->name('stock');
        Route::get('/transactions', [ReportController::class, 'transactions'])->name('transactions');
        Route::get('/activity', [ReportController::class, 'activity'])->name('activity')->middleware('role:Admin');
    });

});

// Dashboard otomatis menyesuaikan tampilan berdasarkan role (lihat DashboardController)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/search/products', [SearchController::class, 'products'])->name('search.products');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';