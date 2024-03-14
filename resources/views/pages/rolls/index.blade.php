@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Продукты'">
        <a href="{{ route('rolls.create') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-plus"></i>
            Добавить
        </a>
    </x-breadcrumb>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form class="row g-2">
                        <div class="col-4">
                            <label for="start_date">Начало периода</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $start_date }}">
                        </div>
                        <div class="col-4">
                            <label for="end_date">Конец периода</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $end_date }}">
                        </div>
                        <div class="col-4">
                            <label for="sale">Продано</label>
                            <select class="form-control" id="sale" name="sale">
                                <option value="">Все</option>
                                <option value="yes" {{ $sale == 'yes' ? 'selected' : '' }}>Да</option>
                                <option value="no" {{ $sale == 'no' ? 'selected' : '' }}>Нет</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm">Применить</button>
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <p>
                        <strong>Всего рулонов:</strong> {{ $rolls->count() }} <br>
                        <strong>Общий вес рулонов:</strong> {{ $rolls->sum('weight') }} кг <br>
                        <strong>Общий сумма продаж:</strong>
                        <?php
                            $total = 0;
                            foreach ($rolls as $roll) {
                                if ($roll->sale) {
                                    $total += $roll->sale->total;
                                }
                            }
                        ?>
                        {{ nf($total) }} сум
                    </p>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Формат рулона</th>
                                <th>Плотность</th>
                                <th>Вес рулона</th>
                                <th>Клей</th>
                                <th>Создан</th>
                                <th>Клиент</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rolls as $roll)
                                <tr>
                                    <td>{{ $roll->id }}</td>
                                    <td>{{ $roll->size }} см</td>
                                    <td>{{ $roll->paper_weight }} гр</td>
                                    <td>{{ $roll->weight }} кг</td>
                                    <td>{{ $roll->glue ? 'Есть' : 'Нет' }}</td>
                                    <td>{{ $roll->user->fullname }} ({{ df($roll->created_at, 'd.m.Y H:i') }})</td>
                                    <td>
                                        @if ($roll->sale)
                                        <a href="{{ route('contacts.show', $roll->sale->transaction->contact->id) }}">
                                            {{ $roll->sale?->transaction?->contact->fullname }} ({{ nf($roll->sale?->price) }} / {{ nf($roll->sale?->total) }})
                                        </a>
                                        @else
                                        <span class="text-danger">Не продан</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ Form::open(['route' => ['rolls.destroy', $roll->id], 'method' => 'delete']) }}
                                        {{ Form::button('<i class="bx bx-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-sm btn-danger']) }}

                                        {{ Form::close() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
