<form class="row g-2">
    <div class="col-12">
        <x-alert />
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-4 form-group">
                        <label for="date">Дата</label>
                        <input type="datetime-local" class="form-control" max="{{ date('Y-m-d H:i') }}" min="{{ date('Y-m-d H:i', strtotime('-1 month')) }}" wire:model="date" required>
                    </div>
                    <div class="col-4 form-group">
                        <label for="from_warehouse_id">Откуда</label>
                        <select class="form-control select2" wire:model.live="from_warehouse_id" required>
                            <option value="">Выберите склад</option>
                            @foreach (getWarehouses() as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        @error('from_warehouse_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-4 form-group">
                        <label for="to_warehouse_id">Куда</label>
                        <select class="form-control select2" wire:model.live="to_warehouse_id" required>
                            <option value="">Выберите склад</option>
                            @foreach (getWarehouses() as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        @error('to_warehouse_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="dropdown">
                            <div class="form-group">
                                <input type="search" class="form-control" placeholder="Поиск по продуктам" wire:model="search" wire:keydown="searchProduct" autofocus>
                            </div>
                            @if (count($products) > 0 && $search)
                            <ul class="dropdown-menu" style="display: block; position: relative;">
                                @foreach ($products as $product)
                                    <li class="dropdown-item" wire:click="addProduct({{ $product->id }})">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="30" height="30">{{ $product->name }} ({{ $product->code }})
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>

                    <div class="col-12">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Фото</th>
                                    <th>Продукт</th>
                                    <th>Количество</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts->getItems() as $cart)
                                    <tr>
                                        {{-- @dd($cart) --}}
                                        <td><img src="{{$cart->image_url}}" alt="{{ $cart->name }}" width="30" height="30"></td>
                                        <td>{{ $cart->name }}</td>
                                        <td>
                                            <div class="input-group">
                                                <span class="btn btn-sm btn-danger" wire:click="decreaseProduct({{ $cart->id }})">
                                                    <i class="bx bx-minus"></i>
                                                </span>
                                                <input type="number" class="form-control form-control-sm" wire:model.live="quantity.{{ $cart->id }}" wire:keydown="changeQuantity({{ $cart->id }}, $event.target.value)">
                                                <span class="btn btn-sm btn-primary" wire:click="increaseProduct({{ $cart->id }})">
                                                    <i class="bx bx-plus"></i>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <span class="btn btn-sm btn-primary" wire:click="editProduct({{ $cart->id }})">
                                                    <i class="bx bx-edit"></i>
                                                </span>
                                                <span class="btn btn-sm btn-danger" wire:click="removeProduct({{ $cart->id }})">
                                                    <i class="bx bx-trash"></i>
                                                </span>
                                            </div>
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

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <span class="btn btn-sm btn-success" wire:click="save">
                            Сохранить <i class="bx bx-save"></i>
                        </span>

                        <span class="btn btn-sm btn-danger" wire:click="clearCart" style="float: right;">
                            Очистить <i class="bx bx-trash"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@push('js')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('editProductOpenModal', (product) => {
            $('#editProduct').modal('show');
        });

        Livewire.on('editProductCloseModal', () => {
            $('#editProduct').modal('hide');
        });

        Livewire.on('checkoutOpenModal', () => {
            $('#paymentModel').modal('show');
        });

        Livewire.on('checkoutInstallmentOpenModal', () => {
            $('#installmentModal').modal('show');
        });

     });
</script>

@endpush
