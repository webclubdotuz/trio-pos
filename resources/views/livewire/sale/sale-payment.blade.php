<div>
    <div class="modal fade" id="SalePaymentModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Оплата</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($sale)
                        <div class="row g-2">
                            <div class="col-12">
                                <b>ФИО:</b> {{ $sale?->customer?->full_name }} <br>
                                <b>Телефон:</b> {{ $sale?->customer?->phone }} <br>
                                <hr>
                                <b>Сумма:</b> {{ nf($sale->total) }} <br>
                                <b>Оплачено:</b> {{ nf($sale->paid) }} <br>
                                @if ($sale->debt > 0)
                                    <b class="text-danger">Общая задолженность:</b> {{ nf($sale->debt) }} <br>
                                @endif

                                @foreach ($sale->installments as $installment)
                                    @if ($installment->debt)
                                        <b class="text-danger">Задолженность по рассрочке:</b> {{ nf($installment->debt) }} <br>
                                        <b>Дата оплаты:</b> {{ df($installment->date) }} <br>
                                        @break
                                    @endif
                                @endforeach


                            </div>

                            @if ($sale->debt > 0)
                                <hr>
                                <form class="col-12" wire:submit.prevent="save">
                                    <div class="row g-2">
                                        <div class="col-md-12">
                                            <label for="date">Дата</label>
                                            <input type="datetime-local" class="form-control" wire:model="date" required>
                                            @error('date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        @foreach ($payments as $key => $payment)
                                            <div class="col-6 form-group">
                                                <label for="payment_amounts.{{ $key }}">Сумма</label>
                                                <input type="text" class="form-control"
                                                    wire:model.live="payment_amounts.{{ $key }}" required>
                                                @error('payment_amounts.' . $key)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-6 form-group">
                                                <label for="payment_methods.{{ $key }}">Метод оплаты</label>
                                                <select class="form-control" wire:model="payment_methods.{{ $key }}" required>
                                                    <option value="">Выберите метод оплаты</option>
                                                    @foreach (getPaymentMethods() as $payment_method)
                                                        <option value="{{ $payment_method->id }}">
                                                            {{ $payment_method->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('payment_methods.' . $key)
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                @if ($key > 0)
                                                    <span wire:click="removePayment({{ $key }})"
                                                        class="text-danger">
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

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-sm @if ($payment_amount_total <= 0 || $payment_amount_total > $sale->debt) disabled @endif">
                                                <i class="bx bx-check"></i>Оплатить {{ nf($payment_amount_total) }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @endif


                            <hr>
                            <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#history">
                                История <i class="bx bx-chevron-down"></i>
                            </button>
                            <div class="col-12">
                                <div class="collapse" id="history">
                                    <h5>Оплата история</h5>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Сумма</th>
                                                <th>Метод оплаты</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale?->sale_payments as $sale_payment)
                                                <tr>
                                                    <td>{{ $sale_payment?->date }}</td>
                                                    <td>{{ nf($sale_payment?->amount) }}</td>
                                                    <td>{{ $sale_payment?->payment_method?->name }}</td>
                                                    <td>
                                                        <a href="{{ route('sale-payments.print' , $sale_payment->id) }}" target="_blank">
                                                            <i class="ln bx bx-printer"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if ($sale->installment_status)
                                <hr>
                                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#installmanet">
                                    Рассрочка <i class="bx bx-chevron-down"></i>
                                </button>
                                <div class="col-12">
                                    <div class="collapse" id="installmanet">
                                        <h5>Рассрочка</h5>
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Дата</th>
                                                    <th>Сумма</th>
                                                    <th>Метод оплаты</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sale->installments as $installment)
                                                    <tr>
                                                        <td>{{ $installment->date }}</td>
                                                        <td>{{ nf($installment->amount) }}</td>
                                                        <td>{{ $installment->status }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openModalSalePayment', () => {
                $('#SalePaymentModal').modal('show');
            });
        });
    </script>
@endpush
