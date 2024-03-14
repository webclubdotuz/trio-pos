@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Продукты'">
        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-plus"></i>
            Добавить
        </a>
    </x-breadcrumb>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Продукт</th>
                                <th>Кол-во</th>
                                <th>Описание</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productCosts as $product_cost)
                                <tr>
                                    <td>{{ $product_cost->id }}</td>
                                    <td>{{ $product_cost->product->name }}</td>
                                    <td>{{ nf($product_cost->quantity) }} {{ $product_cost->unit }}</td>
                                    <td>{{ $product_cost->description }}</td>
                                    <td>
                                        {{ Form::open(['route' => ['product-costs.destroy', $product_cost->id], 'method' => 'delete', 'class' => 'btn-group']) }}
                                        <a href="{{ route('product-costs.show', $product_cost->id) }}" class="btn btn-sm btn-success">
                                            <i class="bx bx-show"></i>
                                        </a>
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
@endsection
