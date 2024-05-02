@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Попупки ' . $purchase->invoice_number">
		{{-- <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-plus"></i>
			Добавить
		</a> --}}
	</x-breadcrumb>

	<div class="row">

		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <b>Информация</b>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>INV</td>
                                        <td>{{ $purchase->invoice_number }}</td>
                                    </tr>
                                    <tr>
                                        <td>Поставщик</td>
                                        <td><a href="{{ route('suppliers.show',  $purchase->supplier_id) }}">{{ $purchase->supplier->full_name }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Дата</td>
                                        <td>{{ df($purchase->date) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Сумма</td>
                                        <td>{{ nf($purchase->total) }} сум</td>
                                    </tr>
                                    <tr>
                                        <td>Сумма</td>
                                        <td>$ {{ nf($purchase->total_usd) }}</td>
                                    </tr>
                                    @if($purchase->debt_usd)
                                    <tr class="text-danger">
                                        <td>Долг</td>
                                        <td>$ {{ nf($purchase->debt_usd) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>Статус</td>
                                        <td>{!! $purchase->status_html !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>

        <div class="col-md-8">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <b>Товары</b>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th>Кол-во</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->purchase_items as $purchase_item)
                                        <tr>
                                            <td>{{ $purchase_item?->product_id }}</td>
                                            <td>{{ ($purchase_item->product->name) }}</td>
                                            <td>{{ $purchase_item->quantity }}</td>
                                            <td>{{ nf($purchase_item->price) }} uzs / ${{ nf($purchase_item->price_usd) }}</td>
                                            <td>{{ nf($purchase_item->total) }} uzs / ${{ nf($purchase_item->total_usd) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><b>Итого</b></td>
                                        <td>{{ nf($purchase->purchase_items->sum('quantity')) }}</td>
                                        <td></td>
                                        <td>{{ nf($purchase->total) }} uzs / ${{ nf($purchase->total_usd) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-12">
                            @if(hasRoles())
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <div class="btn-group">
                                        {{-- <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-primary"><i class="bx bx-edit"></i></a> --}}
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')"><i class="bx bx-trash"></i></button>
                                    </div>
                                </form>
                            @endif
                        </div>

                    </div>
				</div>
			</div>

            <div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <b>Оплаты</b>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Тип</th>
                                        <th>Комментарий</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchase->purchase_payments as $purchase_payment)
                                        <tr>
                                            <td>{{ df($purchase_payment->date) }}</td>
                                            <td>${{ nf($purchase_payment->amount_usd) }} / {{ nf($purchase_payment->amount) }} uzs</td>
                                            <td>{{ $purchase_payment->payment_method->name }}</td>
                                            <td>{{ $purchase_payment->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-right"><b>Итого</b></td>
                                        <td>${{ nf($purchase->purchase_payments->sum('amount_usd')) }} / {{ nf($purchase->purchase_payments->sum('amount')) }} uzs</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
				</div>
			</div>
		</div>
	</div>

@endsection
