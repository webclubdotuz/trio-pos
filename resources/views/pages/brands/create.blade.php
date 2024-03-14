@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Создание бренда'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('brands.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('brands.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6 form-group">
                        <label for="name">Название</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="image">Фото</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
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
