<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\PurchasePayment;
use App\Models\SalePayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function odds(Request $request)
    {
        $selected_year = $request->selected_year ?? date('Y');

        return view('pages.reports.odds', compact('selected_year'));
    }

    public function kassa(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');
        $warehouse_id = $request->warehouse_id ?? 0;

        $sale_payment_methods = SalePayment::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('sum(amount) as amount, payment_method_id, "sale" as type')
            ->groupBy('payment_method_id')
            ->when($warehouse_id, function ($query, $warehouse_id) {
                return $query->where('warehouse_id', $warehouse_id);
            })
            ->orderBy('amount', 'desc')
            ->get();

        $purchase_payment_methods = PurchasePayment::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('sum(amount) as amount, payment_method_id, "purchase" as type')
            ->groupBy('payment_method_id')
            ->when($warehouse_id, function ($query, $warehouse_id) {
                return $query->where('warehouse_id', $warehouse_id);
            })
            ->orderBy('amount', 'desc')
            ->get();

        $expense_payment_methods = Expense::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('sum(amount) as amount, payment_method_id, "expense" as type')
            ->groupBy('payment_method_id')
            ->when($warehouse_id, function ($query, $warehouse_id) {
                return $query->where('warehouse_id', $warehouse_id);
            })
            ->orderBy('amount', 'desc')
            ->get();

        $all_transactions = collect();
        $all_transactions = $all_transactions->merge($sale_payment_methods);
        $all_transactions = $all_transactions->merge($purchase_payment_methods);
        $all_transactions = $all_transactions->merge($expense_payment_methods);

        return view('pages.reports.kassa', compact('start_date', 'end_date', 'all_transactions'));
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
