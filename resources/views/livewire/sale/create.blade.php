<form class="row g-2">
    <div class="col-12">
        <x-alert />
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4 form-group">
                        <label for="date">Дата</label>
                        <input type="datetime-local" class="form-control" max="{{ date('Y-m-d H:i') }}" min="{{ date('Y-m-d H:i', strtotime('-1 month')) }}" wire:model="date" required>
                    </div>
                    <div class="col-4 form-group">
                        <label for="customer_id">Клиент</label>
                        <select class="form-control select2" wire:model="customer_id" required>
                            <option value="">Выберите клиента</option>
                            @foreach (getCustomers() as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-4 form-group">
                        <label for="warehouse_id">Склад</label>
                        <select class="form-control select2" wire:model.live="warehouse_id" required>
                            <option value="">Выберите склад</option>
                            @foreach (getWarehouses() as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                        @error('warehouse_id') <span class="text-danger">{{ $message }}</span> @enderror
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
                                    <th>Цена</th>
                                    <th>Сумма</th>
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
                                        <td>{{ nf($cart->price) }}</td>
                                        <td>{{ nf($cart->price * $cart->quantity) }}</td>
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
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end">Итого</td>
                                    <td>{{ nf($carts->getTotal()) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
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
                        <span class="btn btn-sm btn-success" wire:click="checkout">
                            Оформить
                        </span>
                        <span class="btn btn-sm btn-primary" wire:click="checkout_installment">
                            Рассрочка
                        </span>

                        <span class="btn btn-sm btn-danger" wire:click="clearCart" style="float: right;">
                            Очистить <i class="bx bx-trash"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <!-- editProduct Modal -->
        <div class="modal fade" id="editProduct" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактировать продукт в корзине</h5>
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($product)
                        <div class="row">
                            <p>
                                <img src="{{ $product?->image_url }}" alt="{{ $product?->name }}" width="100" height="100">
                                {{ $product?->name }} ({{ $product?->code }})
                            </p>
                            <div class="col-12">
                                <input type="hidden" wire:model="product_id" value="{{ $product?->id }}">
                                <div class="form-group mb-3">
                                    <label for="price">Цена</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control money" wire:model.live="price_usd" wire:keydown="priceToUzs" required>
                                        <span class="input-group-text">usd</span>
                                        <input type="text" class="form-control money" wire:model.live="price" wire:keydown="priceToUsd" required>
                                        <span class="input-group-text">uzs</span>
                                    </div>
                                    @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                    @error('price_usd') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-12 form-group">
                                <label for="imei">IMEI</label>
                                <textarea class="form-control" wire:model.live="imei"></textarea>
                                <small>Укажите IMEI, если продукт имеет IMEI</small>
                                @error('imei') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i> Закрыть</button>
                        <button type="button" class="btn btn-sm btn-primary" wire:click="updateProduct"><i class="bx bx-check"></i> Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="paymentModel" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Оплата</h5>
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($carts->getTotal() > 0)
                        <div class="row g-2">
                            <div class="col-12">
                                <p>
                                    Сумма: {{ nf($carts->getTotal()) }} <br>
                                    Оплачено: {{ nf(array_sum($payment_amounts)) }} <br>
                                    <?php $debt = $carts->getTotal() - array_sum($payment_amounts); ?>
                                    @if ($debt > 0)
                                        <span class="text-danger">Долг: {{ nf($debt) }}</span>
                                    @endif
                                </p>
                            </div>
                            @foreach ($payments as $key => $payment)
                                <div class="col-6 form-group">
                                    <label for="payment_amounts.{{ $key }}">Сумма</label>
                                    <input type="text" class="form-control" wire:model.live="payment_amounts.{{ $key }}" required>
                                    @error('payment_amounts.'.$key) <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-6 form-group">
                                    <label for="payment_methods.{{ $key }}">Метод оплаты</label>
                                    <select class="form-control" wire:model="payment_methods.{{ $key }}" required>
                                        @foreach (getPaymentMethods() as $payment_method)
                                            <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_methods.'.$key) <span class="text-danger">{{ $message }}</span> @enderror
                                    @if ($key > 0)
                                        <span wire:click="removePayment({{ $key }})" class="text-danger">
                                            Удалить <i class="bx bx-trash"></i>
                                        </span>
                                    @endif

                                </div>
                            @endforeach

                            <div class="col-12">
                                <span wire:click="addPayment">
                                    Добавить <i class="bx bx-plus"></i>
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i> Закрыть</button>
                        @if ($carts->getTotal() >= array_sum($payment_amounts) && array_sum($payment_amounts) >= 0)
                            <button type="button" class="btn btn-sm btn-primary" wire:click="save"><i class="bx bx-check"></i> Оплатить</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="installmentModal" tabindex="-1" role="dialog" wire:ignore.self>
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Рассрочка</h5>
                        <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($carts->getTotal() > 0)
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="row g-2">
                                    <div class="col-md-4 form-group">
                                        <label for="first_payment">Первоначальный</label>
                                        <input type="text" class="form-control" wire:model="first_payment" required>
                                        @error('first_payment') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="percent">Процент</label>
                                        <input type="text" class="form-control" wire:model="percent" required>
                                        @error('percent') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label for="month">Месяцы</label>
                                        <select class="form-select" wire:model="month" required wire:change="monthChange($event.target.value, $event.target.options[$event.target.selectedIndex].getAttribute('percent'))">
                                            <option value="">Выберите месяцы</option>
                                            @foreach (getInstallmentMonths() as $installment_month)
                                                <option value="{{ $installment_month->month }}" percent="{{ $installment_month->percent }}">{{ $installment_month->month }}</option>
                                            @endforeach
                                        </select>
                                        @error('month') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-12">
                                        <span class="btn btn-sm btn-primary" wire:click="calculateInstallment">Рассчитать</span>
                                    </div>
                                </div>
                            </div>

                            {{-- scroll --}}
                            <div class="col-12" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered table-sm">
                                    {{-- header sticky --}}
                                    <thead style="position: sticky; top: 0; background: #fff;">
                                        <tr>
                                            <th>№</th>
                                            <th>Дата</th>
                                            <th>Сумма</th>
                                            <th>Остаток</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($installment_lists as $key => $installment_list)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ df($installment_list['date']) }}</td>
                                                <td>{{ nf($installment_list['amount']) }}</td>
                                                <td>{{ nf($installment_list['debt']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="bx bx-x"></i> Закрыть</button>
                        @if ($carts->getTotal() && $installment_lists)
                            <button type="button" class="btn btn-sm btn-primary" wire:click="saveInstallment"><i class="bx bx-check"></i> Оформить</button>
                        @endif
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
