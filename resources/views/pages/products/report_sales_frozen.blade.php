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
                                    <label for="day">День</label>
                                    <select name="day" class="form-select form-select-sm">
                                        @foreach ($days as $key => $value)
                                            <option value="{{ $key }}" {{ $day == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
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
                                        <th>Последняя продажа</th>
                                        <th>Последний покупатель</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                        <td><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-thumbnail" width="50"></td>
                                        <td><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></td>
                                        <td>{{ $product->last_sale_day(request('warehouse_id')) }}</td>
                                        <td>{{ $product->last_purchase_day(request('warehouse_id')) }}</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">Нет данных</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end">Итого:</td>
                                        <td>{{ nf($products->sum('quantity')) }}</td>
                                        <td>{{ nf($products->sum('total')) }}</td>
                                    </tr>
                                </tfoot> --}}

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
