<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('pages.customers.index');
    }

    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {

        $customer = Customer::create($request->validated());

        return redirect()->route('customers.index');

    }

    public function show(Customer $customer)
    {
        return view('pages.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('pages.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return redirect()->route('customers.index');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        flash('Клиент успешно удален', 'success');
        return redirect()->back();
    }

    public function report()
    {

        $customers = Customer::whereHas('sales', function ($query) {
            $query->havingRaw('COUNT(*) > 1');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(100);

        return view('pages.customers.report', compact('customers'));
    }

    public function find_report(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-d', strtotime('-1 month'));
        $end_date = $request->end_date ?? date('Y-m-d');

        // find_id group by count
        $customers = Customer::groupBy('find_id')->selectRaw('find_id, count(*) as total')->get();

        $data = [];
        $labels = [];

        foreach ($customers as $customer) {
            $data[] = $customer->total;
            $labels[] = $customer?->find?->name;
        }

        return view('pages.customers.find_report', compact('start_date', 'end_date', 'data', 'labels', 'customers'));
    }




}
