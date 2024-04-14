@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Рассрочка на месяцы'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('installment-months.create') }}">
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
                                    <th>Месяц</th>
                                    <th>Процент %</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($installmentMonths as $installmentMonth)
                                <tr>
                                    <td>{{ $installmentMonth->month }}</td>
                                    <td>{{ $installmentMonth->percent }}%</td>
                                    <td>{{ $installmentMonth->description }}</td>
                                    <td>
                                        <a href="{{ route('installment-months.edit', $installmentMonth->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="{{ route('installment-months.show', $installmentMonth->id) }}" class="btn btn-info btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <form action="{{ route('installment-months.destroy', $installmentMonth->id) }}" method="post" class="d-inline">
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
