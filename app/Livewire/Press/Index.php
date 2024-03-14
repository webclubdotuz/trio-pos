<?php

namespace App\Livewire\Press;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Index extends Component
{

    use LivewireAlert;
    protected $listeners = ['refreshPress' => '$refresh'];

    public function destroy($id)
    {
        $press = \App\Models\Press::find($id);

        if ($press?->saleItems()->count() > 0)
        {
            $this->alert('error', 'Невозможно удалить пресс, так как он участвует в транзакции!');
            return;
        }

        if ($press->image)
        {
            try {
                unlink(public_path('storage/' . $press->image));
            } catch (\Exception $e) {
                //
            }
        }

        $press->delete();

        $this->alert('success', 'Пресс успешно удален!');

        $this->dispatch('refreshPressCreate');
    }

    public function render()
    {

        $presses = \App\Models\Press::orderBy('created_at', 'desc')->paginate(50);

        return view('livewire.press.index', compact('presses'));
    }
}
