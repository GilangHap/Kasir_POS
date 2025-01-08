<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Filament\Resources\TransactionItemsResource\Pages\CreateTransactionItem;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\LoyaltyController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');

Route::get('/transaction-items/create', [CreateTransactionItem::class, 'create'])->name('filament.resources.transaction-items.create');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::post('/process-payment', [PaymentController::class, 'processPayment']);
