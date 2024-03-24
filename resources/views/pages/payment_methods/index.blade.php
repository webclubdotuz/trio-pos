@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Способы оплаты'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('payment-methods.create') }}">
        <i class="bx bx-plus"></i>Создать
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment_methods as $payment_method)
                                <tr>
                                    <td>{{ $payment_method->id }}</td>
                                    <td>{{ $payment_method->name }}</td>
                                    <td>{{ $payment_method->description }}</td>
                                    <td>
                                        <a href="{{ route('payment-methods.edit', $payment_method->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="{{ route('payment-methods.show', $payment_method->id) }}" class="btn btn-info btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <form action="{{ route('payment-methods.destroy', $payment_method->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
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

@endpush
