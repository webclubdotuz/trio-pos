<?php


namespace App\Services;

use App\Models\Transaction;

class PaymentService
{
    public function create($transaction_id, $amount, $method, $description)
    {

        if ($amount <= 0) {
            return 'Не оплачено';
        }

        $transaction = Transaction::find($transaction_id);

        try {
            if ($transaction->debt == $amount) {
                $transaction->update([
                    'payment_status' => 'paid',
                ]);

                $transaction->payments()->create([
                    'contact_id' => $transaction->contact_id,
                    'user_id' => auth()->user()->id,
                    'amount' => $amount,
                    'method' => $method,
                    'description' => $description,
                ]);

                return 'Успешно оплачено';
            }
            elseif ($transaction->debt > $amount || $amount > 0) {
                $transaction->update([
                    'payment_status' => 'debt',
                ]);

                $transaction->payments()->create([
                    'contact_id' => $transaction->contact_id,
                    'user_id' => auth()->user()->id,
                    'amount' => $amount,
                    'method' => $method,
                    'description' => $description,
                ]);

                return 'Оплачено частично';
            } else {
                return 'Не оплачено';
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }
}
