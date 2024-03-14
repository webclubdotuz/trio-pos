@extends('layouts.main')

@section('content')
<x-breadcrumb :title="$supplier->full_name">
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm">
        <i class="bx bx-plus"></i>Создать
    </button>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr>
                            <td><b>ФИО</b></td>
                            <td>{{ $supplier->full_name }}</td>
                            <td><b>Телефон</b></td>
                            <td><a href="tel:{{ $supplier->phone }}">{{ $supplier->phone }}</a></td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Адрес</b></td>
                            <td>{{ $supplier->address }}</td>
                            <td><a href="{{ route('suppliers.edit', $supplier->id) }}"><i class="bx bx-edit font-size-16 align-middle mr-2"></i> Редактировать</a></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Баланс: {{ nf($supplier->supplier_balance) }}
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
                    <x-tab.li :id="'purchases'" :title="'Покупки'" :active="true" :icon="'bx bx-shopping-bag'"/>
                </x-tab.nav>

                <div class="tab-content py-3">
                    <x-tab.content :id="'purchases'" :active="true">
                        <livewire:supplier.purchase-list :supplier_id="$supplier->id" />
                    </x-tab.content>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')


@endpush
