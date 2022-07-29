@extends('admin.layouts.layout')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Статьи</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    
    <div class="card">
      <div class="card-header border-transparent" style="border-bottom: none">
        <h3 class="card-title">Список статей</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      
        <div class="card-body table-responsive p-0" style="max-height: calc(100vh - 355px)">
          @if (count($posts))
            <table class="table table-head-fixed table-bordered table-hover text-nowrap">
              <thead>
                <tr>
                  <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                  <th>Название</th>
                  <th>Категория</th>
                  <th>Теги</th>
                  <th>Дата</th>
                  <th>Действия</th>
                </tr>
              </thead>
              <tbody>
                @foreach($posts as $post)
                  <tr data-widget="expandable-table" aria-expanded="false">
                    <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->title }}</td>
                    <td>{{ $post->tags->pluck('title')->join(', ') }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                      <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-info btn-sm float-left mr-1"><i class="fas fa-pencil-alt"></i></a>
                      <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" class="float-left">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Подтвердите удаление')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                  <tr class="expandable-body">
                    <td colspan="6">
                      <p>
                      {{ $post->id }}
                      </p>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else 
            <p style="padding: 0.75rem 1.25rem 0">Статей пока нет...</p>
          @endif
        </div>
        
        <div class="card-footer clearfix" style="">
          <a href="{{ route('posts.create') }}" class="btn btn-primary mb-2 mr-2">
            <i class="ion ion-plus-round" style="margin-right: 0.35rem"></i> 
            Добавить статью
          </a>
          @if (count($posts))
            <a href="" class="btn btn-danger mb-2 mr-2" onclick="return confirm('Подтвердите удаление')">
              <i class="ion ion-nuclear" style="margin-right: 0.35rem"></i> 
              Удалить все статьи
            </a>
          @endif
        </div>
      
    </div>

  </section>

@endsection