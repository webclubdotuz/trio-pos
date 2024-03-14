@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Редактирование ' . $warehouse->name">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('warehouses.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('warehouses.update', $warehouse->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="col-md-6 form-group">
                        <label for="name">Название</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $warehouse->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="phone">Телефон</label>
                        <div class="input-group">
                            <span class="input-group-text">+998</span>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="934879598" pattern="[0-9]{9}" value="{{ old('phone', $warehouse->phone) }}">
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 form-group">
                        <label for="address">Адрес</label>
                        <textarea name="address" id="address" class="form-control">{{ old('address', $warehouse->address) }}</textarea>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
