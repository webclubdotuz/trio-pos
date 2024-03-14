@extends('layouts.main')

@section('content')
    <x-breadcrumb :title="$product->name">
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
            <i class="bx bx-list-ul"></i>
            Список
        </a>
    </x-breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-tab.nav>
                <x-tab.li :id="'purchases'" :title="'Покупки'" :active="true" :icon="'bx bx-shopping-bag'" />
                <x-tab.li :id="'costs'" :title="'Расходы'" :icon="'bx bx-arrow-back'" />
            </x-tab.nav>

            <div class="tab-content py-3">
                <x-tab.content :id="'purchases'" :active="true">
                    @livewire('product.purchase', ['product' => $product])
                </x-tab.content>
                <x-tab.content :id="'costs'">

                </x-tab.content>
            </div>
        </div>
    </div>
@endsection
