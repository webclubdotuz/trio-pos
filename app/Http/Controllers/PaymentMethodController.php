<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $payment_methods = PaymentMethod::all();
        return view('pages.payment_methods.index', compact('payment_methods'));
    }

    public function create()
    {
        return view('pages.payment_methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        PaymentMethod::create($request->all());

        return redirect()->route('payment-methods.index')->with('success', 'Способ оплаты успешно создан');
    }

    public function show(PaymentMethod $payment_method)
    {
        return view('pages.payment_methods.show', compact('payment_method'));
    }

    public function edit(PaymentMethod $payment_method)
    {
        return view('pages.payment_methods.edit', compact('payment_method'));
    }

    public function update(Request $request, PaymentMethod $payment_method)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $payment_method->update($request->all());

        return redirect()->route('payment-methods.index')->with('success', 'Способ оплаты успешно обновлен');
    }

    public function destroy(PaymentMethod $payment_method)
    {
        $payment_method->delete();
        return redirect()->route('payment-methods.index')->with('success', 'Способ оплаты успешно удален');
    }
}
