<?php

namespace App\Livewire\Press;

use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, LivewireAlert;

    public $product_id;
    public $quantity;
    public $image;

    public $user_ids = [];

    protected $listeners = ['refreshPressCreate' => '$refresh'];

    protected $rules = [
        'product_id' => 'required',
        'quantity' => 'required|numeric|min:1',
        'image' => 'image|max:5024|nullable',
        'user_ids' => 'required|array|min:1,max:2',
    ];


    public function store()
    {

        $this->validate();

        $product = \App\Models\Product::find($this->product_id);

        if ($product->quantity < $this->quantity) {
            $this->alert('error', 'Недостаточно товара на складе!');
            $this->dispatch('initSelect2');
            return;
        }

        DB::beginTransaction();

        try {

            $press = new \App\Models\Press();
            $press->user_id = auth()->user()->id;
            $press->product_id = $this->product_id;
            $press->quantity = $this->quantity;
            if ($this->image) {
                $press->image = $this->image->store('press', 'public');
            }
            $press->save();

            foreach ($this->user_ids as $user_id) {
                $pressUser = new \App\Models\PressUser();
                $pressUser->press_id = $press->id;
                $pressUser->user_id = $user_id;
                $pressUser->admin_id = auth()->user()->id;
                $pressUser->amount = 15000 / count($this->user_ids);
                $pressUser->save();
            }

            $product = \App\Models\Product::find($this->product_id);
            $product->quantity = $product->quantity - $this->quantity;
            $product->save();

            $this->alert('success', 'Пресс успешно добавлен!');
            $this->reset();
            $this->dispatch('refreshPress');
            $this->dispatch('initSelect2');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            $this->alert('error', 'Ошибка при добавлении пресса!');
            $this->dispatch('initSelect2');
            return;
        }

    }

    public function render()
    {
        $products = \App\Models\Product::orderBy('name')->get();

        $this->dispatch('initSelect2');

        return view('livewire.press.create', compact('products'));
    }
}
