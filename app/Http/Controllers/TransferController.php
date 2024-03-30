<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
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

    public function show(Transfer $transfer)
    {
        return view('pages.transfers.show', compact('transfer'));
    }
}
