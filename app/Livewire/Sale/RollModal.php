<?php

namespace App\Livewire\Sale;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RollModal extends Component
{

    use LivewireAlert;

    public $rolls = [];
    public $roll_id;

    public $search = [];

    protected $listeners = [
        'openRollModal' => 'open',
        'closeRollModal' => 'close',
    ];

    public function open()
    {
        $this->rolls = $rolls = \App\Models\Roll::noSales()->get();
        $this->dispatch('openRoll');
    }

    public function close()
    {
        $this->dispatch('closeRoll');
        $this->dispatch('refreshSaleCreate');
    }

    public function selectRoll($roll_id)
    {
        $this->roll_id = $roll_id;

        $transaction = \App\Models\Transaction::where('type', 'sale')->where('status', 'pending')->first();

        if (!$transaction) {
            $transaction = \App\Models\Transaction::create([
                'contact_id' => 1,
                'type' => 'sale',
                'status' => 'pending',
                'user_id' => auth()->user()->id,
            ]);
        }

        $sale = \App\Models\Sale::where('transaction_id', $transaction->id)->where('roll_id', $roll_id)->first();

        if ($sale) {
            $this->alert('error', 'Такой рулон уже есть в списке');
        }else{
            $sale = \App\Models\Sale::create([
                'transaction_id' => $transaction->id,
                'roll_id' => $roll_id,
                'user_id' => auth()->user()->id,
                'price' => 0,
                'total' => 0,
            ]);
        }
        $this->close();
    }

    public function searchRolls()
    {

        $this->search['size'] = $this->search['size'] ?? '';
        $this->search['weight'] = $this->search['weight'] ?? '';
        $this->search['paper_weight'] = $this->search['paper_weight'] ?? '';
        $this->search['glue'] = $this->search['glue'] ?? '';

        $this->rolls = $rolls = \App\Models\Roll::noSales()
            ->where('size', 'like', '%' . $this->search['size'] . '%')
            ->where('weight', 'like', '%' . $this->search['weight'] . '%')
            ->where('paper_weight', 'like', '%' . $this->search['paper_weight'] . '%')
            ->where('glue', 'like', '%' . $this->search['glue'] . '%')
            ->get();

    }

    public function render()
    {
        return view('livewire.sale.roll-modal');
    }
}
