<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/riwayat-pesanan', [OrderController::class, 'index'])->name('order.index');
    
    Route::get('/pesan/{kategori}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
    Route::get('/invoice/{nomor_invoice}', [OrderController::class, 'invoice'])->name('order.invoice');
    Route::post('/pembayaran/{order_id}', [PaymentController::class, 'store'])->name('payment.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware('auth')->group(function () {

    Route::get('/pesan/{kategori}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
    Route::get('/invoice/{nomor_invoice}', [OrderController::class, 'invoice'])->name('order.invoice');
});

Route::middleware('auth')->group(function () {
    // Rute Pemesanan
    Route::get('/pesan/{kategori}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/pesan', [OrderController::class, 'store'])->name('order.store');
    Route::get('/invoice/{nomor_invoice}', [OrderController::class, 'invoice'])->name('order.invoice');
    
    // Rute Pembayaran 
    Route::post('/pembayaran/{order_id}', [PaymentController::class, 'store'])->name('payment.store');
    // Dibatalkan
    Route::patch('/pesan/{id}/batal', [OrderController::class, 'cancel'])->name('order.cancel');
});

// Rute Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{id}/pembayaran', [AdminOrderController::class, 'updatePayment'])->name('orders.update_payment');
    Route::patch('/pesanan/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update_status');
    Route::delete('/pesanan/{id}/hapus', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});


