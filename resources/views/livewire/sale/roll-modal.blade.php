<div>
    <div class="modal fade" id="RollSelectModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Рулоны</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Формат рулона</th>
                                        <th>Вес рулона</th>
                                        <th>Плотность	</th>
                                        <th>Клей</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><input type="search" class="form-control form-control-sm" wire:model="search.size"></td>
                                        <td><input type="search" class="form-control form-control-sm" wire:model="search.weight"></td>
                                        <td><input type="search" class="form-control form-control-sm" wire:model="search.paper_weight"></td>
                                        <td><input type="search" class="form-control form-control-sm" wire:model="search.glue"></td>
                                        <td><button class="btn btn-sm btn-primary" wire:click="searchRolls"><i class="bx bx-search"></i></button></td>
                                    </tr>
                                    @foreach ($rolls as $roll)
                                        <tr>
                                            <td>{{ $roll->id }}</td>
                                            <td>{{ $roll->size }} м</td>
                                            <td>{{ $roll->weight }} кг</td>
                                            <td>{{ $roll->paper_weight }} гр</td>
                                            <td>{{ $roll->glue ? 'Да' : 'Нет' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click="selectRoll({{ $roll->id }})">Выбрать</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openRoll', () => {
                $('#RollSelectModal').modal('show');
            });

            Livewire.on('closeRoll', () => {
                console.log('close');
                $('#RollSelectModal').modal('hide');
                Livewire.dispatch('refreshContacts');
            });
        });
    </script>
@endpush
