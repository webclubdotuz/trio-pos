<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Models\User;
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

        $sale_payments = SalePayment::whereBetween('date', [$start_date, $end_date])
            ->when($warehouse_id, function ($query, $warehouse_id) {
                return $query->where('warehouse_id', $warehouse_id);
            })
            ->groupBy('payment_method_id')
            ->selectRaw('sum(amount) as total, payment_method_id')
            ->get();

        $sale_users = Sale::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->groupBy('user_id')
            ->selectRaw('sum(total) as total, user_id, count(id) as count, sum(installment_status = 1) as installment_status')
            ->orderBy('total', 'desc')
            ->get();

        $top_products = SaleItem::whereHas('sale', function ($query) use ($start_date, $end_date, $warehouse_id) {
            $query->whereBetween('date', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
            if ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            }
        })
        ->groupBy('product_id')
        ->selectRaw('sum(quantity) as quantity, sum(total) as total, product_id')
        ->orderBy('total', 'desc')
        ->get();

        $user_plans = User::where('plan', '>', '0')->orderBy('fullname')->get();

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
            'datas',
            'sale_payments',
            'sale_users',
            'top_products',
            'user_plans'
        ));
    }
}
