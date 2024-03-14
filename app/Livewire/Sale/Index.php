<?php

namespace App\Livewire\Sale;

use App\Models\Sale;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Index extends Component
{

    use LivewireAlert;

    public $start_date, $end_date;

    protected $listeners = ['refreshSaleIndex' => '$refresh'];

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }


    public function render()
    {

        $sales = Sale::whereBetween('date', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->get();


        return view('livewire.sale.index', compact('sales'));
    }
}
