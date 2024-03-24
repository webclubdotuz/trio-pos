@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Продукт - Отчет по продажам'" />

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Фото</th>
                                        <th>Продукт</th>
                                        <th>Кол-во</th>
                                        <th>Уведомления кол-ва</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                        <td><img src="{{ $product->image ? asset('storage/' . $product->image) : '/no-image.png' }}"
                                            alt="{{ $product->name }}" class="img-thumbnail" width="50"></td>
                                        <td><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></td>
                                        <td>{{ nf($product->quantity) }}</td>
                                        <td>{{ nf($product->alert_quantity) }}</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100" class="text-center">Нет данных</td>
                                        </tr>
                                    @endforelse
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
@endpush
