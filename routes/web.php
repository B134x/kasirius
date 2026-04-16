<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;

// Redirect root to dashboard
Route::get('/', fn () => redirect('/dashboard'));

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📦 PRODUK — view: all authenticated users; CUD: admin only
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::middleware(['isAdmin'])->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // 💰 KASIR — all POST to prevent browser prefetch side effects
    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');
    Route::post('/cart/add/{id}', [CashierController::class, 'add'])->name('cart.add');
    Route::post('/cart/increase/{id}', [CashierController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{id}', [CashierController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/remove/{id}', [CashierController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CashierController::class, 'checkout'])->name('checkout');

    // 📊 TRANSAKSI
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

    // 📝 STRUK
    Route::get('/receipt/{id}', function ($id) {
        $transaction = \App\Models\Transaction::with('details.product', 'cashier')->findOrFail($id);
        return view('receipt', compact('transaction'));
    })->name('receipt');
});

require __DIR__ . '/auth.php';
