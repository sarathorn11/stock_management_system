<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     */
    public function index()
    {
        // Example data for the dashboard
        $totalStocks = Stock::count();
        $totalQuantity = Stock::sum('quantity');
        $totalValue = Stock::sum('total');

        // Pass data to the view
        return view('dashboard.index', compact('totalStocks', 'totalQuantity', 'totalValue'));
    }
}
