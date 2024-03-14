@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Редактирование поставщика'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('suppliers.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('suppliers.update', $supplier->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="col-md-4 form-group">
                        <label for="full_name">Имя</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required value="{{ old('full_name', $supplier->full_name) }}" autofocus>
                        @error('full_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="phone">Телефон</label>
                        <input type="text" name="phone" id="phone" class="form-control" required value="{{ old('phone', $supplier->phone) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $supplier->email) }}">
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="address">Адрес</label>
                        <textarea name="address" id="address" class="form-control">{{ old('address', $supplier->address) }}</textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
