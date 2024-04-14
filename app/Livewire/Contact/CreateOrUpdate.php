<?php

namespace App\Livewire\Contact;

use Livewire\Component;

class CreateOrUpdate extends Component
{

    public $id;
    public $fullname;
    public $phone;
    public $type;
    public $address;
    public $method;

    protected $listeners = ['Create',];

    protected $rules = [
        'fullname' => 'required|min:3',
        'phone' => 'required|digits:9',
        'type' => 'required',
        'address' => 'nullable',
    ];



    public function StoreOrUpdate()
    {
        $this->validate();




        $this->reset();
        $this->dispatch('contactCloseModal');
    }

    public function render()
    {
        return view('livewire.contact.create-or-update');
    }
}
