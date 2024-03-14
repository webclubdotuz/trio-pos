<div>
    <x-alert />
    <div class="modal fade" id="TransactionShow" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Заказ</h5>
                    <button type="btn" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if($transaction)
                        <div class="row">
                            <div class="col-12">
                                <b>ФИО:</b> {{ $transaction->contact->fullname }} <br>
                                <b>Телефон:</b> {{ $transaction->contact->phone }} <br>
                                <hr>
                                <b>Сумма:</b> {{ nf($transaction->total) }} <br>
                                <b>Оплачено:</b> {{ nf($transaction->paid) }} <br>
                                @if($transaction->debt > 0)
                                    <b class="text-danger">Долг: {{ nf($transaction->debt) }}</b> <br>
                                @endif
                                <b>Создан:</b> {{ df($transaction->created_at, 'd.m.Y H:i') }} <br>
                            </div>

                            <hr>

                            @if($transaction->type == 'purchase')
                                <div class="col-12">
                                    <h5>Покупка</h5>
                                    <table class="table table-sm table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Товар</th>
                                                <th>Цена/Cумма</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($transaction)
                                                @foreach ($transaction->purchases as $purchase)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><b>{{ $purchase->product->name }}</b></td>
                                                        <td>
                                                            {{ nf($purchase->price) }} / {{ nf($purchase->total) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif


                            @if($transaction->type == 'sale')
                                <div class="col-12">
                                    <h5>Продажа</h5>
                                    <table class="table table-sm table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Формат рулона</th>
                                                <th>Вес рулона</th>
                                                <th>Плотность</th>
                                                <th>Клей</th>
                                                <th>Цена/Cумма</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($transaction)
                                                @foreach ($transaction->sales as $sale)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><b>{{ $sale->roll->size }} м</b></td>
                                                        <td><b>{{ $sale->roll->weight }} кг</b></td>
                                                        <td><b>{{ $sale->roll->paper_weight }} гр</b></td>
                                                        <td><b>{{ $sale->roll->glue ? 'Да' : 'Нет' }}</b></td>
                                                        <td>
                                                            {{ nf($sale->price) }} / {{ nf($sale->total) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if($transaction->payments->count() > 0)
                                <div class="col-12">
                                    <h5>Оплаты</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Дата</th>
                                                <th>Сумма</th>
                                                <th>Комментарий</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($transaction->payments as $payment)
                                                <tr>
                                                    <td>{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                                    <td>{{ nf($payment->amount) }}</td>
                                                    <td>{{ $payment->comment }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Итого</th>
                                                <th>{{ nf($transaction->paid) }}</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
            Livewire.on('openModalTransactionShowDis', () => {
                $('#TransactionShow').modal('show');
            });
        });
    </script>
@endpush
