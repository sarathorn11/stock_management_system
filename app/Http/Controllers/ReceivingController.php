<?php

namespace App\Http\Controllers;

use App\Models\Receiving;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('receiving.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('receiving.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Receiving $receiving)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Receiving $receiving)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Receiving $receiving)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receiving $receiving)
    {
        //
    }
}
