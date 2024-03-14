@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'ОДДС'">
    </x-breadcrumb>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="row g-3">
                                <div class="col-12 col-md-3">
                                    <label for="start_date">Дата начала</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ $start_date }}">
                                </div>
                                <div class="col-12 col-md-3">
                                    <label for="end_date">Дата окончания</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ $end_date }}">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-filter"></i> Фильтр</button>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <x-charts.column :data="$data" :labels="$labels" :title="'Расходы'" />
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Общий доход</th>
                                <th>{{ nf($expenses->sum('amount')) }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_category->name }}</td>
                                    <td>{{ nf($expense->amount) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
