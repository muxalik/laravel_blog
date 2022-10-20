@if (count($posts))
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
                    <td class="table_actions">
                        <a href="{{ route('posts.edit', ['post' => $post->id]) }}"
                            class="btn btn-info btn-sm float-left mr-1 table-action" title="Редактировать">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST"
                            class="float-left table-action" title="Удалить">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm action-delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <tr class="expandable-body d-done">
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
