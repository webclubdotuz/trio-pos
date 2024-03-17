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
                    <th>Поставщик</th>
                    <th>Склад</th>
                    <th>Кол-во</th>
                    <th>Цена</th>
                    <th>Сумма $</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($purchase_items as $purchase_item)
                    <tr>
                        <td>
                            <a href="{{ route('purchases.show', $purchase_item->purchase->id) }}">
                                {{ $purchase_item->purchase->invoice_number }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('suppliers.show', $purchase_item->purchase->supplier->id) }}">{{ $purchase_item->purchase->supplier->full_name }}</a>
                        </td>
                        <td>{{ $purchase_item->warehouse->name }}</td>
                        <td>{{ nf($purchase_item->quantity) }}</td>
                        <td>${{ nf($purchase_item->price_usd) }} / {{ nf($purchase_item->price) }} uzs</td>
                        <td>{{ nf($purchase_item->total_usd) }}</td>
                        <td>{{ nf($purchase_item->total) }}</td>
                        <td>{{ df($purchase_item->purchase->date) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Нет данных</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td>Итого</td>
                    <td></td>
                    <td></td>
                    <td>{{ nf($purchase_items->sum('quantity')) }}</td>
                    <td></td>
                    <td>{{ nf($purchase_items->sum('total_usd')) }}</td>
                    <td>{{ nf($purchase_items->sum('total')) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@push('js')

@endpush
