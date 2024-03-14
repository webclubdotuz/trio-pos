@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Клиенты'">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('customers.create') }}">
        <i class="bx bx-plus"></i>Создать
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                @livewire('customer.index')
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
