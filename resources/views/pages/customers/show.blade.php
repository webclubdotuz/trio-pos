@extends('layouts.main')

@section('content')
<x-breadcrumb :title="$customer->full_name">
    <!-- Button trigger modal -->
    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">
        <i class="bx bx-edit"></i>
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <td><b>ФИО</b></td>
                            <td>{{ $customer->full_name }}</td>
                            <td><b>Телефон</b></td>
                            <td><a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Адрес</b></td>
                            <td>{{ $customer->address }}</td>
                            <td><a href="{{ route('customers.edit', $customer->id) }}"><i class="bx bx-edit font-size-16 align-middle mr-2"></i> Редактировать</a></td>
                        </tr>
                        <tr>
                            <td>
                                Баланс клиент: {{ nf($customer->balance) }} <br>
                            </td>
                            <td>
                                <p>
                                    {{ $customer->passport }} <br>
                                    {{ $customer->passport_by }} <br>
                                    {{ $customer->passport_date }} <br>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <x-tab.nav>
                    <x-tab.li :id="'sales'" :title="'Заказы'" :icon="'bx bx-cart'"/>
                </x-tab.nav>

                <div class="tab-content py-3">
                    <x-tab.content :id="'sales'">
                        @livewire('customer.sale-list', ['customer_id' => $customer->id])
                    </x-tab.content>
                </div>
            </div>
        </div>
    </div>
</div>

@livewire('sale.sale-payment')
@endsection

@push('js')

@endpush
