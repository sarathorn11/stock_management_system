<?php

namespace App\Http\Controllers;

use App\Models\ReturnList;
use Illuminate\Http\Request;

class ReturnListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('return.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('return.create');
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
    public function show(ReturnList $returnList)
    {
        return view('return.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReturnList $returnList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReturnList $returnList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReturnList $returnList)
    {
        //
    }
}
