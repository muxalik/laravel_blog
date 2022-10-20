@if (count($tags))
    <table class="table table-head-fixed table-bordered table-hover" id="table-info">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                <th>Название</th>
                <th>Slug</th>
                <th>Кол-во статей</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $tag->id }}
                    </td>
                    <td>{{ $tag->title }}</td>
                    <td>{{ $tag->slug }}</td>
                    <td>{{ $tag->posts->count('id') }}</td>
                    <td class="table_actions">
                        <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}"
                            class="btn btn-info btn-sm float-left mr-1 table-action" title="Редактировать">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="POST"
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
    <p style="padding: 0.75rem 1.25rem 0">Тегов пока нет...</p>
@endif
