<?php

namespace App\Observers;

use App\Models\PurchasePayment;

class PurchasePaymentObserver
{
    /**
     * Handle the PurchasePayment "created" event.
     */
    public function created(PurchasePayment $purchasePayment): void
    {
        $purchase = $purchasePayment->purchase;

        if ($purchase->debt_usd)
        {
            $purchase->payment_status = 'debt';
        }
        else
        {
            $purchase->payment_status = 'paid';
        }
        $purchase->save();
    }

    /**
     * Handle the PurchasePayment "updated" event.
     */
    public function updated(PurchasePayment $purchasePayment): void
    {
        $purchase = $purchasePayment->purchase;
        if ($purchase->debt_usd)
        {
            $purchase->payment_status = 'debt';
        }
        else
        {
            $purchase->payment_status = 'paid';
        }
    }

    /**
     * Handle the PurchasePayment "deleted" event.
     */
    public function deleted(PurchasePayment $purchasePayment): void
    {
        $purchase = $purchasePayment->purchase;
        if ($purchase->debt_usd)
        {
            $purchase->payment_status = 'debt';
        }
        else
        {
            $purchase->payment_status = 'paid';
        }
    }

    /**
     * Handle the PurchasePayment "restored" event.
     */
    public function restored(PurchasePayment $purchasePayment): void
    {
        //
    }

    /**
     * Handle the PurchasePayment "force deleted" event.
     */
    public function forceDeleted(PurchasePayment $purchasePayment): void
    {
        //
    }
}
