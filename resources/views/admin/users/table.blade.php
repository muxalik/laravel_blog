@if ($users->count())
    <table class="table table-head-fixed table-bordered table-hover" id="table-info">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Регистрация</th>
                <th>Последнее посещение</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $user->id }}
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                        @if ($user->is_admin)
                            Админ
                        @else
                            Пользователь
                        @endif
                    </td>
                    <td class="table_actions">
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                            class="btn btn-info btn-sm float-left mr-1 table-action" title="Редактировать">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST"
                            class="float-left mr-1 table-action" title="Удалить">
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
    <p style="padding: 0.75rem 1.25rem 0">Пользователей пока нет...</p>
@endif
