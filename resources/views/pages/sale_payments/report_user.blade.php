@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Продажник отчет'" />
    <div class="row">

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" action="{{ route('reports.sale-report-user') }}" method="GET">
                        <div class="col-md-4 form-group">
                            <label for="start_date">Дата начала</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $start_date }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label for="end_date">Дата окончания</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $end_date }}">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Показать</button>
                        </div>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Продавец</th>
                                        <th>План</th>
                                        <th>Количество продаж</th>
                                        <th>Рассрочки</th>
                                        <th>Сумма продаж</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sales as $sale)
                                        <tr>
                                            <td>
                                                <a href="{{ route('users.show', $sale->user_id) }}">
                                                    {{ $sale->user->fullname }}
                                                </a>
                                            </td>
                                            <td>{{ nf($sale->user->plan) }}</td>
                                            <td>{{ $sale->count }}</td>
                                            <td>{{ nf($sale->installment_status) }}</td>
                                            <td>{{ nf($sale->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Нет данных</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Итого</th>
                                        <th></th>
                                        <th>{{ $sales->sum('count') }}</th>
                                        <th>{{ $sales->sum('installment_status') }}</th>
                                        <th>{{ nf($sales->sum('total')) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

@endpush
