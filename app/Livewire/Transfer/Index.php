<?php

namespace App\Livewire\Transfer;

use App\Models\Transfer;
use Livewire\Component;

class Index extends Component
{

    public $start_date, $end_date, $from_warehouse_id, $to_warehouse_id;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {

        $transfers = Transfer::whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->when($this->from_warehouse_id, function ($query, $from_warehouse_id) {
                return $query->where('from_warehouse_id', $from_warehouse_id);
            })
            ->when($this->to_warehouse_id, function ($query, $to_warehouse_id) {
                return $query->where('to_warehouse_id', $to_warehouse_id);
            })
            ->get();

        return view('livewire.transfer.index', compact('transfers'));
    }
}
