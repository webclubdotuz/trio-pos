<div class="dropdown open">
    <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="dropdown">
        <i class="bx bx-dots-vertical-rounded"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item border-bottom" href="{{ route('transfers.show', $transfer->id) }}"><i class="bx bx-show"></i> Просмотр</a>

        <form action="{{ route('transfers.destroy', $transfer->id) }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="dropdown-item text-danger" type="submit" onclick="return confirm('Вы уверены?')"><i class="bx bx-trash"></i> Удалить</button>
        </form>
    </div>
</div>

@push('js')

@endpush
