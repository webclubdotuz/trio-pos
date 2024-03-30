@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Перемещения'">
		<a href="{{ route('transfers.create') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-plus"></i>
			Добавить перемещение
		</a>
	</x-breadcrumb>

	<div class="row">

		<div class="col">
			<div class="card">
				<div class="card-body">
                    {{-- @livewire('sale.index') --}}
				</div>
			</div>
		</div>
	</div>

    {{-- @livewire('sale.sale-payment') --}}


@endsection

@push('js')
    {{-- <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openModalSalePayment', () => {
                $('#modalSalePayment').modal('show');
            });
        });
    </script> --}}
@endpush
