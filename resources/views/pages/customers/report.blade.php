@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Отчет по клиенту'">

</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ФИО</th>
                                <th>Телефон</th>
                                <th>Заказы</th>
                                <th>Cумма</th>
                                <th>Оплачено</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->full_name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>
                                    {{ $customer->sales->count() }}
                                </td>
                                <td>
                                    {{ nf($customer->sales->sum('total'), 2) }}
                                </td>
                                <td>
                                    {{ nf($customer->sales->sum('paid'), 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $customers->links() }}

                </div>
            </div>
        </div>
    </div>
</div>

@livewire('sale.sale-payment')
@endsection

@push('js')

@endpush
