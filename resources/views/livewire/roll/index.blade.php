<div class="col-md-12">
    <div class="card">
        <div class="card-body row g-2">
            <div class="col-12">
                <p>
                    Последние добавленных рулонов
                </p>
            </div>
            <div class="col-md-12">
                <div class="row g-2">
                    <div class="col-6">
                        <label>Начало периода</label>
                        <input type="date" wire:model.live="start_date" class="form-control">
                    </div>
                    <div class="col-6">
                        <label>Конец периода</label>
                        <input type="date" wire:model.live="end_date" class="form-control">
                    </div>
                </div>
            </div>

            <div class="col-12 table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Формат</th>
                            <th>Плотность</th>
                            <th>Вес</th>
                            <th>Клей</th>
                            <th>Дата</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rolls as $roll)
                        <tr>
                            <td>{{ $roll->size }} cм</td>
                            <td>{{ $roll->paper_weight }} гр</td>
                            <td>{{ $roll->weight }} кг</td>
                            <td>{{ $roll->glue ? 'Есть' : 'Нет' }}</td>
                            <td>{{ $roll->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{ route('rolls.edit', $roll->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bx bx-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
