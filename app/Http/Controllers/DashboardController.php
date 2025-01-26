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
        return view('dashboard.index');
    }
}
