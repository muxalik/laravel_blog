@extends('admin.layouts.layout')

{{-- @section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Категории</h1>
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

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Список категорий</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="card-body">
            <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Добавить категорию</a>

            @if (count($categories))
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>Наименование</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->title }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn btn-info btn-sm float-left mr-1"><i class="fas fa-pencil-alt"></i></a>
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
            </div>
            @else 
                <p>Категорий пока нет...</p>
            @endif

        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer clearfix">
        {{ $categories->links() }}
      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
@endsection --}}

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Категории</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Категории</a></li>
            <li class="breadcrumb-item active">Главная</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    
    <div class="card">
      <div class="card-header border-transparent" style="border-bottom: none">
        <h3 class="card-title">Список категорий</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          {{-- <button type="button" class="btn btn-tool" data-card-widget="maximize">
            <i class="fas fa-expand"></i>
          </button> --}}
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      
      @include('admin.categories.card_body')
        
      <div class="card-footer clearfix" style="">
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-2 mr-2 my-icon-container">
          <img src="../../images/icons/add_1.png" class="my-icon"> 
          Добавить категорию
        </a>
        <button class="btn btn-primary mb-2 mr-2 my-icon-container" id="refresh" data-source="{{ route('categories.refresh') }}" data-card-widget="card-refresh">
          <img src="{{ asset('images/icons/refresh_1.png') }}" class="my-icon" alt="refresh">
          Обновить
        </button>
        @if (count($categories))
          <a class="btn btn-danger mb-2 mr-2 my-icon-container" onclick="return confirm('Подтвердите удаление')">
            <img src="../../images/icons/delete_1.png" class="my-icon"> 
            Удалить все категории
          </a>
        @endif
      </div>
      
    </div>

  </section>

@endsection