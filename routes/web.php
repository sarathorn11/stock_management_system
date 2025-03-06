<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReceivingController;
use App\Http\Controllers\BackOrderController;
use App\Http\Controllers\ReturnListController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
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

// Account Route
Route::get('/account', [AccountController::class, 'index'])->name('account.index');

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Purchase Order Routes
Route::resource('purchase-order', PurchaseOrderController::class);
Route::delete('purchase-order', [PurchaseOrderController::class, 'destroy'])->name('purchase-order.destroy');

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
Route::resource('sales', SaleController::class);
Route::get('sales/search', [SaleController::class, 'search'])->name('sales.search');

// Supplier List Routes
Route::resource('supplier', SupplierController::class);
Route::get('/supplier/{id}', [SupplierController::class, 'show'])->name('supplier.show');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
Route::get('/suppliers', [SupplierController::class, 'getAllSuppliers'])->name('suppliers.getAll');

// Item List Routes
Route::resource('items', ItemController::class);
Route::post('/items/delete', [ItemController::class, 'deleteSelected'])->name('items.deleteSelected');

// User List Routes
Route::resource('user', UserController::class);
Route::post('/user/delete', [UserController::class, 'deleteSelected'])->name('user.deleteSelected');


// Setting Routes
// Route for displaying the settings form (GET request)
Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
// Route for updating the settings (PUT request)
Route::put('/setting', [SettingController::class, 'update'])->name('setting.update');
