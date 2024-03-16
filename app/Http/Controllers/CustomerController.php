<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

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

        // sales count > 1
        $customers = Customer::whereHas('sales', function ($query) {
            $query->havingRaw('COUNT(*) > 1');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(100);

        return view('pages.customers.report', compact('customers'));
    }




}
