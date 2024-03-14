@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Продажи'">
		<a href="{{ route('sales.create') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-plus"></i>
			Добавить продажу
		</a>
	</x-breadcrumb>

	<div class="row">

		<div class="col">
			<div class="card">
				<div class="card-body">
                    @livewire('sale.index')
				</div>
			</div>
		</div>
	</div>

    @livewire('sale.sale-payment')


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
