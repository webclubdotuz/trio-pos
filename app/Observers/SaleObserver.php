<?php

namespace App\Observers;

use App\Models\Sale;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     */
    public function created(Sale $sale): void
    {
        $sale->update([
            'count' => $sale->saleItems->count(),
            'quantity' => $sale->saleItems->sum('quantity'),
            'total' => $sale->price * $sale->saleItems->sum('quantity'),
        ]);

        $transaction = $sale->transaction;
        $transaction->update([
            'total' => $transaction->sales->sum('total'),
        ]);
    }

    /**
     * Handle the Sale "updated" event.
     */
    public function updated(Sale $sale): void
    {
        $sale->update([
            'count' => $sale->saleItems->count(),
            'quantity' => $sale->saleItems->sum('quantity'),
            'total' => $sale->saleItems->sum('quantity') * $sale->price,
        ]);

        $transaction = $sale->transaction;
        $transaction->update([
            'total' => $transaction->sales->sum('total'),
        ]);
    }

    /**
     * Handle the Sale "deleted" event.
     */
    public function deleted(Sale $sale): void
    {
        $transaction = $sale->transaction;
        $transaction->update([
            'total' => $transaction->sales->sum('total'),
        ]);
    }

    /**
     * Handle the Sale "restored" event.
     */
    public function restored(Sale $sale): void
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     */
    public function forceDeleted(Sale $sale): void
    {
        //
    }
}
