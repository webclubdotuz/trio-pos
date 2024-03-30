<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function index()
    {
        return view('pages.transfers.index');
    }

    public function create()
    {
        return view('pages.transfers.create');
    }

    public function store(Request $request)
    {
        // Validate the request...
    }
}
