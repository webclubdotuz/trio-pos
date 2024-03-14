@extends('layouts.main')
@push('css')
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Расходы продуктов'">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::open(['route' => 'product-costs.store', 'method' => 'POST', 'class' => 'row']) }}
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-6">
                            {{ Form::label('product_id', 'Продукт', ['class' => 'form-label']) }}
                            <select name="product_id" id="product_id" class="form-control" required>
                                <option value="">Выберите продукт</option>
                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ nf($product->quantity) }} {{ $product->unit }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('quantity', 'Количество', ['class' => 'form-label']) }}
                            {{ Form::number('quantity', null, ['class' => 'form-control', 'required', 'placeholder' => 'Количество']) }}
                        </div>
                        <div class="col-md-12">
                            {{ Form::label('description', 'Описание', ['class' => 'form-label']) }}
                            {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) }}
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {{ Form::submit('Создать', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <p>
                            Последние расходы продуктов
                        </p>
                    </div>
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Продукт</th>
                                    <th>Кол-во</th>
                                    <th>Описание</th>
                                    <th>Дата</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productCosts as $product_cost)
                                    <tr>
                                        <td>{{ $product_cost->id }}</td>
                                        <td>{{ $product_cost->product->name }}</td>
                                        <td>{{ nf($product_cost->quantity) }} {{ $product_cost->product->unit }}</td>
                                        <td>{{ $product_cost->description }}</td>
                                        <td>{{ df($product_cost->created_at) }}</td>
                                        <td>
                                            {{ Form::open(['route' => ['product-costs.destroy', $product_cost->id], 'method' => 'delete', 'class' => 'btn-group']) }}
                                            <a href="{{ route('product-costs.edit', $product_cost->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            {{ Form::button('<i class="bx bx-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger']) }}

                                            {{ Form::close() }}

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

@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: 'Выберите продукт',
            allowClear: true,
            language: {
                noResults: function() {
                    return 'Ничего не найдено';
                },
            },
        });
    });
</script>
@endpush
