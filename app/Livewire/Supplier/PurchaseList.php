<?php

namespace App\Livewire\Supplier;

use Livewire\Component;

class PurchaseList extends Component
{

    public $start_date, $end_date, $supplier_id;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {

        $purchases = \App\Models\Purchase::where('supplier_id', $this->supplier_id)
            ->whereBetween('date', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->get();

        return view('livewire.supplier.purchase-list', compact('purchases'));
    }
}
