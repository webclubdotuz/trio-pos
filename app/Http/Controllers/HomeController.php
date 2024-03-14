<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

        $start_date = now()->startOfMonth();
        $end_date = now();



        return view('home');
    }
}
