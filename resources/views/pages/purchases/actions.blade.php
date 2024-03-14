<div class="dropdown open">
    <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="dropdown">
        <i class="bx bx-dots-vertical-rounded"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item border-bottom" href="{{ route('purchases.show', $purchase->id) }}"><i class="bx bx-show"></i> Просмотр</a>

        @if ($purchase->debt_usd)
        <a class="dropdown-item border-bottom" wire:click="$dispatch('openPurchasePayment', { 'purchase_id': {{ $purchase->id }} })"><i class="bx bx-money"></i> Оплата</a>
        @endif

        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="dropdown-item text-danger" type="submit" onclick="return confirm('Вы уверены?')"><i class="bx bx-trash"></i> Удалить</button>
        </form>
    </div>
</div>
