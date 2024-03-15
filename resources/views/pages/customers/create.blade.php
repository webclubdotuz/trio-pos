@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Создание клиента'">
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
                        <input type="text" name="first_name" id="first_name" class="form-control" required>
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="last_name">Фамилия</label>
                        <input type="text" name="last_name" id="last_name" class="form-control">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="middle_name">Отчество</label>
                        <input type="text" name="middle_name" id="middle_name" class="form-control">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="passport">Паспорт</label>
                        <input type="text" name="passport" id="passport" class="form-control" placeholder="KA1234567" pattern="[A-Z]{2}[0-9]{7}">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="passport_date">Дата выдачи</label>
                        <input type="date" name="passport_date" id="passport_date" class="form-control">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="passport_by">Кем выдан</label>
                        <input type="text" name="passport_by" id="passport_by" class="form-control">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="phone">Телефон</label>
                        <div class="input-group">
                            <span class="input-group-text">+998</span>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="934879598" pattern="[0-9]{9}">
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="find_id">Как узнали о нас</label>
                        <select name="find_id" id="find_id" class="form-select" required>
                            <option value="">Выберите</option>
                            @foreach (getFinds() as $find)
                                <option value="{{ $find->id }}">{{ $find->name }}</option>
                            @endforeach
                        </select>
                        @error('find_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="address">Адрес</label>
                                <textarea name="address" id="address" class="form-control"></textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="description">Описание</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
