@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Продукты'">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filter">
            <i class="bx bx-filter"></i>Фильтр
        </button>
        <a type="button" class="btn btn-success btn-sm" href="{{ route('products.create') }}">
            <i class="bx bx-plus"></i>Создать
        </a>
    </div>
</x-breadcrumb>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <p>
                            @if (request()->all())
                                <h6>Фильтры:</h6>

                                @if (request('name'))
                                    Название: {{ request('name') }} |
                                @endif

                                @if (request('warehouse_id'))
                                    Склад: {{ getWarehouse(request('warehouse_id'))->name }} <br>
                                @endif
                                @if (request('in_stock'))
                                    В наличии <br>
                                @endif

                                <a href="{{ route('products.index') }}" class="text-danger">Сбросить фильтры <i class="bx bx-x"></i></a>
                            @endif
                        </p>
                    </div>
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Фото</th>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Кол-во</th>
                                    <th>Цена</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)

                                @if (request('in_stock') && $product->quantity( request('warehouse_id') ) == 0)
                                    @continue
                                @endif

                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-thumbnail" width="50">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        {{ $product->quantity( request('warehouse_id') ) }} {{ $product->unit }}
                                    </td>
                                    <td>{{ nf($product->price) }} сум</td>
                                    <td>
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if (hasRoles(['admin','manager']))
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Фильтр</h5>
                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="" method="get">
                <div class="row g-3">
                    <div class="col-12 form-group">
                        <label for="name">Название</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}">
                    </div>

                    <div class="col-12 form-group">
                        <label for="warehouse_id">Склад</label>
                        <select name="warehouse_id" id="warehouse_id" class="form-control">
                            <option value="">Выберите склад</option>
                            @foreach (getWarehouses() as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="in_stock">
                            <input type="checkbox" name="in_stock" id="in_stock" {{ request('in_stock') ? 'checked' : '' }}>
                            В наличии
                        </label>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Применить</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
