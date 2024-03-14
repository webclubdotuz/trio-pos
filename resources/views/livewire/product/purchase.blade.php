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
					<th>Покупки</th>
					<th>Кол-во</th>
					<th>Сумма</th>
					<th>Дата</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->transaction->contact->fullname }}</td>
                        <td>{{ $purchase->transaction->user->fullname }}</td>
                        <td>{{ nf($purchase->quantity) }}</td>
                        <td>{{ nf($purchase->total) }}</td>
                        <td>{{ df($purchase->created_at) }}</td>
                        <td></td>
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
