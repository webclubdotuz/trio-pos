@extends('layouts.main')
@push('css')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet"/>
@endpush
@section('content')
	<x-breadcrumb :title="'Перемещение товаров'">
		<a href="{{ route('purchases.index') }}" class="btn btn-sm btn-primary">
			<i class="bx bx-list-ul"></i>
			Список покупок
		</a>
	</x-breadcrumb>

	<div class="row">
		<div class="col-12">
			@include('components.alert')
		</div>

		<div class="col-md-12">
            @livewire('transfer.create')
		</div>
	</div>
@endsection

@push('js')
<script src="/assets/plugins/select2/js/select2.min.js"></script>
@endpush
