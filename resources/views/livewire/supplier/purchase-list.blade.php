<div class="row g-2">
    <div class="col-md-12">
        <div class="row g-2">
            <div class="col-md-6 form-group">
                <label for="start_date">От</label>
                <input type="date" class="form-control" wire:model.live="start_date">
            </div>
            <div class="col-md-6 form-group">
                <label for="end_date">До</label>
                <input type="date" class="form-control" wire:model.live="end_date">
            </div>
        </div>
    </div>
    <div class="col-md-12" wire:loading>
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>INV</th>
                    <th>Создатель</th>
                    <th>Дата</th>
                    <th>Сумма USD</th>
                    <th>Долг USD</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchases as $purchase)
                <tr>
                    <td scope="row">{{ $purchase->invoice_number }}</td>
                    <td>{{ $purchase->user->fullname }}</td>
                    <td>{{ df($purchase->date) }}</td>
                    <td>${{ nf($purchase->total_usd) }}</td>
                    <td>{!! $purchase->status_html !!}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
