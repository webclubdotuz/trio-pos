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
                <label for="from_warehouse_id">Откуда</label>
                <select class="form-select" id="from_warehouse_id" wire:model.live="from_warehouse_id">
                    <option value="">Все</option>
                    @foreach (getWarehouses() as $warehouse)
                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="to_warehouse_id">Куда</label>
                <select class="form-select" id="to_warehouse_id" wire:model.live="to_warehouse_id">
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
                    <th></th>
                    <th>ID</th>
                    <th>Откуда</th>
                    <th>Куда</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transfers as $transfer)
                    <tr>
                        <td>
                            @include('pages.transfers.actions', ['transfers' => $transfers])
                        </td>
                        <td>
                            <a href="{{ route('transfers.show', $transfer->id) }}" class="text-decoration-none">
                                {{ $transfer->id }}
                            </a>
                        </td>
                        <td>{{ $transfer->fromWarehouse->name }}</td>
                        <td>{{ $transfer->toWarehouse->name }}</td>
                        <td>{{ df($transfer->date, 'd.m.Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="100" class="text-center">Нет данных</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('js')

@endpush
