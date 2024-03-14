@extends('layouts.main')
@push('css')
    <!--plugins-->
	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'1'">
    <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <table class="table table-bordered">

        </table>
    </div>
    <div class="col-12">
        @include('components.alert')
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script src="/assets/plugins/select2/js/select2.min.js"></script>
@endpush
