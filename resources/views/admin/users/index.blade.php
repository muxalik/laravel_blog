@extends('admin.layouts.layout')

@section('title', 'Users Index')

@section('content')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Пользователи</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Пользователи</a></li>
            <li class="breadcrumb-item active">Главная</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    
    <div class="card card-primary" id="card">
      <div class="card-header border-transparent" style="border-bottom: none">
        <h3 class="card-title">Список пользователей</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
        </div>
      </div>
      
        <div class="card-body table-responsive p-0" id="table">
          @if (count($users))
            <table class="table table-head-fixed table-bordered table-hover">
              <thead>
                <tr>
                  <th style="width: 30px; text-align: center; padding-left: 0.75rem">#</th>
                  <th>Имя</th>
                  <th>Email</th>
                  <th>Регистрация</th>
                  <th>Последнее посещение</th>
                  <th>Статус</th>
                  <th>Действия</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                  <tr>
                    <td style="width: 30px; text-align: center; padding-left: 0.75rem">{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>
                    <td>
                      @if ($user->is_admin)
                        Админ
                      @else
                        Пользователь
                      @endif
                    </td>
                    <td class="table_actions">
                      <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-info btn-sm float-left mr-1" title="Редактировать">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      {{-- <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-info btn-sm float-left mr-1" title="Войти">
                        <i class="fas fa-arrow-circle-right"></i>
                      </a> --}}
                      <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST" class="float-left mr-1" title="Удалить">
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
            <p style="padding: 0.75rem 1.25rem 0">Пользователей пока нет...</p>
          @endif
        </div>
        
        <div class="card-footer clearfix" style="">
          <a href="{{ route('users.create') }}" class="btn btn-primary mb-2 mr-2 my-icon-container">
            <img src="{{ asset('images/icons/add_1.png') }}" class="my-icon" alt="add"> 
            Добавить пользователя
          </a>
          <button class="btn btn-primary mb-2 mr-2 my-icon-container" id="refresh">
            <img src="{{ asset('images/icons/refresh_1.png') }}" class="my-icon" alt="refresh">
            Обновить
          </button>
          @if (count($users))
            <a class="btn btn-danger mb-2 mr-2 my-icon-container" onclick="return confirm('Подтвердите удаление')">
              <img src="{{ asset('images/icons/delete_1.png') }}" class="my-icon" alt="delete"> 
              Удалить всех пользователей
            </a>
          @endif
        </div>
      
    </div>

  </section>

@endsection