<?php

namespace App\Livewire\Purchase;

use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Payment extends Component
{

    use LivewireAlert;
    public $purchase_id;
    public $supplier_id;

    public $payments = [0];
    public $payment_amounts = [0];
    public $payment_methods = [1];
    public $date;

    protected $listeners = [
        'openPurchasePayment' => 'openModalPurchasePayment'
    ];

    public function mount()
    {
        $this->date = date('Y-m-d H:i');
    }

    public function openModalPurchasePayment($purchase_id)
    {
        $this->purchase_id = $purchase_id;
        $this->dispatch('openModalPurchasePayment', ['purchase_id' => $purchase_id]);
    }

    public function addPayment()
    {
        $this->payments[] = '';
        $this->payment_amounts[] = '';
        $this->payment_methods[] = '';
    }

    public function removePayment($index)
    {
        unset($this->payments[$index]);
        unset($this->payment_amounts[$index]);
        unset($this->payment_methods[$index]);
    }

    public function save()
    {

        $purchase = Purchase::find($this->purchase_id);

        $payment_amount_total = 0;
        foreach ($this->payment_amounts as $payment_amount) {
            $payment_amount_total += is_numeric($payment_amount) ? $payment_amount : 0;
        }

        if ($payment_amount_total > $purchase->debt_usd) {
            $this->alert('error', 'Сумма оплаты больше долга');
            return;
        }

        try {
            DB::beginTransaction();
            foreach ($this->payment_amounts as $key => $payment_amount) {
                if ($payment_amount > 0) {
                    $purchase->purchase_payments()->create([
                        'payment_method_id' => $this->payment_methods[$key],
                        'warehouse_id' => $purchase->warehouse_id,
                        'supplier_id' => $this->supplier_id,
                        'user_id' => auth()->id(),
                        'amount' => $payment_amount * $purchase->currency_rate,
                        'currency_rate' => $purchase->currency_rate,
                        'amount_usd' => $payment_amount,
                        'description' => 'Оплата по счету №' . $purchase->invoice_number,
                        'date' => $this->date,
                    ]);
                }
            }

            DB::commit();
            $this->alert('success', 'Оплата успешно добавлена');
            $this->js('location.reload();');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
        }

    }

    public function render()
    {

        $purchase = Purchase::find($this->purchase_id);
        $this->supplier_id = $purchase?->supplier_id;

        $payment_amount_total = 0;
        foreach ($this->payment_amounts as $payment_amount) {
            $payment_amount_total += is_numeric($payment_amount) ? $payment_amount : 0;
        }

        return view('livewire.purchase.payment', [
            'purchase' => $purchase,
            'payment_amount_total' => $payment_amount_total,
        ]);
    }
}
