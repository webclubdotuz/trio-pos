@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Рассрочки отчет'" />
    <div class="row">

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form class="row g-3" method="GET">
                        <div class="col-md-4 form-group">
                            <label for="fact_debt_month_count">Количество месяцев</label>
                            <select class="form-select" id="fact_debt_month_count" name="fact_debt_month_count">
                                <option value="" @if (request('fact_debt_month_count') == '') selected @endif>Все</option>
                                @foreach ($fact_debt_month_counts as $fact_debt_month_count)
                                    <option value="{{ $fact_debt_month_count }}" @if (request('fact_debt_month_count') == $fact_debt_month_count) selected @endif>{{ $fact_debt_month_count }} месяцев</option>
                                @endforeach
                            </select>
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
                                        <th>Сумма</th>
                                        <th>Оплачено</th>
                                        <th>Общий долг</th>
                                        <th>Фактический долг</th>
                                        <th>Не оплачено</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales as $sale)
                                        <tr>
                                            <td>
                                                <a href="{{ route('sales.show', $sale->id) }}">
                                                    {{ $sale->invoice_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('customers.show', $sale->customer->id) }}">
                                                    {{ $sale->customer->full_name }}
                                                </a>
                                            </td>
                                            <td>{{ nf($sale->total) }}</td>
                                            <td>{{ nf($sale->paid) }}</td>
                                            <td>{{ nf($sale->debt) }}</td>
                                            <td>{{ nf($sale->fact_debt) }}</td>
                                            <td>{{ $sale->fact_debt_month_count }} мес.</td>
                                        </tr>
                                    @endforeach
                                </tbody>

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
