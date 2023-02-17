@if ($categories->count())
    <table class="table table-head-fixed table-bordered table-hover" id="table-info">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                <th>Наименование</th>
                <th>Slug</th>
                <th>Кол-во статей</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $category->id }}</td>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->posts()->count('id') }}</td>
                    <td class="pr-2">
                        <div class="table_actions">
                            <a href="{{ route('categories.edit', ['category' => $category->id]) }}"
                                class="btn btn-info btn-sm table-action" title="Редактировать">
                                <img src="{{ asset('images/icons/edit.png') }}" class="my-icon" alt="Редактировать">
                            </a>
                            <form action="{{ route('categories.destroy', ['category' => $category->id]) }}"
                                method="POST" class="float-left table-action" title="Удалить">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm table-action delete">
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
    <p style="padding: 0.75rem 1.25rem 0">Категорий пока нет...</p>
@endif
