<div>
    <div class="modal fade" id="ContactCreateOrUpdate" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Создание клиента</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-2" method="post" wire:submit.prevent="store">
                        <div class="col-md-4 form-group">
                            <label for="first_name">Имя <span class="text-danger">*</span></label>
                            <input type="text" wire:model="first_name" id="first_name" class="form-control" required>
                            @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="last_name">Фамилия</label>
                            <input type="text" wire:model="last_name" id="last_name" class="form-control">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="middle_name">Отчество</label>
                            <input type="text" wire:model="middle_name" id="middle_name" class="form-control">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="passport">Паспорт</label>
                            <input type="text" wire:model="passport" id="passport" class="form-control" placeholder="KA1234567" pattern="[A-Z]{2}[0-9]{7}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="passport_date">Дата выдачи</label>
                            <input type="date" wire:model="passport_date" id="passport_date" class="form-control">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="passport_by">Кем выдан</label>
                            <input type="text" wire:model="passport_by" id="passport_by" class="form-control">
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="phone">Телефон</label>
                            <div class="input-group">
                                <span class="input-group-text">+998</span>
                                <input type="text" wire:model="phone" id="phone" class="form-control" placeholder="934879598" pattern="[0-9]{9}">
                            </div>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="find_id">Как узнали о нас <span class="text-danger">*</span></label>
                            <select wire:model="find_id" id="find_id" class="form-select" required>
                                <option value="">Выберите</option>
                                @foreach (getFinds() as $find)
                                    <option value="{{ $find->id }}">{{ $find->name }}</option>
                                @endforeach
                            </select>
                            @error('find_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="address">Адрес</label>
                                    <textarea wire:model="address" id="address" class="form-control"></textarea>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="description">Описание</label>
                                    <textarea wire:model="description" id="description" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openModal', () => {
                $('#ContactCreateOrUpdate').modal('show');
            });

            Livewire.on('closeModal', (id) => {
                $('#ContactCreateOrUpdate').modal('hide');
                Livewire.dispatch('refreshSale');
                Livewire.dispatch('refreshCustomer', { customer_id: id });
            });

        });
    </script>
@endpush
