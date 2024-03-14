@extends('layouts.main')
@push('css')
<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Создать рулон'">
    <a href="{{ route('rolls.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::open(['route' => 'rolls.store', 'method' => 'POST', 'class' => 'row']) }}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-12">
                    <div class="row g-2">
                        <div class="col-md-3">
                            {{ Form::label('size', 'Формат рулона (см)') }}
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
                    {{ Form::submit('Создать', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}

    <div class="col-12">
        @livewire('roll.index')
    </div>
</div>

@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#user_id').select2({
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
