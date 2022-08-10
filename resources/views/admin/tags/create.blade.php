@extends('admin.layouts.layout')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Добавление тега</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Теги</a></li>
            <li class="breadcrumb-item active">Создание</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Добавление тега</h3>
                    </div>

                    <form role="form" method="POST" action="{{ route('tags.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Название</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Название">
                            </div>
                        </div>
                        <div class="card-footer">
                          <button type="submit" class="btn btn-primary mb-2 mr-2 my-icon-container">
                            <img src="{{ asset('images/icons/save_1.png') }}" class="my-icon"> 
                            Сохранить
                          </button>
                          <a href="{{ route('tags.index') }}" class="btn btn-danger mb-2 mr-2 my-icon-container">
                            <img src="{{ asset('images/icons/cancel_1.png') }}" class="my-icon" alt="cancel"> 
                            Отменить
                          </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
@endsection