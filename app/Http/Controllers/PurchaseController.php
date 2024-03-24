<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Product;
use App\Models\ProductWarehouse;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::all();

        return view('pages.purchases.index', compact('purchases'));
    }

    public function create()
    {
        return view('pages.purchases.create');
    }

    public function store(StorePurchaseRequest $request)
    {

        try {
            DB::beginTransaction();
            $currency_rate = getCurrencyRate();
            $purchase = Purchase::create(
                [
                    'supplier_id' => $request->supplier_id,
                    'warehouse_id' => $request->warehouse_id,
                    'user_id' => auth()->id(),
                    'invoice_number' => $this->generateInvoiceNumber(),
                    'total' => 0,
                    'total_usd' => 0,
                    'currency_rate' => 0,
                    'payment_status' => 'debt',
                    'description' => $request->description,
                    'date' => $request->date,
                ]
            );

            $total = 0;
            $total_usd = 0;

            foreach ($request->items as $item) {
                $total += $item['quantity'] * $item['price'];
                $total_usd += $item['quantity'] * $item['price_usd'];

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'warehouse_id' => $request->warehouse_id,
                    'product_id' => $item['product_id'],
                    'supplier_id' => $request->supplier_id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'price_usd' => $item['price_usd'],
                    'total' => $item['quantity'] * $item['price'],
                    'total_usd' => $item['quantity'] * $item['price_usd'],
                    'currency_rate' => $currency_rate,
                    'date' => $request->date,
                ]);

                $product = Product::find($item['product_id']);
                $product->in_price = $item['price'];
                $product->in_price_usd = $item['price_usd'];

                $product->price = $item['sale_price'];
                $product->price_usd = $item['sale_price_usd'];

                $product->installment_price = $item['installment_price'];
                $product->installment_price_usd = $item['installment_price_usd'];

                $product->save();

                $product_warehouse = ProductWarehouse::where('warehouse_id', $request->warehouse_id)
                    ->where('product_id', $item['product_id'])
                    ->first();

                $product = Product::find($item['product_id']);

                if ($product_warehouse) {
                    $product_warehouse->quantity += $item['quantity'];
                    $product_warehouse->save();
                } else {
                    ProductWarehouse::create([
                        'warehouse_id' => $request->warehouse_id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            }

            $purchase->update([
                'total' => $total,
                'total_usd' => $total_usd,
                'currency_rate' => $currency_rate,
            ]);


            DB::commit();
            return redirect()->route('purchases.index')->with('success', 'Покупка успешно добавлена');


        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return redirect()->route('purchases.index')->with('error', 'Ошибка добавления покупки' . $th->getMessage());
        }

    }

    public function show(Purchase $purchase)
    {
        return view('pages.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        //
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    public function destroy(Purchase $purchase)
    {
        //
    }

    private function generateInvoiceNumber()
    {
        $lastInvoice = Purchase::whereDate('date', Date('Y-m-d'))->count() + 1;
        return 'INV-' . Date('dmy') . '-' . $lastInvoice;
    }
}
