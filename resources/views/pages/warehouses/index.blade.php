@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Склады'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('warehouses.create') }}">
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
                                    <th>Телефон</th>
                                    <th>Адрес</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                <tr>
                                    <td>{{ $warehouse->id }}</td>
                                    <td>{{ $warehouse->name }}</td>
                                    <td>{{ $warehouse->phone }}</td>
                                    <td>{{ $warehouse->address }}</td>
                                    <td>
                                        <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-info btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if (hasRoles())
                                        <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="post" class="d-inline">
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
@endsection

@push('js')

@endpush
