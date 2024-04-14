@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Рассрочка на месяцы создать'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('payment-methods.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('installment-months.store') }}" method="post">
                    @csrf
                    <div class="col-md-6 form-group">
                        <label for="month">Месяц</label>
                        <input type="number" name="month" id="month" class="form-control" required>
                        @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="percent">Процент %</label>
                        <input type="number" name="percent" id="percent" class="form-control" required>
                        @error('percent') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12 form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
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
