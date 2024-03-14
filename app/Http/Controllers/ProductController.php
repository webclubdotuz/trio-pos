<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(StoreProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $product = Product::create($request->validated());

            if ($request->hasFile('image')) {

                $file_name = $product->id . '.' . $request->file('image')->extension();
                $path = $request->file('image')->storeAs('products', $file_name, 'public');
                $product->image = $path;
                $product->save();
            }

        });


        return redirect()->route('products.index')->with('success', 'Продукт успешно создан.');
    }

    public function show(Product $product)
    {
        return view('pages.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('pages.products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {

            if ($product->image && $request->hasFile('image'))
            {
                unlink(public_path('storage/' . $product->image));
                $product->image = null;
                $product->save();
            }

            $product->update($request->validated());

            if ($request->hasFile('image')) {
                $file_name = $product->id . '.' . $request->file('image')->extension();
                $path = $request->file('image')->storeAs('products', $file_name, 'public');
                $product->image = $path;
                $product->save();
            }
        });

        return redirect()->route('products.index')->with('success', 'Продукт успешно обновлен.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Продукт успешно удален.');
    }
}
