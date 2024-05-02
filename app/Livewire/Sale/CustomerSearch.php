<?php

namespace App\Livewire\Sale;

use Livewire\Component;

class CustomerSearch extends Component
{

    public $search = '';

    public function openModalCustomerSearch()
    {
        $this->dispatch('openModalCustomertSearch');
    }

    public function render()
    {

        // $customers = \App\Models\Customer::whereAny([
        //     'first_name',
        //     'last_name',
        //     'middle_name',
        //     'passport',
        //     'passport_date',
        //     'passport_by',
        //     'address',
        //     'phone',
        // ], 'LIKE', '%' . $this->search . '%')

        $customers = \App\Models\Customer::orWhere('phone', 'LIKE', '%' . $this->search . '%')
        ->orWhere('first_name', 'LIKE', '%' . $this->search . '%')
        ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
        ->orderBy('first_name')
        ->limit(10)->get();


        return view('livewire.sale.customer-search', compact('customers'));
    }
}
