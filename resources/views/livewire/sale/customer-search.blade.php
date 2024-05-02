<div>
    <div class="modal fade" id="CustomerSearch" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Поиск клиента</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-12">
                            <input type="text" class="form-control" placeholder="Поиск по ФИО, телефону" wire:model.live="search">
                        </div>
                        <div class="col-12">
                            <div id="list-example" class="list-group" style="max-height: 250px; overflow-y: auto;">
                                @forelse($customers as $customer)
                                    <a class="list-group-item list-group-item-action" wire:click="$dispatchTo('sale.create', 'setCustomer', { customer_id : {{ $customer->id }} })" data-bs-dismiss="modal">
                                        {{ $customer->full_name }} - {{ $customer->phone }} <br>
                                    </a>
                                @empty
                                    <a class="list-group item list-group-item-action">
                                        Ничего не найдено <br>
                                        <button class="btn btn-success" wire:click="$dispatch('openModalCustomerCreate')" data-bs-dismiss="modal">
                                            <i class="uil-plus"></i> Создать клиента
                                        </button>
                                    </a>
                                @endforelse
                            </div>
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
            Livewire.on('openModalCustomerSearch', () => {
                $('#CustomerSearch').modal('show');
            });

            Livewire.on('closeModal', (id) => {
                $('#CustomerSearch').modal('hide');
                Livewire.dispatch('refreshSale');
                Livewire.dispatch('refreshCustomer', { customer_id: id });
            });

        });
    </script>
@endpush
