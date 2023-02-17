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
                    <td class="pr-2">
                        <div class="table_actions">
                            <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                class="btn btn-info btn-sm table-action" title="Редактировать">
                                <img src="{{ asset('images/icons/edit.png') }}" class="my-icon" alt="Редактировать">
                            </a>
                            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST"
                                class="float-left table-action" title="Удалить">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm table-action action-delete">
                                    <img src="{{ asset('images/icons/delete.png') }}" class="my-icon" alt="delete">
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="padding: 0.75rem 1.25rem 0">Пользователей пока нет...</p>
@endif
