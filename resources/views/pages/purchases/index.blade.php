@extends('layouts.main')

@section('content')
	<x-breadcrumb :title="'Покупки'">
		<a href="{{ route('purchases.create') }}" class="btn btn-primary">
			<i class="bx bx-plus"></i>
			Покупка
		</a>
	</x-breadcrumb>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            @livewire('purchase.index')
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

    @livewire('purchase.payment')
@endsection
