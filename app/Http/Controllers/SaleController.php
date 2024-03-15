<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return view('pages.sales.index', compact('sales'));
    }

    public function create()
    {
        return view('pages.sales.create');
    }

    public function store(StoreSaleRequest $request)
    {
        //
    }

    public function show(Sale $sale)
    {
        return view('pages.sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index');
    }

    public function contract(Sale $sale)
    {

        $installment_count = $sale->installments?->count() -1;
        $first_payment_percent = $sale->installment_percent;
        $first_payment = $sale->installment_first_payment;
        $two_payment = $sale->installments ? $sale->installments[1]->amount : 0;

        return view('pages.sales.print_contract', compact('sale', 'installment_count', 'first_payment_percent', 'first_payment', 'two_payment'));
    }

    public function report_user(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $sales = Sale::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->groupBy('user_id')
            ->selectRaw('sum(total) as total, user_id, count(id) as count, sum(installment_status = 1) as installment_status')
            ->orderBy('total', 'desc')
            ->get();

        return view('pages.sales.report_user', compact('sales', 'start_date', 'end_date'));



    }


}
