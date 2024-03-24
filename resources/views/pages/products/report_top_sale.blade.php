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
                                <div class="col-md-3 form-group">
                                    <label for="order_by">Сортировать по</label>
                                    <select name="order_by" class="form-select form-select-sm">
                                        <option value="total" {{ request('order_by') == 'total' ? 'selected' : '' }}>Сумма</option>
                                        <option value="quantity" {{ request('order_by') == 'quantity' ? 'selected' : '' }}>Кол-во</option>
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
                                        <th>Продукт</th>
                                        <th>Кол-во</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($top_products as $top_product)
                                    <tr>
                                        <td><img src="{{ $top_product->product->image_url }}" alt="{{ $top_product->product->name }}" class="img-thumbnail" width="50"></td>
                                        <td><a href="{{ route('products.show', $top_product->product_id) }}">{{ $top_product->product->name }}</a></td>
                                        <td>{{ nf($top_product->quantity) }}</td>
                                        <td>{{ nf($top_product->total) }}</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">Нет данных</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end">Итого:</td>
                                        <td>{{ nf($top_products->sum('quantity')) }}</td>
                                        <td>{{ nf($top_products->sum('total')) }}</td>
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
