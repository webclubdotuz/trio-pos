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
            {{-- <div class="col-md-4">
                <label for="product_id">Товар</label>
                <select class="form-select" id="product_id" wire:model.live="product_id">
                    <option value="">Выберите товар</option>
                    @foreach(getNoShopProducts() as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>
    </div>
    <div class="col-12 table-responsive">
		<table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th>INV</th>
                    <th>Дата</th>
                    <th>Поставщик</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                <tr>
                        <td>
                            {{ view('pages.purchases.actions', ['purchase' => $purchase]) }}
                        </td>
                        <td>{{ $purchase->invoice_number }}</td>
                        <td>{{ df($purchase->date) }}</td>
                        <td>{{ $purchase->supplier->full_name }}</td>
                        <td>{{ nf($purchase->total) }}</td>
                        <td>{!! $purchase->status_html !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
	</div>
</div>

@push('js')

@endpush
