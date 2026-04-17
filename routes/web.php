<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\CategoryController;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

/*
|--------------------------------------------------------------------------
| SEMUA USER LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| ADMIN + KASIR
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin|kasir'])->group(function () {

    // 💰 KASIR
    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');

    Route::get('/cart/add/{id}', [CashierController::class, 'add'])->name('cart.add');
    Route::get('/cart/increase/{id}', [CashierController::class, 'increase'])->name('cart.increase');
    Route::get('/cart/decrease/{id}', [CashierController::class, 'decrease'])->name('cart.decrease');
    Route::get('/cart/remove/{id}', [CashierController::class, 'remove'])->name('cart.remove');

    Route::post('/checkout', [CashierController::class, 'checkout'])->name('checkout');

    // 📦 PRODUK (READ ONLY)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // 📊 TRANSAKSI
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/export', [TransactionController::class, 'export'])
    ->name('transactions.export');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

    // 📝 RECEIPT
    Route::get('/receipt/{id}', function ($id) {
        $transaction = \App\Models\Transaction::with('details.product')->findOrFail($id);
        return view('receipt', compact('transaction'));
    })->name('receipt');
});


/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // 📦 PRODUK
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // 📥 STOCK IN
    Route::get('/stock-in', [StockInController::class, 'index'])->name('stockin');
    Route::post('/stock-in', [StockInController::class, 'store'])->name('stockin.store');

    // 📦 STOK HABIS
    Route::get('/stok-habis', [ProductController::class, 'outOfStock'])->name('products.outofstock');

    // 📦 KATEGORI
    Route::resource('categories', CategoryController::class);
});

require __DIR__ . '/auth.php';
