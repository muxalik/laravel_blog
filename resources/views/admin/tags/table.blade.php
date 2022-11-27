@if ($tags->count())
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
                    <td class="pr-2">
                        <div class="table_actions">
                            <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}"
                                class="btn btn-info btn-sm table-action" title="Редактировать">
                                <img src="{{ asset('images/icons/edit_1.png') }}" class="my-icon" alt="Редактировать">
                            </a>
                            <form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="POST"
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
    <p style="padding: 0.75rem 1.25rem 0">Тегов пока нет...</p>
@endif
