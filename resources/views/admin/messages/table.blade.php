@if ($messages->count())
    <table class="table table-head-fixed table-bordered table-hover" id="table-info">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                <th>Имя пользователя</th>
                <th>Контактное имя</th>
                <th>Почта</th>
                <th>Телефон</th>
                <th>Тема</th>
                <th>Контент</th>
                <th>Просмотрено</th>
                <th>Написано</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $message)
                <tr aria-expanded="false">
                    <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $message->id }}</td>
                    <td>{{ $message->user->name }}</td>
                    <td>{{ $message->name }}</td>
                    <td>{{ $message->email }}</td>
                    <td>{{ $message->phone }}</td>
                    <td>{{ $message->subject }}</td>
                    <td>{{ $message->content }}</td>
                    @if (!is_null($message->seen))
                        <td><small class="badge badge-success"><i class="far fa-clock"></i>
                                {{ $message->getDate($message->seen) }}</small></td>
                    @else
                        <td></td>
                    @endif
                    <td>
                        <small class="badge 
                            @if (!is_null($message->seen)) badge-success 
                            @else badge-warning 
                            @endif"><i class="far fa-clock"></i>
                            {{ $message->getDate($message->created_at) }}
                        </small>
                    </td>
                    <td class="table_actions">
                        <a href="" class="btn btn-info btn-sm float-left mr-1 table-action"
                            title="Редактировать">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('messages.destroy', ['id' => $message->id]) }}" method="POST"
                            class="float-left table-action" title="Удалить">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="padding: 0.75rem 1.25rem 0">Сообщений пока нет...</p>
@endif
