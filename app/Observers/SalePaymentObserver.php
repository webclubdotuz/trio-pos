<?php

namespace App\Observers;

use App\Models\SalePayment;

class SalePaymentObserver
{
    /**
     * Handle the SalePayment "created" event.
     */
    public function created(SalePayment $salePayment): void
    {

        $sale = $salePayment->sale;
        if ($sale->installment_status)
        {
            $debt = $sale->debt;
            if ($debt == 0) {
                $sale->payment_status = 'paid';
            } else {
                $sale->payment_status = 'installment';
            }

            $sale->save();

            return;
        }


        $debt = $sale->debt;
        if ($debt == 0) {
            $sale->payment_status = 'paid';
        } else {
            $sale->payment_status = 'debt';
        }

        $sale->save();
    }

    /**
     * Handle the SalePayment "updated" event.
     */
    public function updated(SalePayment $salePayment): void
    {
        $sale = $salePayment->sale;
        $debt = $sale->debt;
        if ($debt == 0) {
            $sale->payment_status = 'paid';
        } else {
            $sale->payment_status = 'debt';
        }

        $sale->save();
    }

    /**
     * Handle the SalePayment "deleted" event.
     */
    public function deleted(SalePayment $salePayment): void
    {
        $sale = $salePayment->sale;
        $debt = $sale->debt;
        if ($debt == 0) {
            $sale->payment_status = 'paid';
        } else {
            $sale->payment_status = 'debt';
        }

        $sale->save();
    }

    /**
     * Handle the SalePayment "restored" event.
     */
    public function restored(SalePayment $salePayment): void
    {
        //
    }

    /**
     * Handle the SalePayment "force deleted" event.
     */
    public function forceDeleted(SalePayment $salePayment): void
    {
        //
    }
}
