@extends('admin.layouts.layout')

@section('title', 'Tags Index')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Теги</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('tags.index') }}">Теги</a></li>
            <li class="breadcrumb-item active">Главная</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    
    <div class="card card-primary" id="card">
      <div class="card-header border-transparent" style="border-bottom: none">
        <h3 class="card-title">Список тегов</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
      </div>
      
      <div class="card-body table-responsive p-0" id="table">
        @if (count($tags))
          <table class="table table-head-fixed table-bordered table-hover">
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
              @foreach($tags as $tag)
                <tr>
                  <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $tag->id }}</td>
                  <td>{{ $tag->title }}</td>
                  <td>{{ $tag->slug }}</td>
                  <td>{{ $tag->posts->count('id') }}</td>
                  <td class="table_actions">
                    <a href="{{ route('tags.edit', ['tag' => $tag->id]) }}" class="btn btn-info btn-sm float-left mr-1"><i class="fas fa-pencil-alt"></i></a>
                    <form action="{{ route('tags.destroy', ['tag' => $tag->id]) }}" method="POST" class="float-left">
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
          <p style="padding: 0.75rem 1.25rem 0">Тегов пока нет...</p>
        @endif
      </div>
        
      <div class="card-footer clearfix" style="">
        <a href="{{ route('tags.create') }}" class="btn btn-primary mb-2 mr-2 my-icon-container">
          <img src="{{ asset('images/icons/add_1.png') }}" class="my-icon" alt="add"> 
          Добавить тег
        </a>
        <button class="btn btn-primary mb-2 mr-2 my-icon-container" id="refresh">
          <img src="{{ asset('images/icons/refresh_1.png') }}" class="my-icon" alt="refresh">
          Обновить
        </button>
        @if (count($tags))
          <form action="{{ route('tags.destroy', ['tag' => 'all']) }}" method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger mb-2 mr-2 my-icon-container" id="deleteAll">
              <img src="{{ asset('images/icons/delete_1.png') }}" class="my-icon" alt="deleteAll"> 
              Удалить все теги
            </button>
          </form>
        @endif
      </div>
      
    </div>

  </section>

@endsection