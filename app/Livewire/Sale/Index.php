<?php

namespace App\Livewire\Sale;

use App\Models\Sale;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Index extends Component
{

    use LivewireAlert;

    public $start_date, $end_date, $warehouse_id;

    protected $listeners = ['refreshSaleIndex' => '$refresh'];

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');

        $user = auth()->user();
        if ($user->is_all_warehouses) {
            $this->warehouse_id = null;
        } else {
            $this->warehouse_id = $user->warehouses->first()->id;
        }

    }


    public function render()
    {

        $sales = Sale::whereBetween('date', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->when($this->warehouse_id, function ($query, $warehouse_id) {
                return $query->where('warehouse_id', $warehouse_id);
            })
        ->get();


        return view('livewire.sale.index', compact('sales'));
    }
}
