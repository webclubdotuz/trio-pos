<div class="row g-2">
    <div class="col-12">
        <div class="row g-2">
            <div class="col-md-4">
                <label for="start_date">Начало периода</label>
                <input type="date" class="form-control" id="start_date" wire:model.live="start_date">
            </div>
            <div class="col-md-4">
                <label for="end_date">Конец периода</label>
                <input type="date" class="form-control" id="end_date" wire:model.live="end_date">
            </div>
            <div class="col-md-4">
                <label for="warehouse_id">Склад</label>
                <select class="form-select" id="warehouse_id" wire:model.live="warehouse_id">
                    <option value="">Все</option>
                    @foreach (getWarehouses() as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-12" wire:loading>
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered" id="table">
            <thead>
                <tr>
                    <th>Заказ</th>
                    <th>Клиент</th>
                    <th>Склад</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sale_items as $sale_item)
                    <tr>
                        <td>
                            <a href="{{ route('sales.show', $sale_item->sale->id) }}">
                                {{ $sale_item->sale->invoice_number }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $sale_item->sale->customer->id) }}">{{ $sale_item->sale->customer->fullname }}</a>
                        </td>
                        <td>{{ $sale_item->warehouse->name }}</td>
                        <td>{{ nf($sale_item->quantity) }}</td>
                        <td>{{ nf($sale_item->total) }}</td>
                        <td>{{ df($sale_item->sale->date) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Нет данных</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td>Итого</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ nf($sale_items->sum('total')) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@push('js')

@endpush
