<?php

namespace App\Livewire\Purchase;

use App\Models\Transaction;
use Livewire\Component;
use App\Models\Purchase;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination, LivewireAlert;

    public $start_date, $end_date, $product_id, $warehouse_id, $supplier_id, $payment_status;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {
        $purchases = Purchase::whereBetween('date', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->orderBy('date', 'desc')
            ->when($this->warehouse_id, function ($query) {
                $query->where('warehouse_id', $this->warehouse_id);
            })
            ->get();

        return view('livewire.purchase.index', compact('purchases'));
    }
}
