@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Редактирование'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('installment-months.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('installment-months.update', $installmentMonth->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="col-md-6 form-group">
                        <label for="month">Месяц</label>
                        <input type="number" name="month" id="month" class="form-control" required value="{{ $installmentMonth->month }}">
                        @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="percent">Процент %</label>
                        <input type="number" name="percent" id="percent" class="form-control" required value="{{ $installmentMonth->percent }}">
                        @error('percent') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12 form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" class="form-control">{{ $installmentMonth->description }}</textarea>
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

<script>
    $("#image").change(function() {
        console.log(this);
        let input = this;
        let url = URL.createObjectURL(input.files[0]);
        localStorage.setItem('image', url, input);
        $(input).closest('.form-group').find('img').attr('src', url);
    });
</script>

@endpush
