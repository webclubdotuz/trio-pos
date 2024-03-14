@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Редактирование ' . $brand->name">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('brands.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('brands.update', $brand->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="col-md-6 g-2">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">Название</label>
                                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $brand->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-12 form-group">
                                <label for="description">Описание</label>
                                <textarea name="description" id="description" class="form-control" required>{{ old('description', $brand->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row g-2">
                            <div class="col-md-12 form-group">
                                <label for="image">Фото</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" class="img-thumbnail" width="100">
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
