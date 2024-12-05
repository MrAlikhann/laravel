@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Список объектов</h1>
        <a href="{{ route('moderator.objects.create') }}" class="btn btn-primary mb-3">Добавить объект</a>
        @if($objects->isEmpty())
            <p>Объекты отсутствуют.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Регион</th>
                    <th>Город</th>
                    <th>Улица</th>
                    <th>Дом</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($objects as $object)
                    <tr>
                        <td>{{ $object->id }}</td>
                        <td>{{ $object->region->name }}</td>
                        <td>{{ $object->city->name }}</td>
                        <td>{{ $object->street->name }}</td>
                        <td>{{ $object->house }}</td>
                        <td>{{ $object->status }}</td>
                        <td>
                            <a href="{{ route('moderator.objects.edit', $object) }}" class="btn btn-warning btn-sm">Редактировать</a>
                            <form action="{{ route('moderator.objects.destroy', $object) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $objects->links() }}
        @endif
    </div>
@endsection
