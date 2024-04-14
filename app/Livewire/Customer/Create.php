<?php

namespace App\Livewire\Customer;

use App\Models\Customer;
use Livewire\Component;

class Create extends Component
{

    public $first_name, $last_name, $middle_name, $passport, $passport_date, $passport_by, $address, $phone, $find_id, $description;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'passport' => 'nullable|string|required_with:passport_date|regex:/^[A-Z]{2}[0-9]{7}$/',
        'passport_date' => 'nullable|date',
        'passport_by' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|integer|regex:/^[0-9]{9}$/',
        'find_id' => 'required|integer|exists:finds,id',
        'description' => 'nullable|string',
    ];

    public function store()
    {
        $this->validate();

        $customer = Customer::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'passport' => $this->passport,
            'passport_date' => $this->passport_date,
            'passport_by' => $this->passport_by,
            'address' => $this->address,
            'phone' => $this->phone,
            'find_id' => $this->find_id,
            'description' => $this->description,
        ]);

        $this->reset();
        $this->dispatch('closeModal', ['id' => $customer->id]);
    }


    public function render()
    {
        return view('livewire.customer.create');
    }
}
