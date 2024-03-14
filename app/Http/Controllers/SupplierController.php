<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();

        return view('pages.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('pages.suppliers.create');
    }

    public function store(StoreSupplierRequest $request)
    {
        Supplier::create($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Поставщик успешно создан.');
    }

    public function show(Supplier $supplier)
    {
        return view('pages.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('pages.suppliers.edit', compact('supplier'));
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return redirect()->route('suppliers.index')->with('success', 'Поставщик успешно обновлен.');
    }

    public function destroy(Supplier $supplier)
    {

        if ($supplier->products->count()) {
            return redirect()->route('suppliers.index')->with('error', 'Нельзя удалить поставщика, у которого есть товары.');
        }

        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Поставщик успешно удален.');
    }
}
