<?php

namespace App\Livewire\Product;

use App\Models\Purchase as ModelsPurchase;
use Livewire\Component;

class Purchase extends Component
{

    public $product;
    public $purchases = [];

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {
        $this->purchases = ModelsPurchase::where('product_id', $this->product->id)
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->get();
        return view('livewire.product.purchase');
    }
}
