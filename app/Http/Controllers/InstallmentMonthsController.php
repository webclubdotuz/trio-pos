<?php

namespace App\Http\Controllers;

use App\Models\InstallmentMonths;
use Illuminate\Http\Request;

class InstallmentMonthsController extends Controller
{
    public function index()
    {
        return view('installment_months.index');
    }

    public function create()
    {
        return view('installment_months.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'percent' => 'required',
            'description' => 'required'
        ]);

        $installmentMonth = InstallmentMonths::create($request->all());

        return redirect()->route('installment-months.index')->with('success', 'Installment month created successfully.');
    }

    public function show(InstallmentMonths $installmentMonth)
    {
        return view('installment_months.show', compact('installmentMonth'));
    }

    public function edit(InstallmentMonths $installmentMonth)
    {
        return view('installment_months.edit', compact('installmentMonth'));
    }

    public function update(Request $request, InstallmentMonths $installmentMonth)
    {
        $request->validate([
            'month' => 'required',
            'percent' => 'required',
            'description' => 'required'
        ]);

        $installmentMonth->update($request->all());

        return redirect()->route('installment-months.index')->with('success', 'Installment month updated successfully.');
    }

    public function destroy(InstallmentMonths $installmentMonth)
    {
        $installmentMonth->delete();

        return redirect()->route('installment-months.index')->with('success', 'Installment month deleted successfully.');
    }
}
