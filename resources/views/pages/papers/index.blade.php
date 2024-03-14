@extends('layouts.main')

@section('content')
<x-breadcrumb :title="'Бункеры'">
    <a href="{{ route('papers.create') }}" class="btn btn-sm btn-primary">
        <i class="bx bx-plus"></i>
        Добавить
    </a>
</x-breadcrumb>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                {{-- <form action="" class="row g-2">
                    <div class="col-md-4">
                        <label for="start_date">Начальная дата</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $start_date }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date">Конечная дата</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $end_date }}">
                    </div>
                    <div class="col-md-4">
                        <label for="paper_category_id">Категория</label>
                        <select name="paper_category_id" id="paper_category_id" class="form-control">
                            <option value="">Выберите</option>
                            @foreach (getpaperCategories() as $paper_category)
                            <option value="{{ $paper_category->id }}" {{ request()->get('paper_category_id') == $paper_category->id ? 'selected' : '' }}>{{ $paper_category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Фильтр <i class="bx bx-filter-alt"></i></button>
                        <a href="{{ route('papers.index') }}" class="btn btn-danger">Сбросить <i class="bx bx-reset"></i></a>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body row g-2">
                <div class="col-12 table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Товар</th>
                                <th>Количество</th>
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
