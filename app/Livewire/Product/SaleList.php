<?php

namespace App\Livewire\Product;

use App\Models\SaleItem;
use Livewire\Component;

class SaleList extends Component
{

    public $product_id, $warehouse_id;
    public $start_date, $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');

        $user = auth()->user();

    }



    public function render()
    {

        $sale_items = SaleItem::query()
            ->where('product_id', $this->product_id)
            ->whereHas('sale', function ($query) {
                $query->whereBetween('date', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59']);
            })
            ->when($this->warehouse_id, function ($query) {
                return $query->where('warehouse_id', $this->warehouse_id);
            })
            ->get();

        return view('livewire.product.sale-list', compact('sale_items'));
    }
}
