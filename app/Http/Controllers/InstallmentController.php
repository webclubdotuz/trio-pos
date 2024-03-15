<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class InstallmentController extends Controller
{
    public function report_debt(Request $request)
    {

        $fact_debt_month_count = $request->fact_debt_month_count;

        $sales = Sale::where('installment_status', true)
        ->where('payment_status', 'installment')
        ->orderBy('date', 'desc')
        ->get();

        // dd($sales);
        $fact_debt_month_counts = $sales->pluck('fact_debt_month_count')->unique();

        if($fact_debt_month_count)
        {
            $sales = $sales->where('fact_debt_month_count', $fact_debt_month_count);
        }

        return view('pages.installments.report_debt', compact('sales', 'fact_debt_month_counts'));
    }
}
