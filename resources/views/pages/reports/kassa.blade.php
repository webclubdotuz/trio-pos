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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <?php
                                            $tolal = 0;
                                            $thisTotal = 0;
                                            $expenseTotal = 0;
                                            $comingTotal = 0;
                                        ?>
                                        @foreach (getPaymentMethods() as $payment_method)
                                            <tr class="text-center" style="background-color: #f1f1f1;">
                                                <td>
                                                    {{ $payment_method->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Дата</th>
                                                                <th>Описание</th>
                                                                <th>Приход</th>
                                                                <th>Расход</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($payment_method->sale_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']) as $sale_payment)
                                                                <tr>
                                                                    <td>{{ $sale_payment->date }}</td>
                                                                    <td>{{ $sale_payment->sale->customer->full_name }}</td>
                                                                    <td>{{ nf($sale_payment->amount) }}</td>
                                                                    <td></td>
                                                                </tr>
                                                            @endforeach
                                                            @foreach ($payment_method->expenses->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']) as $expense)
                                                                <tr>
                                                                    <td>{{ $expense->created_at }}</td>
                                                                    <td>{{ $expense->description }}</td>
                                                                    <td></td>
                                                                    <td>{{ nf($expense->amount) }}</td>
                                                                </tr>
                                                            @endforeach
                                                            @foreach ($payment_method->purchase_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']) as $purchase_payment)
                                                                <tr>
                                                                    <td>{{ $purchase_payment->created_at }}</td>
                                                                    <td>{{ $purchase_payment->purchase->supplier->full_name }}</td>
                                                                    <td></td>
                                                                    <td>{{ nf($purchase_payment->amount) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr style="background-color: #f1f1f1;">
                                                                <td>Итого</td>
                                                                <td></td>
                                                                <td>{{ nf($payment_method->sale_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount')) }}</td>
                                                                <td>{{ nf($payment_method->expenses->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount') + $payment_method->purchase_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount')) }}</td>
                                                            </tr>
                                                            <tr style="font-weight: bold;">
                                                                <td>Остаток</td>
                                                                <td></td>
                                                                <td></td>
                                                                <?php
                                                                $expenseTotal += $payment_method->expenses->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount') + $payment_method->purchase_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount');
                                                                $comingTotal += $payment_method->sale_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount');
                                                                $thisTotal = $payment_method->sale_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount') - ($payment_method->expenses->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount') + $payment_method->purchase_payments->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])->sum('amount'));
                                                                $tolal += $thisTotal;

                                                                ?>
                                                                <td>{{ nf($thisTotal) }}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </td>
                                        @endforeach

                                        <tr class="fw-bold">
                                            <td>
                                                Итого
                                            </td>
                                        </tr>
                                        <tr class="fw-bold">
                                            <td>
                                                Общий остаток: {{ nf($tolal) }} <br>
                                                Приход: {{ nf($comingTotal) }} <br>
                                                Расход: {{ nf($expenseTotal) }}
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
