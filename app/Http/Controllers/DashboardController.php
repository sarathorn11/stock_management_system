<?php

namespace App\Http\Controllers;

use App\Models\BackOrder;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\Receiving;
use App\Models\ReturnList;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     */
    public function index()
    {
        $totalStocks = Stock::count();
        $totalSales = Sale::count();
        $totalPORecords = PurchaseOrder::count();
        $totalReceivingRecords = Receiving::count();
        $totalSupplierRecords = Supplier::count();
        $totalBORecords = BackOrder::count();
        $totalReturnRecords = ReturnList::count();
        $totalItemRecords = Item::count();
        // $totalSaleRecords = Sale::count();
        $totalUserRecords = User::count();


        return view('dashboard.index', compact(
            'totalStocks',
            'totalSales',
            'totalPORecords',
            'totalReceivingRecords',
            'totalSupplierRecords',
            'totalBORecords',
            'totalReturnRecords',
            'totalItemRecords',
            'totalUserRecords'
        ));
    }
}
