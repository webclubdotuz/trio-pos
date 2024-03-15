<div class="row g-2">
    <div class="col-12">
        <div class="row g-2">
            <div class="col-6">
                <label for="start_date">Начало периода</label>
                <input type="date" class="form-control" id="start_date" wire:model.live="start_date">
            </div>
            <div class="col-6">
                <label for="end_date">Конец периода</label>
                <input type="date" class="form-control" id="end_date" wire:model.live="end_date">
            </div>
        </div>
    </div>
    <div class="col-12 table-responsive">
        <table class="table table-striped table-bordered" id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Товары</th>
                    <th>Сумма</th>
                    <th>Оплата</th>
                    <th>Дата</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>
                            <a href="{{ route('customers.show', $sale->customer->id) }}">{{ $sale->customer->fullname }}</a>
                        </td>
                        <td>
                            {{ $sale->sale_items->count() }}
                            <div class="dropdown d-inline">
                                <a type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-show"></i>
                                </a>
                                <div class="dropdown-menu p-2">
                                    <table class="table table-bordered table-hover table-sm" id="table">
                                        <thead>
                                            <tr>
                                                <th>№</th>
                                                <th>Фото</th>
                                                <th>Товар</th>
                                                <th>Цена</th>
                                                <th>Сумма</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale->sale_items as $sale_item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ asset($sale_item->product->image_url) }}" alt="{{ $sale_item->product->name }}" class="img-fluid" style="max-width: 50px;">
                                                    </td>
                                                    <td>{{ $sale_item->product->name }}</td>
                                                    <td>{{ nf($sale_item->quantity, 2) }} {{ $sale_item->product->unit }}</td>
                                                    <td>{{ nf($sale_item->price, 2) }}</td>
                                                    <td>{{ nf($sale_item->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                        <td>{{ nf($sale->total, 2) }} {{ $sale->debt_info }}</td>
                        <td>
                            {!! $sale->status_html !!}
                        </td>
                        <td>{{ df($sale->created_at, 'd.m.Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Итого</th>
                    <th></th>
                    <th></th>
                    <th>{{ nf($sales->sum('total'), 2) }}</th>
                    <th></th>
                    <th></th>
            </tfoot>
        </table>
    </div>
</div>
