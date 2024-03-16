<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');
        $expense_category_id = $request->expense_category_id ?? null;

        $expenses = Expense::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
        ->when($expense_category_id, function ($query) use ($expense_category_id) {
            return $query->where('expense_category_id', $expense_category_id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        return view('pages.expenses.index', compact('expenses', 'start_date', 'end_date'));
    }

    public function create()
    {
        return view('pages.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'to_user_id' => 'nullable|exists:users,id', // 'nullable|exists:users,id
            'amount' => 'required|numeric',
            'payment_method_id' => 'required|exists:payment_methods,id', // 'nullable|exists:payment_methods,id
            'description' => 'nullable|string',
        ]);

        Expense::create([
            'expense_category_id' => $request->expense_category_id,
            'warehouse_id' => $request->warehouse_id,
            'user_id' => auth()->user()->id,
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
            'payment_method_id' => $request->payment_method_id,
            'description' => $request->description,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Расход успешно добавлен');
    }

    public function edit(Expense $expense)
    {
        return view('pages.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'to_user_id' => 'nullable|exists:users,id', // 'nullable|exists:users,id
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);


        $expense->update([
            'expense_category_id' => $request->expense_category_id,
            'warehouse_id' => $request->warehouse_id,
            'user_id' => auth()->user()->id,
            'to_user_id' => $request->to_user_id,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Расход успешно обновлен');
    }

    public function destroy($expense)
    {
        $expense = Expense::findOrFail($expense);

        // 7 days
        if ($expense->created_at->diffInDays(now()) > 7) {
            return redirect()->route('expenses.index')->with('error', 'Расход можно удалить только в течении 7 дней');
        }

        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Расход успешно удален');
    }
}
