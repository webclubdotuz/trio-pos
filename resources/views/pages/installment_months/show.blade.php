@extends('layouts.main')

@section('content')
<x-breadcrumb :title="$warehouse->name">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('warehouses.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1>
                    Раздел в разработке...
                </h1>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
