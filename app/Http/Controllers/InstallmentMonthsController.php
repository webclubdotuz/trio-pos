<?php

namespace App\Http\Controllers;

use App\Models\InstallmentMonths;
use Illuminate\Http\Request;

class InstallmentMonthsController extends Controller
{
    public function index()
    {
        $installmentMonths = InstallmentMonths::orderBy('month')->get();
        return view('pages.installment_months.index', compact('installmentMonths'));
    }

    public function create()
    {
        return view('pages.installment_months.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'percent' => 'required',
            'description' => 'required'
        ]);

        $installmentMonth = InstallmentMonths::create($request->all());

        return redirect()->route('installment-months.index')->with('success', 'Рассрочка месяц добавлена успешно.');
    }

    public function show(InstallmentMonths $installmentMonth)
    {
        return view('pages.installment_months.show', compact('installmentMonth'));
    }

    public function edit(InstallmentMonths $installmentMonth)
    {
        return view('pages.installment_months.edit', compact('installmentMonth'));
    }

    public function update(Request $request, InstallmentMonths $installmentMonth)
    {
        $request->validate([
            'month' => 'required',
            'percent' => 'required',
        ]);

        $installmentMonth->update($request->all());

        return redirect()->route('installment-months.index')->with('success', 'Рассрочка месяц обновлена успешно.');
    }

    public function destroy(InstallmentMonths $installmentMonth)
    {
        $installmentMonth->delete();

        return redirect()->route('installment-months.index')->with('success', 'Рассрочка месяц удалена успешно.');
    }
}
