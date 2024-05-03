@extends('layouts.main')
@section('content')
    <x-breadcrumb :title="'Главная'">
        <form action="" method="get">
            <div class="input-group">
                <input type="date" class="form-control form-control-sm" name="start_date" value="{{ $start_date }}" placeholder="Начальная дата" onchange="this.form.submit()">
                <input type="date" class="form-control form-control-sm" name="end_date" value="{{ $end_date }}" placeholder="Конечная дата" onchange="this.form.submit()">
                <select name="warehouse_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Все склады</option>
                    @foreach(getWarehouses() as $warehouse)
                        <option value="{{ $warehouse->id }}" {{ request('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </x-breadcrumb>
    <div class="row">
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Клиенты'" :icon="'bx bx-users'" :value="getCustomers()->count()" :route="route('customers.index')" />
        </div>
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Долги без рассрочек'" :icon="'bx bx-money'"  :value="nf($debt)" :route="route('sales.index')" />
        </div>
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Просроченные оплаты рассрочек'" :icon="'bx bx-money'"  :value="nf($installmet_debt)" :route="route('reports.installment-report-debt')" />
        </div>
        @if (hasRoles(['admin', 'manager']))
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Долг от поставщиков'" :icon="'bx bx-money'"  :value="'$' . nf($purchase_debt)" :route="route('purchases.index')" />
        </div>
        @endif
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Количество продаж'" :icon="'bx bx-line-chart'"  :value="nf($sales_count)" :route="route('sales.index')" />
        </div>
        <div class="col-md-4">
            <x-widgets.static-widget :title="'Сумма продаж'" :icon="'bx bx-money'"  :value="nf($sales_total)" :route="route('sales.index')" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <x-charts.line-chart :title="'Динамика продажи'" :id="'sales-chart'" :labels="$labels" :data="$datas" />
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">План продавцов</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            @foreach($user_plans as $user_plan)
                                <tr>
                                    <td rowspan="2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $user_plan->fullname }}</td>
                                    <td>{{ nf($user_plan->plan) }}</td>
                                    <td>{{ nf($user_plan->getSaleSumma(date('Y', strtotime($start_date)), date('m', strtotime($start_date)), request('warehouse_id'))) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $user_plan->getSaleSumma(date('Y', strtotime($start_date)), date('m', strtotime($start_date)), request('warehouse_id')) / $user_plan->plan * 100 }}%" aria-valuenow="{{ $user_plan->getSaleSumma(date('Y', strtotime($start_date)), date('m', strtotime($start_date)), request('warehouse_id')) / $user_plan->plan * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12">
                        <p class="text-end">
                            <a href="{{ route('reports.product-report-sale') }}">Подробнее <i class="bx bx-arrow-to-right"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Платежи</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            @foreach($sale_payments as $sale_payment)
                                <tr>
                                    <td>{{ $sale_payment->payment_method->name }}</td>
                                    <td>{{ nf($sale_payment->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Топ продавцы</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            @foreach($sale_users as $sale_user)
                                <tr>
                                    <td>{{ $sale_user->user->fullname }}</td>
                                    <td>{{ nf($sale_user->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Топ товары</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            @foreach($top_products as $top_product)
                                <tr>
                                    <td><a href="{{ route('products.show', $top_product->product_id) }}">{{ $top_product->product->name }}</a></td>
                                    <td>{{ nf($top_product->quantity) }}</td>
                                    <td>{{ nf($top_product->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12">
                        <p class="text-end">
                            <a href="{{ route('reports.product-report-sale') }}">Подробнее <i class="bx bx-arrow-to-right"></i></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
