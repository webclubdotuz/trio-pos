@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Источники'">
        <a type="button" class="btn btn-primary btn-sm" href="{{ route('finds.create') }}">
            <i class="bx bx-plus"></i>Создать
        </a>
    </x-breadcrumb>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <p>
                            Просроченные задачи
                        </p>
                        <div class="col-12">
                            @forelse ($yesterday_tasks as $task)
                                <div class="border m-1 p-1">
                                    <b>{{ $loop->iteration }}.</b> <br>
                                    <b>Задача:</b> {{ $task->task }} <br>
                                    <b>Долг:</b> {{ nf($task->installment->debt) }}
                                    @if ($task->installment->debt == 0)
                                        <span class="badge bg-success">Оплачено</span>
                                    @endif
                                    <br>
                                    <b>Дата:</b> {{ df($task->date) }}
                                </div>
                            @empty
                                <span>Нет задач</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <p>
                            Задачи на сегодня
                        </p>
                        <div class="col-12">
                            @forelse ($today_tasks as $task)
                                <div class="border m-1 p-1">
                                    <b>{{ $loop->iteration }}.</b> <br>
                                    <b>Задача:</b> {{ $task->task }} <br>
                                    <b>Долг:</b> {{ nf($task->installment->debt) }}
                                    @if ($task->installment->debt == 0)
                                        <span class="badge bg-success">Оплачено</span>
                                    @endif
                                    <br>
                                    <b>Дата:</b> {{ df($task->date) }}
                                </div>
                            @empty
                                <span>Нет задач</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <p>
                            Задачи на завтра
                        </p>
                        <div class="col-12">
                            @forelse ($tomorrow_tasks as $task)
                                <div class="border m-1 p-1">
                                    <b>{{ $loop->iteration }}.</b> <br>
                                    <b>Задача:</b> {{ $task->task }} <br>
                                    <b>Долг:</b> {{ nf($task->installment->debt) }}
                                    @if ($task->installment->debt == 0)
                                        <span class="badge bg-success">Оплачено</span>
                                    @endif
                                    <br>
                                    <b>Дата:</b> {{ df($task->date) }}
                                </div>
                            @empty
                                <span>Нет задач</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js')
@endpush
