<?php

namespace App\Http\Controllers;

use App\Models\SalePayment;
use Illuminate\Http\Request;

class SalePaymentController extends Controller
{


    public function print(SalePayment $sale_payment)
    {
        return view('pages.sale_payments.print', compact('sale_payment'));
    }
}
