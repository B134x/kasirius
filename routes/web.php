<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Semua route harus login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📦 PRODUK
    Route::resource('products', ProductController::class);

    // 💰 KASIR
    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');
    Route::get('/cart/add/{id}', [CashierController::class, 'add'])->name('cart.add');
    Route::get('/cart/increase/{id}', [CashierController::class, 'increase'])->name('cart.increase');
    Route::get('/cart/decrease/{id}', [CashierController::class, 'decrease'])->name('cart.decrease');
    Route::get('/cart/remove/{id}', [CashierController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CashierController::class, 'checkout'])->name('checkout');

    // 📊 TRANSAKSI
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

    // 📝 RECEIPT
    Route::get('/receipt/{id}', function ($id) {
    $transaction = \App\Models\Transaction::with('details.product')->findOrFail($id);
    return view('receipt', compact('transaction'));
})->name('receipt');
});

require __DIR__ . '/auth.php';
