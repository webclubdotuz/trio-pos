@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="'Касса отчеты'">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($sale_payment_methods as $sale_payment_method)
                <div class="col-md-4 col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center">
                                <strong>{{ nf($sale_payment_method->amount) }}</strong>
                            </p>
                            <p class="text-center">
                                <strong>{{ $sale_payment_method->payment_method->name }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
