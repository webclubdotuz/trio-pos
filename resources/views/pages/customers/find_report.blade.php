@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Отчет по клиенту'">

</x-breadcrumb>

<div class="row">
    <x-charts.pie :title="'Отчет по клиенту'" :labels="$labels" :data="$data" />
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Источник</th>
                                <th>Количество</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->find->name }}</td>
                                <td>{{ $customer->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
