@extends('layouts.main')

@section('content')
<x-breadcrumb :title="$product->name">
    <a type="button" class="btn btn-primary btn-sm" href="{{ route('products.index') }}">
        <i class="bx bx-arrow-back"></i> Назад
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <x-tab.nav>
                    <x-tab.li :id="'sales'" :title="'Продажи'" :icon="'bx bx-cart'" />
                    <x-tab.li :id="'purchases'" :title="'Покупки'" :active="true" :icon="'bx bx-shopping-bag'" />
                </x-tab.nav>

                <div class="tab-content py-3">
                    <x-tab.content :id="'sales'">
                        @livewire('product.sale-list', ['product_id' => $product->id])
                    </x-tab.content>
                    <x-tab.content :id="'purchases'" :active="true">
                        @livewire('product.purchase-list', ['product_id' => $product->id])
                    </x-tab.content>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
