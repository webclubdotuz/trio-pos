<?php

namespace App\Livewire\Customer;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;

class Index extends DataTableComponent
{
    protected $model = Customer::class;

    public function configure(): void
    {
        // table border
        $this->setPrimaryKey('id')->setTableAttributes(['class' => 'table-bordered table-hover']);
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->sortable(),
            Column::make("ФИО", 'id')
                ->format(function ($id) {
                    $customer = Customer::find($id);
                    return $customer->full_name;
                })->searchable()->sortable(),
            Column::make("Address", "address")->sortable()->searchable(),
            Column::make("Phone", "phone")->sortable()->searchable(),
            Column::make("Описание", "description")->sortable()->searchable(),
            Column::make("Действия", "id")->format(function ($id) {
                return view('pages.customers.actions', compact('id'));
            }),
        ];
    }
}
