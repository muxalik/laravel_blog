@if ($posts->count())
    <table class="table table-head-fixed table-bordered table-hover" id="table-info">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                <th>Название</th>
                <th>Категория</th>
                <th>Теги</th>
                <th>Просмотры</th>
                <th>Нравится</th>
                <th>Не нравится</th>
                <th>Дата</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr data-widget="expandable-table" aria-expanded="false">
                    <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $post->id }}
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->title }}</td>
                    <td>{{ $post->tags->pluck('title')->join(', ') }}</td>
                    <td>{{ $post->views }}</td>
                    <td>{{ $post->likes }}</td>
                    <td>{{ $post->dislikes }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td class="pr-2">
                        <div class="table_actions">
                            <a href="{{ route('posts.edit', ['post' => $post->id]) }}"
                                class="btn btn-info btn-sm table-action" title="Редактировать">
                                <img src="{{ asset('images/icons/edit_1.png') }}" class="my-icon" alt="Редактировать">
                            </a>
                            <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST"
                                class="float-left table-action" title="Удалить">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm table-action action-delete">
                                    <img src="{{ asset('images/icons/delete_1.png') }}" class="my-icon" alt="delete">
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr class="expandable-body d-done d-none">
                    <td colspan="9">
                        <p>
                            {{ $post->description }}
                        </p>
                        <p>
                            {{ $post->content }}
                        </p>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p style="padding: 0.75rem 1.25rem 0">Статей пока нет...</p>
@endif
