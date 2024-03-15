<?php

namespace App\Livewire\User;

use App\Models\Transaction;
use Livewire\Component;
use App\Models\Purchase as PurchaseModel;

class Purchase extends Component
{
    public $user, $purchases;

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {
        $this->purchases = PurchaseModel::where('user_id', $this->user->id)
        ->whereBetween('date', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->orderBy('date', 'desc')
        ->get();

        return view('livewire.user.purchase');
    }
}
