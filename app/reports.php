<?php

use App\Models\Sale;

function getSaleTotal($start_date, $end_date) {
    $sale_total = Sale::whereBetween('date', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('total');
    return $sale_total;
}
