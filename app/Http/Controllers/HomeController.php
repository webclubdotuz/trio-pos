<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $start_date = $request->start_date ? $request->start_date : date('Y-m-01');
        $end_date = $request->end_date ? $request->end_date : date('Y-m-d');
        $warehouse_id = $request->warehouse_id;

        $debt = Sale::where('payment_status', 'debt')
        ->when($warehouse_id, function ($query, $warehouse_id) {
            return $query->where('warehouse_id', $warehouse_id);
        })
        ->get();

        $debt = $debt->sum('debt');

        $installmet_debt = Installment::where('status', '!=', 'paid')->where('date', '<', date('Y-m-d'))
        ->when($warehouse_id, function ($query, $warehouse_id) {
            return $query->whereHas('sale', function ($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            });
        })
        ->get();
        $installmet_debt = $installmet_debt->sum('debt');


        $purchase_debt = Purchase::where('payment_status', 'debt')
        ->when($warehouse_id, function ($query, $warehouse_id) {
            return $query->where('warehouse_id', $warehouse_id);
        })
        ->get();
        $purchase_debt = $purchase_debt->sum('debt_usd');

        $sales_count = Sale::where('date', '>=', $start_date . ' 00:00:00')->where('date', '<=', $end_date . ' 23:59:59')
        ->when($warehouse_id, function ($query, $warehouse_id) {
            return $query->where('warehouse_id', $warehouse_id);
        })->count();

        $sales_total = Sale::where('date', '>=', $start_date . ' 00:00:00')->where('date', '<=', $end_date . ' 23:59:59')
        ->when($warehouse_id, function ($query, $warehouse_id) {
            return $query->where('warehouse_id', $warehouse_id);
        })->sum('total');


        // datas, labels
        $sale_chart = DB::table('sales')
        ->select(DB::raw('DATE(date) as date, sum(total) as total'))
        ->where('date', '>=', $start_date . ' 00:00:00')
        ->where('date', '<=', $end_date . ' 23:59:59')
        ->when($warehouse_id, function ($query, $warehouse_id) {
            return $query->where('warehouse_id', $warehouse_id);
        })
        ->where('deleted_at', null)
        ->groupBy('date')
        ->get();

        $sale_chart = $sale_chart->groupBy('date')
        ->map(function ($item) {
            return $item->sum('total');
        });

        $labels = [];
        $datas = [];

        foreach ($sale_chart as $key => $value) {
            $labels[] = df($key);
            $datas[] = $value;
        }


        return view('home', compact(
            'start_date',
            'end_date',
            'warehouse_id',
            'debt',
            'installmet_debt',
            'purchase_debt',
            'sales_count',
            'sales_total',
            'sale_chart',
            'labels',
            'datas'
        ));
    }
}
