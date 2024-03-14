@extends('layouts.main')
@push('css')
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Редактировать рулон'">
    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::model($roll, ['route' => ['rolls.update', $roll->id], 'method' => 'PUT', 'class' => 'row']) }}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-3">
                            {{ Form::label('size', 'Формат рулона (метр)') }}
                            {{ Form::number('size', null, ['class' => 'form-control', 'placeholder' => 'Формат рулона', 'required', 'step' => 'any']) }}
                        </div>
                        <div class="col-md-3">
                            {{ Form::label('paper_weight', 'Плотность (гр)') }}
                            {{ Form::number('paper_weight', null, ['class' => 'form-control', 'placeholder' => 'Плотность', 'required', 'step' => 'any']) }}
                        </div>
                        <div class="col-md-3">
                            {{ Form::label('weight', 'Вес рулона (кг)') }}
                            {{ Form::number('weight', null, ['class' => 'form-control', 'placeholder' => 'Вес рулона', 'required', 'step' => 'any']) }}
                        </div>
                        <div class="col-md-3">
                            {{ Form::label('glue', 'Клей') }}
                            {{ Form::select('glue', ['1' => 'Есть', '0' => 'Нет'], null, ['class' => 'form-control', 'placeholder' => 'Клей', 'required']) }}
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p>
                        <strong>Дата создания:</strong>
                        {{ $roll->created_at->format('d.m.Y') }}
                    </p>
                </div>
                <div class="col-12">
                    {{ Form::submit('Изменить', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>

@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Выберите продукт',
            allowClear: true,
            language: {
                noResults: function() {
                    return 'Ничего не найдено';
                },
            },
        });
    });
</script>
@endpush
