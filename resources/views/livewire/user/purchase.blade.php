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
					<th>ID</th>
					<th>Поставщик</th>
					<th>Товары</th>
					<th>Сумма</th>
					<th>Стаус</th>
					<th>Дата</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($purchases as $purchase)
					<tr>
						<td>{{ $purchase->id }}</td>
						<td>
                            <a href="{{ route('suppliers.show', $purchase->supplier->id) }}">{{ $purchase->supplier->fullname }}</a>
                        </td>
						<td>
                            @foreach ($purchase->purchase_items as $purchase_item)
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{ $purchase_item->product->name }}
                                    </div>
                                    <div>
                                        <a data-bs-toggle="dropdown" class="text-primary">
                                            {{ nf($purchase_item->quantity, 2) }} кг
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </td>
						<td>{{ nf($purchase->total, 2) }} {{ $purchase->debt_info }}</td>
                        <td>
                            {!! $purchase->payment_status_html !!}
                        </td>
						<td>{{ df($purchase->created_at, 'd.m.Y H:i') }}</td>
                        <td>
                            @if(hasRoles() || $purchase->user_id == $user->id)
                            <div class="dropdown open">
                                <button class="btn bt-sm btn-primary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </button>
                                <div class="dropdown-menu" style="position: relative;">
                                    @if ($purchase->debt)
                                        <button type="button" class="m-2 btn-block btn btn-primary btn-sm"
                                            wire:click="$dispatch('openModal', { purchase_id: {{ $purchase->id }} })">
                                            <i class="bx bx-money"></i>[Оплатить]
                                        </button>
                                    @endif
                                    <button type="button" class="m-2 btn-block btn btn-sm btn-danger"
                                        wire:click="delete({{ $purchase->id }})" wire:confirm="Вы уверены?">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button" class="m-2 btn-block btn btn-success btn-sm"
                                        wire:click="$dispatch('openModalpurchaseshow', { purchase_id: {{ $purchase->id }} })">
                                        <i class="bx bx-show"></i>[Показать]
                                    </button>
                                </div>
                            </div>
                            @endif
                        </td>
					</tr>
				@endforeach
			</tbody>
            <tfoot></tfoot>
		</table>
	</div>
</div>

@push('js')
	<script>
        Livewire.on('supplierCloseModal', () => {
            Livewire.dispatch('refreshsuppliers');
        });
	</script>
@endpush
