
<div class="card-body table-responsive p-0">
  @if (count($categories))
    <table class="table table-head-fixed table-bordered table-hover">
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
        @foreach($categories as $category)
          <tr>
            <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $category->id }}</td>
            <td>{{ $category->title }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->posts()->count('id') }}</td>
            <td class="table_actions">
              <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn btn-info btn-sm float-left mr-1">
                <i class="fas fa-pencil-alt"></i>
              </a>
              <form action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="POST" class="float-left">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Подтвердите удаление')">
                    <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else 
    <p style="padding: 0.75rem 1.25rem 0">Категорий пока нет...</p>
  @endif
</div>
