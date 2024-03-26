@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="$sale->invoice_number . ' от ' . $sale->customer->fullname">
		<a href="{{ route('sales.index') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-list-ul"></i>
		</a>
	</x-breadcrumb>

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
                    <div class="row g-2">
                        <div class="col-12">
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash"></i> Удалить
                                </button>
                            </form>
                            <a href="{{ route('sales.contract', $sale->id) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-file"></i> Договор
                            </a>
                        </div>
                        <div class="col-md-4">
                            <p>
                                <b>Информация о клиенте</b> <br>
                                <strong>Имя:</strong> <a href="{{ route('customers.show', $sale->customer->id) }}">{{ $sale->customer->full_name }}</a> <br>
                                <strong>Телефон:</strong> {{ $sale->customer->phone }} <br>
                                <strong>Адрес:</strong> {{ $sale->customer->address }} <br>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p>
                                <b>Информация о продаже</b> <br>
                                <strong>Номер счета:</strong> {{ $sale->invoice_number }} <br>
                                <strong>Дата:</strong> {{ df($sale->date, 'd.m.Y H:i') }} <br>
                                <strong>Сумма:</strong> {{ nf($sale->total) }} uzs <br>
                                <strong>Статус:</strong> {!! $sale->status_html !!} <br>
                                <strong>Оплата:</strong> {{ nf($sale->paid) }} uzs <br>
                                @if ($sale->debt > 0)
                                    <strong>Долг:</strong> {{ nf($sale->debt) }} uzs <br>
                                @endif
                            </p>
                        </div>

                        <div class="col-12">
                            <p>
                                Список товаров
                            </p>
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Фото</th>
                                        <th>Наименование</th>
                                        <th>Кол-во</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->sale_items as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-fluid" width="50">
                                            </td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ nf($item->price) }} uzs</td>
                                            <td>{{ nf($item->total) }} uzs</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <strong>Итого:</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $sale->sale_items->sum('quantity') }}</strong>
                                        </td>
                                        <td></td>
                                        <td>
                                            <strong>{{ nf($sale->total) }} uzs</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

    <div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <p>
                                <b>Оплата история</b>
                            </p>
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Способ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ df($payment->date, 'd.m.Y') }}</td>
                                            <td>{{ nf($payment->amount) }} uzs</td>
                                            <td>{{ $payment->payment_method->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
        <div class="col-md-6">
			<div class="card">
				<div class="card-body">
                    <div class="row g-2">
                        @if ($sale->installment_status)
                        <div class="col-md-12">
                            <p>
                                <b>Информация о рассрочке</b> <br>
                                <strong>Месяц:</strong> {{ $sale->installment_month }} <br>
                                <strong>Процент:</strong> {{ $sale->installment_percent }} % <br>
                                @if ($sale->installment_first_payment)
                                <strong>Первоначальный взнос:</strong> {{ nf($sale->installment_first_payment) }} uzs <br>
                                @endif
                            </p>

                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->installments as $installment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ df($installment->date, 'd.m.Y') }}</td>
                                            <td>{{ nf($installment->amount) }} uzs</td>
                                            <td>{!! $installment->status_html !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
				</div>
			</div>
		</div>

        <div class="col-md-6">
			<div class="card">
				<div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-12">
                            <p>
                                <b>Отвыз</b>
                            </p>
                            @if ($sale->review)
                                <p>
                                    <a href="{{ asset('storage/' . $sale->review->image) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $sale->review->image) }}" alt="{{ $sale->review->comment }}" width="50%" class="img-thumbnail">
                                    </a>
                                    <br>
                                    <strong>Дата:</strong> {{ df($sale->review->date, 'd.m.Y') }} <br>
                                    <strong>Комментарий:</strong> {{ $sale->review->comment }} <br>
                                </p>

                                <form action="{{ route('sales.destroy-review', ['sale' => $sale->id, 'review' => $sale->review->id]) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Удалить отзыв
                                    </button>
                                </form>

                            @else
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#review">
                                    Добавить отзыв
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Добавить отзыв</h5>
                                                    <button type="button" class="btn" data-bs-dismiss="modal">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <div class="modal-body">
                                                <div class="container-fluid">
                                                    <form action="{{ route('sales.store-review', $sale->id) }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="image">Изображение</label>
                                                            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="comment">Комментарий</label>
                                                            <textarea name="comment" id="comment" class="form-control"></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary mt-2">Сохранить</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

@endsection
