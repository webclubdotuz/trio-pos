@extends('layouts.main')

@push('css')
    @include('plugins.select2')
@endpush

@section('content')
<x-breadcrumb :title="'Создание продукта'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('products.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form class="row g-2" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-4 form-group">
                        <label for="name">Название</label>
                        <input type="text" name="name" id="name" class="form-control" required autofocus value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="code">Код</label>
                        <div class="input-group">
                            <input type="number" name="code" id="code" class="form-control" required>
                            <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                        </div>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="unit">Единица измерения</label>
                        <select name="unit" id="unit" class="form-select select2" required>
                            <option value="шт">шт</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="in_price_usd">Цена закупки</label>
                        <div class="input-group">
                            <input type="text" name="in_price_usd" id="in_price_usd" class="form-control money" required value="{{ old('in_price_usd') }}">
                            <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                            <input type="text" name="in_price" id="in_price" class="form-control money" value="{{ old('in_price') }}">
                            <span class="input-group-text">UZS</i></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="price_usd">Цена продажи</label>
                        <div class="input-group">
                            <input type="text" name="price_usd" id="price_usd" class="form-control money" required value="{{ old('price_usd') }}">
                            <span class="input-group-text"><i class="bx bx-dollar"></i></span>
                            <input type="text" name="price" id="price" class="form-control money" value="{{ old('price') }}">
                            <span class="input-group-text">UZS</i></span>
                        </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="category_id">Категория</label>
                        <select name="category_id" id="category_id" class="form-select select2" required>
                            <option value="">Выберите категорию</option>
                            @foreach (getCategories() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="brand_id">Бренд</label>
                        <select name="brand_id" id="brand_id" class="form-select select2" required>
                            <option value="">Выберите бренд</option>
                            @foreach (getBrands() as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="day_sale">Количество продаж в день</label>
                        <input type="number" name="day_sale" id="day_sale" class="form-control" required value="{{ old('day_sale') }}" min="0">
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="alert_quantity">Оповещение о количестве</label>
                        <input type="number" name="alert_quantity" id="alert_quantity" class="form-control" required value="{{ old('alert_quantity') }}" min="0">
                    </div>


                    <div class="col-md-3 form-group">
                        <label for="image">Фото</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-12 form-group">
                        <label for="is_imei">
                            <input type="checkbox" name="is_imei" id="is_imei" value="1">
                            Товар с IMEI
                        </label>
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



<script>

    let currency = "{{ getCurrencyRate() }}";

    $('.money').on('input', function() {
        let value = $(this).val();
        let id = $(this).attr('id');
        let usd = id.includes('usd');

        console.log(usd, id);

        let result = usd ? value * currency : value / currency;
        let target = usd ? id.replace('_usd', '') : id + '_usd';

        console.log(result, target);
        $(`#${target}`).val(result);
    });

    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Выберите',
            theme: 'bootstrap4'
        });
    });

</script>

@endpush
