<?php

namespace App\Livewire\Customer;

use App\Models\Sale;
use Livewire\Component;

class SaleList extends Component
{

    public $start_date, $end_date, $product_id;
    public $customer_id;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }



    public function render()
    {

        $sales = Sale::whereBetween('date', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->orderBy('date', 'desc')
            ->where('customer_id', $this->customer_id)
            ->get();

        return view('livewire.customer.sale-list', compact('sales'));
    }
}
