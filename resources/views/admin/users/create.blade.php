@extends('admin.layouts.layout')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Добавление пользователя</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Пользователи</a></li>
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
                        <h3 class="card-title">Добавление пользователя</h3>
                    </div>

                    <form role="form" method="POST" action="{{ route('users.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Имя</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Имя">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Повторите пароль</label>
                                <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" placeholder="Повторите пароль">
                            </div>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="check" class="custom-control-input" id="check">
                              <label class="custom-control-label" for="check">Войти после сохранения</label>
                            </div>
                        </div>
                        <div class="card-footer">
                          <button type="submit" class="btn btn-primary mb-2 mr-2 my-icon-container">
                            <img src="{{ asset('images/icons/save_1.png') }}" class="my-icon"> 
                            Сохранить
                          </button>
                          <a href="{{ route('users.index') }}" class="btn btn-danger mb-2 mr-2 my-icon-container">
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