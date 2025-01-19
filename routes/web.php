<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\BackOrderController;
use App\Http\Controllers\ReturnListController;
use App\Http\Controllers\SupplierListController;
use App\Http\Controllers\ItemListController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\SettingsController;
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
    return view('welcome');
});

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Purchase Order Routes
Route::resource('purchase-order', PurchaseOrderController::class);

// Receiving Routes
Route::resource('receiving', ReceivingController::class);

// Back Order Routes
Route::resource('back-order', BackOrderController::class);

// Return List Routes
Route::resource('return', ReturnListController::class);

// Supplier List Routes
Route::resource('supplier', SupplierListController::class);

// Item List Routes
Route::resource('item', ItemListController::class);

// User List Routes
Route::resource('user', UserListController::class);

// Settings Routes
Route::resource('settings', SettingsController::class);

// Stocks Routes (Already Added)
Route::resource('stocks', StockController::class);