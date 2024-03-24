<form action="{{ route('customers.destroy', $id) }}" method="post">
    @csrf
    @method('DELETE')
    <div class="btn-group">
        <a href="{{ route('customers.show', $id) }}" class="btn btn-sm btn-success"><i class="bx bx-show"></i></a>
        @if(hasRoles())
        <a class="btn btn-sm btn-primary" href="{{ route('customers.edit', $id) }}">
            <i class="bx bx-edit"></i>
        </a>
        <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Вы уверены?')">
            <i class="bx bx-trash"></i>
        </button>
        @endif
    </div>
</form>
