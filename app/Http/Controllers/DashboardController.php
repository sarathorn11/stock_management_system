<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Sale;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     */
    public function index()
    {
        $totalStocks = Stock::count();
        $totalSales = Sale::count();

        return view('dashboard.index', compact('totalStocks', 'totalSales'));
    }
}
