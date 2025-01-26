<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\BackOrderController;
use App\Http\Controllers\ReturnListController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SupplierListController;
use App\Http\Controllers\ItemListController;
use App\Http\Controllers\UserListController;
use App\Http\Controllers\SettingController;
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

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Purchase Order Routes
Route::resource('purchase-order', PurchaseOrderController::class);

// Receiving Routes
Route::resource('receiving', ReceivingController::class);

// Back Order Routes
Route::resource('back-order', BackOrderController::class);

// Return List Routes
Route::resource('return', ReturnListController::class);

// Stock List Routes
Route::get('/stocks/search', [StockController::class, 'search'])->name('stocks.search');
Route::resource('stocks', StockController::class);

// Sale List Routes
Route::resource('sales', SalesController::class);
Route::get('sales/search', [SalesController::class, 'search'])->name('sales.search');

// Supplier List Routes
Route::resource('supplier', SupplierListController::class);

// Item List Routes
Route::resource('item', ItemListController::class);

// User List Routes
Route::resource('user', UserListController::class);

// Settings Routes
Route::resource('setting', SettingController::class);
