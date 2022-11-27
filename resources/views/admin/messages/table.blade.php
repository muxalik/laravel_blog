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
                <tr>
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
                        <small
                            class="badge 
                            @if (!is_null($message->seen)) badge-success 
                            @else badge-warning @endif"><i
                                class="far fa-clock"></i>
                            {{ $message->getDate($message->created_at) }}
                        </small>
                    </td>
                    <td class="pr-2">
                        <div class="table_actions">
                            <a href="" class="btn btn-info btn-sm table-action" title="Пометить прочитанным">
                                <img src="{{ asset('images/icons/read.png') }}" class="my-icon"
                                    alt="Пометить прочитанным">
                            </a>
                            <a href="" class="btn btn-info btn-sm table-action" title="Пометить непрочитанным">
                                <img src="{{ asset('images/icons/unread.png') }}" class="my-icon"
                                    alt="Пометить непрочитанным">
                            </a>
                            <form action="{{ route('messages.destroy', ['id' => $message->id]) }}" method="POST"
                                class="float-left table-action" title="Удалить">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm table-action">
                                    <img src="{{ asset('images/icons/delete_1.png') }}" class="my-icon" alt="delete">
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="padding: 0.75rem 1.25rem 0">Сообщений пока нет...</p>
@endif
