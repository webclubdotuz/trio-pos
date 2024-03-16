<div class="row g-2">
    <div class="col-12">
        <div class="row g-2">
            <div class="col-6">
                <label for="start_date">Начало периода</label>
                <input type="date" class="form-control" id="start_date" wire:model.live="start_date">
            </div>
            <div class="col-6">
                <label for="end_date">Конец периода</label>
                <input type="date" class="form-control" id="end_date" wire:model.live="end_date">
            </div>
        </div>
    </div>
    <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered" id="table">
            <thead>
                <tr>
                    <th></th>
                    <th>INV</th>
                    <th>Клиент</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Оплата</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>
                            @include('pages.sales.actions', ['sales' => $sales])
                        </td>
                        <td>{{ $sale->invoice_number }}</td>
                        <td>
                            <a href="{{ route('customers.show', $sale->customer->id) }}">{{ $sale->customer->fullname }}</a>
                        </td>
                        <td>{{ nf($sale->total, 2) }} {{ $sale->debt_info }}</td>
                        <td>
                            {!! $sale->status_html !!}
                        </td>
                        <td>
                            {!! nf($sale->paid) !!}
                        </td>
                        <td>{{ df($sale->created_at, 'd.m.Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>Итого</td>
                    <td></td>
                    <td></td>
                    <td>{{ nf($sales->sum('total')) }}</td>
                    <td>{{ nf($sales->sum('debt')) }}</td>
                    <td>{{ nf($sales->sum('paid')) }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@push('js')

@endpush
