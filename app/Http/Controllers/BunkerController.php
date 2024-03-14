<?php

namespace App\Http\Controllers;

use App\Models\Bunker;
use Illuminate\Http\Request;

class BunkerController extends Controller
{
    public function index()
    {

        $bunkers = Bunker::with('bunkerItems.product')->get();

        return view('pages.bunkers.index', compact('bunkers'));
    }

    public function create()
    {

        $bunkers = Bunker::orderBy('created_at', 'desc')->limit(10)->get();

        return view('pages.bunkers.create', compact('bunkers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.quantity' => 'required|numeric|min:0',
        ]);

        $bunker = Bunker::create([
            'user_id' => auth()->id(),
            'quantity' => 0,
        ]);

        foreach ($request->products as $key => $product) {

            if ($product['quantity'] <= 0) {
                continue;
            }

            $bunker->bunkerItems()->create([
                'product_id' => $key,
                'quantity' => $product['quantity'],
            ]);
        }

        $count = $bunker->bunkerItems()->count();
        if ($count > 0) {
            $bunker->quantity = $bunker->bunkerItems()->sum('quantity');
            $bunker->save();
        } else {
            $bunker->delete();
            return redirect()->back()->with('error', 'Бункер не может быть пустым');
        }

        return redirect()->route('bunkers.index')->with('success', 'Бункер успешно добавлен');
    }


    public function show(Bunker $bunker)
    {
        return view('pages.bunkers.show', compact('bunker'));
    }

    public function edit(Bunker $bunker)
    {
        return view('pages.bunkers.edit', compact('bunker'));
    }

    public function update(Request $request, Bunker $bunker)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.quantity' => 'required|numeric|min:0',
        ]);

        $bunker->bunkerItems()->delete();

        foreach ($request->products as $key => $product) {

            if ($product['quantity'] <= 0) {
                continue;
            }

            $bunker->bunkerItems()->create([
                'product_id' => $key,
                'quantity' => $product['quantity'],
            ]);
        }

        $count = $bunker->bunkerItems()->count();
        if ($count > 0) {
            $bunker->quantity = $bunker->bunkerItems()->sum('quantity');
            $bunker->save();
        } else {
            $bunker->delete();
        }

        return redirect()->route('bunkers.index')->with('success', 'Бункер успешно обновлен');
    }

    public function destroy(Bunker $bunker)
    {
        if (date('Y-m-d') != date('Y-m-d', strtotime($bunker->created_at))) {
            return redirect()->route('bunkers.index')->with('error', 'Бункер можно удалить только в день создания');
        }

        $bunker->bunkerItems()->delete();
        $bunker->delete();

        return redirect()->route('bunkers.index')->with('success', 'Бункер успешно удален');
    }
}
