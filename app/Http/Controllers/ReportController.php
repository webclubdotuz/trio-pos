<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Payment;
use App\Models\SalePayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function opiu(Request $request)
    {

        $transactionYears = Transaction::selectRaw('year(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $selected_year = $request->selected_year ?? date('Y');

        $transactionMonths = Transaction::selectRaw('month(created_at) as month')
            ->whereRaw('year(created_at) = ?', [$selected_year])
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('pages.reports.opiu', compact('transactionYears', 'selected_year', 'transactionMonths'));
    }

    public function odds(Request $request)
    {
        $selected_year = $request->selected_year ?? date('Y');

        return view('pages.reports.odds', compact('selected_year'));
    }

    public function kassa(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $sale_payment_methods = SalePayment::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('sum(amount) as amount, payment_method_id')
            ->groupBy('payment_method_id')
            ->orderBy('amount', 'desc')
            ->get();




        return view('pages.reports.kassa', compact('start_date', 'end_date', 'sale_payment_methods'));
    }


    public function expense(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $expenses = \App\Models\Expense::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('sum(amount) as amount, expense_category_id')
            ->groupBy('expense_category_id')
            ->orderBy('amount', 'desc')
            ->get();
        $data = [];
        $labels = [];

        foreach ($expenses as $expense) {
            $data[] = $expense->amount;
            $labels[] = $expense->expense_category->name;
        }

        return view('pages.reports.expense', compact('start_date', 'end_date', 'data', 'labels', 'expenses'));
    }
}
