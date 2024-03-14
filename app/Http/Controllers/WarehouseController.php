<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {

        $warehouses = Warehouse::orderBy('name', 'asc')->get();

        return view('pages.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('pages.warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $warehouse = new Warehouse([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
        ]);

        $warehouse->save();

        flash('Склад успешно добавлен', 'success');

        return redirect()->route('warehouses.index');
    }

    public function show(Warehouse $warehouse)
    {
        return view('pages.warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('pages.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $warehouse->name = $request->get('name');
        $warehouse->phone = $request->get('phone');
        $warehouse->address = $request->get('address');

        $warehouse->save();

        flash('Склад успешно обновлен', 'success');

        return redirect()->route('warehouses.index');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        flash('Склад успешно удален', 'success');

        return redirect()->route('warehouses.index');
    }
}
