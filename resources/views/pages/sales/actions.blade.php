<div class="dropdown open">
    <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="dropdown">
        <i class="bx bx-dots-vertical-rounded"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item border-bottom" href="{{ route('sales.show', $sale->id) }}"><i class="bx bx-show"></i> Просмотр</a>
        @if ($sale->installment_status)
        <a class="dropdown-item border-bottom" href="{{ route('sales.contract', $sale->id) }}"><i class="bx bx-file"></i> Договор</a>
        @endif

        @if ($sale->debt)
        <a class="dropdown-item border-bottom" href="#" wire:click="$dispatch('openSalePayment', { 'sale_id': {{ $sale->id }} })"><i class="bx bx-money"></i> Оплата</a>
        @endif
        @if(hasRoles(['admin','manager']))
        <form action="{{ route('sales.destroy', $sale->id) }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="dropdown-item text-danger" type="submit" onclick="return confirm('Вы уверены?')"><i class="bx bx-trash"></i> Удалить</button>
        </form>
        @endif
    </div>
</div>

@push('js')

@endpush
