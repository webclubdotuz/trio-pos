<?php

namespace App\Livewire\Roll;

use App\Models\Roll;
use Livewire\Component;

class Index extends Component
{

    public $start_date, $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }



    public function render()
    {

        $rolls = Roll::orderBy('created_at', 'desc')->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])->get();

        return view('livewire.roll.index', compact('rolls'));
    }
}
