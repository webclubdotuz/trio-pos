<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\SaleItem;
use Illuminate\Http\Request;
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

    public function report_sales(Request $request)
    {

        $start_date = date('Y-m-01') ?? $request->start_date;
        $end_date = date('Y-m-t') ?? $request->end_date;
        $warehouse_id = $request->warehouse_id ?? null;

        $sale_items = SaleItem::whereHas('sale', function ($query) use ($start_date, $end_date) {
            $query->whereBetween('date', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        })->when($warehouse_id, function ($query, $warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            })->orderBy('product_id')->get();

        return view('pages.products.report_sales', compact('sale_items', 'start_date', 'end_date'));
    }


}
