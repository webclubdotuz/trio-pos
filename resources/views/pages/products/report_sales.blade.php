@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Продукт - Отчет по продажам'" />

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <form action="" method="get" class="row g-2">
                                <div class="col-md-3 form-group">
                                    <label for="start_date">Начальная дата</label>
                                    <input type="date" class="form-control form-control-sm" name="start_date" value="{{ $start_date }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="end_date">Конечная дата</label>
                                    <input type="date" class="form-control form-control-sm" name="end_date" value="{{ $end_date }}">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="warehouse_id">Склад</label>
                                    <select name="warehouse_id" class="form-select form-select-sm">
                                        <option value="">Все склады</option>
                                        @foreach (getWarehouses() as $warehouse)
                                            <option value="{{ $warehouse->id }}"
                                                {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                                {{ $warehouse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-sm">Фильтр</button>
                                    <a href="{{ route('reports.product-report-sale') }}" class="btn btn-danger btn-sm">Сбросить</a>
                                </div>
                            </form>
                        </div>
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Фото</th>
                                        <th>Товар</th>
                                        <th>Заказ</th>
                                        <th>Цена прихода</th>
                                        <th>Наценка</th>
                                        <th>Продано на</th>
                                        <th>Кол-во</th>
                                        <th>Сумма</th>
                                        <th>Прибыль</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sale_items as $sale_item)
                                        <tr>
                                            <td>
                                                <img src="{{ $sale_item->product->image_url }}"
                                                    alt="{{ $sale_item->product->name }}" class="img-thumbnail"
                                                    width="50">
                                            </td>
                                            <td>{{ $sale_item->product->name }}</td>
                                            <td>{{ $sale_item->sale->invoice_number }}</td>
                                            <td>{{ nf($sale_item->in_price) }}</td>
                                            <td>{{ nf($sale_item->markup) }}</td>
                                            <td>{{ nf($sale_item->price) }}</td>
                                            <td>{{ $sale_item->quantity }}</td>
                                            <td>{{ nf($sale_item->total) }}</td>
                                            <td>{{ nf($sale_item->profit) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">Нет данных</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-end">Итого:</td>
                                        <td>{{ nf($sale_items->sum('total')) }}</td>
                                        <td>{{ nf($sale_items->sum('profit')) }}</td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
