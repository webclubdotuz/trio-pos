<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return view('pages.sales.index', compact('sales'));
    }

    public function create()
    {
        return view('pages.sales.create');
    }

    public function installment()
    {
        return view('pages.sales.installment');
    }

    public function store(StoreSaleRequest $request)
    {
        //
    }

    public function show(Sale $sale)
    {
        return view('pages.sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(UpdateSaleRequest $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {

        if (!hasRoles(['admin', 'manager'])) {
            return redirect()->back()->with('error', 'У вас нет прав для удаления');
        }


        try {
            DB::beginTransaction();
            foreach ($sale->sale_items as $item) {
                $product = Product::find($item->product_id);
                $product->incrementQuantity($item->warehouse_id, $item->quantity);
                $product->save();
            }

            $sale->installments()->delete();
            $sale->payments()->delete();
            $sale->sale_items()->delete();


            $sale->delete();

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
        }

        return redirect()->route('sales.index');
    }

    public function contract(Sale $sale)
    {

        $installment_count = $sale->installments?->count() -1;
        $first_payment_percent = $sale->installment_percent;
        $first_payment = $sale->installment_first_payment;
        $two_payment = $sale->installments ? $sale->installments[1]->amount : 0;

        return view('pages.sales.print_contract', compact('sale', 'installment_count', 'first_payment_percent', 'first_payment', 'two_payment'));
    }

    public function report_user(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $sales = Sale::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->groupBy('user_id')
            ->selectRaw('sum(total) as total, user_id, count(id) as count, sum(installment_status = 1) as installment_status')
            ->orderBy('total', 'desc')
            ->get();

        return view('pages.sales.report_user', compact('sales', 'start_date', 'end_date'));
    }

    public function storeReview(Request $request, Sale $sale)
    {
        if ($request->hasFile('image')) {

            $path = $request->file('image')->storeAs('reviews', $request->file('image')->getClientOriginalName(), 'public');
            $sale->review()->create([
                'user_id' => auth()->id(),
                'comment' => $request->comment,
                'image' => $path
            ]);

            return redirect()->back()->with('success', 'Отзыв успешно добавлен');

        }
    }

    // destroyReview
    public function destroyReview(Sale $sale, $review)
    {
        if (file_exists(public_path('storage/' . $sale->review()->find($review)->image))) {
            unlink(public_path('storage/' . $sale->review()->find($review)->image));
        }

        $sale->review()->find($review)->delete();
        return redirect()->back()->with('success', 'Отзыв успешно удален');
    }


}
