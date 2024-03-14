@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h3 class="card-text">
                    Привет, {{ auth()->user()->fullname }}!
                </h3>
                <p>
                    Cегодня {{ nf(getSaleTotal(date('Y-m-d'), date('Y-m-d'))) }} сум продано!
                </p>
              </div>
            </div>
        </div>
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Долг клиентов'" :icon="'bx bx-money'" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-charts.line-chart :title="'Динамика продажи'" />
        </div>
    </div>


@endsection
