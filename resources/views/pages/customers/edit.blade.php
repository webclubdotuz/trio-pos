@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Редактирование клиента ' . $customer->full_name">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('customers.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('customers.store') }}" method="post">
                    @csrf

                    <div class="col-md-4 form-group">
                        <label for="first_name">Имя</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" required value="{{ old('first_name', $customer->first_name) }}">
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="last_name">Фамилия</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $customer->last_name) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="middle_name">Отчество</label>
                        <input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ old('middle_name', $customer->middle_name) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="passport">Паспорт</label>
                        <input type="text" name="passport" id="passport" class="form-control" placeholder="KA1234567" pattern="[A-Z]{2}[0-9]{7}" value="{{ old('passport', $customer->passport) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="passport_date">Дата выдачи</label>
                        <input type="date" name="passport_date" id="passport_date" class="form-control" value="{{ old('passport_date', $customer->passport_date) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="passport_by">Кем выдан</label>
                        <input type="text" name="passport_by" id="passport_by" class="form-control" value="{{ old('passport_by', $customer->passport_by) }}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="phone">Телефон</label>
                        <div class="input-group">
                            <span class="input-group-text">+998</span>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="934879598" pattern="[0-9]{9}" value="{{ old('phone', $customer->phone) }}">
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="address">Адрес</label>
                                <textarea name="address" id="address" class="form-control">{{ old('address', $customer->address) }}</textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="description">Описание</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $customer->description) }}</textarea>
                            </div>
                        </div>
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
