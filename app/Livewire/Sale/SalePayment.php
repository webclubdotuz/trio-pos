<?php

namespace App\Livewire\Sale;

use App\Models\Installment;
use App\Models\Sale;
use App\Models\SalePayment as SalePaymentModel;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class SalePayment extends Component
{
    use LivewireAlert;

    public $sale_id;
    public $customer_id;

    public $payments = [0];
    public $payment_amounts = [0];
    public $payment_methods = [1];
    public $date;

    protected $listeners = [
        'openSalePayment' => 'openModalSalePayment'
    ];

    public function mount()
    {
        $this->date = date('Y-m-d H:i');
    }

    public function openModalSalePayment($sale_id)
    {
        $this->sale_id = $sale_id;
        $this->dispatch('openModalSalePayment', ['sale_id' => $sale_id]);
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

        $sale = Sale::find($this->sale_id);
        if ($sale->installment_status) {
            $this->saveInstallment();
            return;
        }

        $this->validate([
            'payment_amounts' => 'required|array',
            'payment_amounts.*' => 'required|numeric|min:1',
            'payment_methods' => 'required|array',
            'payment_methods.*' => 'required|exists:payment_methods,id',
            'date' => 'required|date_format:Y-m-d H:i'
        ]);

        try {
            DB::beginTransaction();
            foreach ($this->payment_amounts as $key => $payment_amount) {
                SalePaymentModel::create([
                    'sale_id' => $this->sale_id,
                    'payment_method_id' => $this->payment_methods[$key],
                    'warehouse_id' => $sale->warehouse_id,
                    'customer_id' => $this->customer_id,
                    'user_id' => auth()->user()->id,
                    'amount' => $payment_amount,
                    'currency_rate' => getCurrencyRate(),
                    'amount_usd' => $payment_amount / getCurrencyRate(),
                    'description' => '',
                    'date' => $this->date
                ]);
            }

            DB::commit();
            $this->alert('success', 'Оплата успешно добавлена');
            return redirect()->route('sale-payments.print', $this->sale_id);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }

    }

    public function saveInstallment()
    {
        $this->validate([
            'payment_amounts' => 'required|array',
            'payment_amounts.*' => 'required|numeric|min:1',
            'payment_methods' => 'required|array',
            'payment_methods.*' => 'required|exists:payment_methods,id',
            'date' => 'required|date_format:Y-m-d H:i'
        ]);

        $sale = Sale::find($this->sale_id);

        $installment = [];
        foreach ($sale->installments as $installment) {
            if ($installment->debt > 0) {
                $installment = $installment;
                break;
            }
        }

        $payment_amount_total = 0;
        foreach ($this->payment_amounts as $key => $payment_amount)
        {
            $payment_amount_total += is_numeric($payment_amount) ? $payment_amount : 0;
        }

        if ($installment->debt < $payment_amount_total) {
            $this->alert('error', 'Сумма оплаты больше чем сумма долга');
            return;
        }

        try {
            DB::beginTransaction();

            foreach ($this->payment_amounts as $key => $payment_amount) {
                SalePaymentModel::create([
                    'sale_id' => $this->sale_id,
                    'installment_id' => $installment->id,
                    'payment_method_id' => $this->payment_methods[$key],
                    'warehouse_id' => $sale->warehouse_id,
                    'customer_id' => $this->customer_id,
                    'user_id' => auth()->user()->id,
                    'amount' => $payment_amount,
                    'currency_rate' => getCurrencyRate(),
                    'amount_usd' => $payment_amount / getCurrencyRate(),
                    'description' => '',
                    'date' => $this->date
                ]);
            }

            $installment = Installment::find($installment->id);
            if ($installment->debt == 0) {
                $installment->status = 'paid';
                $installment->save();
            }else{
                $installment->status = 'debt';
                $installment->save();
            }
            DB::commit();
            $this->alert('success', 'Оплата успешно добавлена');
            return redirect()->route('sale-payments.print', $this->sale_id);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }

    }

    public function render()
    {
        $sale = Sale::find($this->sale_id);
        $this->customer_id = $sale?->customer_id;
        $payment_amount_total = 0;
        foreach ($this->payment_amounts as $payment_amount) {
            $payment_amount_total += is_numeric($payment_amount) ? $payment_amount : 0;
        }
        return view('livewire.sale.sale-payment', compact('sale', 'payment_amount_total'));
    }
}
