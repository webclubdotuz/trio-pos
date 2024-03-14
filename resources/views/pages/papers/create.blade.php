@extends('layouts.main')
@push('css')
    <!--plugins-->
	<link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="/assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
@endpush
@section('content')
<x-breadcrumb :title="'Создание бункера'">
    <a href="{{ route('papers.index') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-list-ul"></i>
        Список бункеров
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        @include('components.alert')
    </div>
    {{ Form::open(['route' => 'papers.store', 'method' => 'POST', 'class' => 'row']) }}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-md-4">
                    <label for="product_id">Продукт</label>
                    <select name="product_id" id="product_id" class="form-control select2" required>
                        <option value="">Выберите</option>
                        @foreach (getProducts('sale') as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->quantity }} {{ $product->unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="paket_id">Пакет</label>
                    <select name="paket_id" id="paket_id" class="form-control select2" required>
                        <option value="">Выберите</option>
                        @foreach (getProducts('paket') as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->quantity }} {{ $product->unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="quantity">Количество</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="0" required value="0" step="any">
                </div>

                <div class="col-12">
                    {{ Form::submit('Создать', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}


    <div class="col-12">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-12 table-responsive">
                    <h6>Последние 10 бункеров</h6>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Товар</th>
                                <th>Кол-во</th>
                                <th>Пользователь</th>
                                <th>Зарплата</th>
                                <th>Дата</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($papers as $paper)
                            <tr>
                                <td>{{ $paper->id }}</td>
                                <td>
                                    {{ $paper->product->name }}
                                </td>
                                <td>
                                    {{ nf($paper->quantity)}} {{ $paper->product->unit }}
                                </td>
                                <td>
                                    {{ $paper->user->fullname }}
                                </td>
                                <td>
                                    {{ nf($paper->user_amount)}} сум
                                </td>
                                <td>{{ $paper->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('papers.destroy', $paper->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group">
                                            <a href="{{ route('papers.edit', $paper->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Вы уверены?')">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </form>
                                </td>
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
    <script src="/assets/plugins/select2/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Выберите',
                theme: 'bootstrap4'
            });
        });

        $('#expense_category_id').change(function() {
            var user = $(this).find(':selected').data('user');
            console.log(user);
            if (user == 1) {
                $('#user_id_div').removeClass('d-none');
                $('#to_user_id').attr('required', true);
            } else {
                $('#user_id_div').addClass('d-none');
                $('#to_user_id').attr('required', false);
            }
        });

    </script>

@endpush
