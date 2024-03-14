<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;

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
}
