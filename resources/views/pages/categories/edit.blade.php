@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Редактирование ' . $category->name">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('categories.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('categories.update', $category->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="col-md-12 form-group">
                        <label for="name">Название</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $category->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" class="form-control" required>{{ old('description', $category->description) }}</textarea>
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
