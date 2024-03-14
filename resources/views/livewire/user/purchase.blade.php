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
				@foreach ($transactions as $transaction)
					<tr>
						<td>{{ $transaction->id }}</td>
						<td>
                            <a href="{{ route('contacts.show', $transaction->contact->id) }}">{{ $transaction->contact->fullname }}</a>
                        </td>
						<td>
                            @foreach ($transaction->purchases as $purchase)
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{ $purchase->product->name }}
                                    </div>
                                    <div>
                                        <a data-bs-toggle="dropdown" class="text-primary">
                                            {{ nf($purchase->quantity, 2) }} кг
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </td>
						<td>{{ nf($transaction->total, 2) }} {{ $transaction->debt_info }}</td>
                        <td>
                            {!! $transaction->payment_status_html !!}
                        </td>
						<td>{{ df($transaction->created_at, 'd.m.Y H:i') }}</td>
                        <td>
                            @if(hasRoles() || $transaction->user_id == $user->id)
                            <div class="dropdown open">
                                <button class="btn bt-sm btn-primary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </button>
                                <div class="dropdown-menu" style="position: relative;">
                                    @if ($transaction->debt)
                                        <button type="button" class="m-2 btn-block btn btn-primary btn-sm"
                                            wire:click="$dispatch('openModal', { transaction_id: {{ $transaction->id }} })">
                                            <i class="bx bx-money"></i>[Оплатить]
                                        </button>
                                    @endif
                                    <button type="button" class="m-2 btn-block btn btn-sm btn-danger"
                                        wire:click="delete({{ $transaction->id }})" wire:confirm="Вы уверены?">
                                        <i class="bx bx-trash font-size-16 align-middle"></i>
                                    </button>
                                    <button type="button" class="m-2 btn-block btn btn-success btn-sm"
                                        wire:click="$dispatch('openModalTransactionShow', { transaction_id: {{ $transaction->id }} })">
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
        Livewire.on('contactCloseModal', () => {
            Livewire.dispatch('refreshContacts');
        });
	</script>
@endpush
