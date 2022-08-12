@extends('admin.layouts.layout')


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
    
    <div class="card card-primary" id="card">
      <div class="card-header border-transparent" style="border-bottom: none">
        <h3 class="card-title">Список категорий</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
      </div>
      
      @include('admin.categories.card_body')
        
      <div class="card-footer clearfix" style="">
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-2 mr-2 my-icon-container">
          <img src="{{ asset('images/icons/add_1.png') }}" class="my-icon"> 
          Добавить категорию
        </a>
        <button class="btn btn-primary mb-2 mr-2 my-icon-container" id="refresh">
          <img src="{{ asset('images/icons/refresh_1.png') }}" class="my-icon" alt="refresh">
          Обновить
        </button>
        @if (count($categories))
          <a class="btn btn-danger mb-2 mr-2 my-icon-container" onclick="return confirm('Подтвердите удаление')">
            <img src="{{ asset('images/icons/delete_1.png') }}" class="my-icon"> 
            Удалить все категории
          </a>
        @endif
      </div>
      
    </div>

  </section>

@endsection