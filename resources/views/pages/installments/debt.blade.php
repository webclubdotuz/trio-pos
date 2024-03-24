@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Рассрочки отчет'" />
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" method="GET">
                        <div class="col-md-4 form-group">
                            <label for="full_name">ФИО</label>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Показать</button>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        {{-- Сумма	Оплачено	Общий долг	Фактический долг	Не оплачено --}}
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>INV</th>
                                        <th>Клиент</th>
                                        <th>Тел</th>
                                        <th>Сумма</th>
                                        <th>Долг</th>
                                        <th>Расс. Дата</th>
                                        <th>Задача</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($installments as $installment)
                                        <tr>
                                            <td>
                                                <a href="{{ route('sales.show',  $installment->sale->id) }}">
                                                    {{ $installment->sale->invoice_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('customers.show',  $installment->sale->customer->id) }}">
                                                    {{ $installment->sale->customer->full_name }}
                                                </a>
                                            </td>
                                            <td>{{ $installment->sale->customer->phone }}
                                            <td>{{ nf($installment->amount) }}</td>
                                            <td>{{ nf($installment->debt) }}</td>
                                            <td>{{ df($installment->date) }}</td>
                                            <td>
                                                @forelse ($installment->tasks as $task)
                                                    <div class="border-bottom">
                                                        <span>{{ df($task->date) }}</span>
                                                        <span>{{ $task->task }}</span>
                                                    </div>
                                                @empty
                                                    <span>Нет задач</span>
                                                @endforelse
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" onclick="showTaskForm({{ $installment->id }}, {{ $installment->sale->customer->id }}, '{{ $installment->sale->invoice_number }}')">
                                                    <i class="bx bx-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>

                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="task_add" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Задача на <span id="invoice_number"></span></h5>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tasks.store') }}" method="post" id="task_form">
                        @csrf
                        <div class="form-group">
                            <label for="task">Задача</label>
                            <textarea name="task" id="task" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Дата</label>
                            <input type="date" name="date" id="date" class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <input type="hidden" name="installment_id" id="installment_id">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="form-group mt-2">
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
        function showTaskForm(installment_id, customer_id,invoice_number)
        {
            $('#invoice_number').text(invoice_number);
            $('#installment_id').val(installment_id);
            $('#customer_id').val(customer_id);
            $('#task_add').modal('show');
        }

    </script>

@endpush
