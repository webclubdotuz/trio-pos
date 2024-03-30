@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Перемещение товаров'">
		<a href="{{ route('transfers.index') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-list-ul"></i>
		</a>
	</x-breadcrumb>

	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
                    <div class="row g-2">
                        <div class="col-12">
                            <form action="{{ route('transfers.destroy', $transfer->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bx bx-trash"></i> Удалить
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <p>
                                <b>Информация перемещения</b> <br>
                                <strong>Откуда:</strong> {{ $transfer->fromWarehouse->name }} <br>
                                <strong>Куда:</strong> {{ $transfer->toWarehouse->name }} <br>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transfer->items as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-fluid" width="50">
                                            </td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="text-right">
                                            <strong>Итого:</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $transfer->items->sum('quantity') }}</strong>
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

@endsection
