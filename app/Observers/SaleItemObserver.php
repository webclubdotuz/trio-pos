<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\SaleItem;

class SaleItemObserver
{
    /**
     * Handle the SaleItem "created" event.
     */
    public function created(SaleItem $saleItem): void
    {
        $sale = Sale::find($saleItem->sale_id);
        $sale->update([
            'count' => $sale->saleItems->count(),
            'quantity' => $sale->saleItems->sum('quantity'),
            'total' => $sale->price * $sale->saleItems->sum('quantity'),
        ]);
    }

    /**
     * Handle the SaleItem "updated" event.
     */
    public function updated(SaleItem $saleItem): void
    {
        //
    }

    /**
     * Handle the SaleItem "deleted" event.
     */
    public function deleted(SaleItem $saleItem): void
    {
        $sale = Sale::find($saleItem->sale_id);
        $sale->update([
            'count' => $sale->saleItems->count(),
            'quantity' => $sale->saleItems->sum('quantity'),
            'total' => $sale->saleItems->sum('quantity') * $sale->price,
        ]);

        if ($sale->saleItems->count() == 0) {
            $sale->delete();
        }
    }

    /**
     * Handle the SaleItem "restored" event.
     */
    public function restored(SaleItem $saleItem): void
    {
        //
    }

    /**
     * Handle the SaleItem "force deleted" event.
     */
    public function forceDeleted(SaleItem $saleItem): void
    {
        //
    }
}
