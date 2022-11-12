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
                    <div class="input-group input-group-sm" style="width: 150px;float: left;margin-right: 0.5rem">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search"
                            id="search-text" onkeyup="tableSearch()">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" id="maximize" data-card-widget="maximize"><i
                            class="fas fa-expand"></i></button>
                </div>
            </div>

            <div class="card-body table-responsive p-0" id="table">
                @include('admin.users.table')
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
                @if ($users->count())
                    <form action="{{ route('users.destroy', ['user' => 'all']) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mb-2 mr-2 my-icon-container" id="deleteAll">
                            <img src="{{ asset('images/icons/delete_1.png') }}" class="my-icon" alt="deleteAll">
                            Удалить всех пользователей
                        </button>
                    </form>
                @endif
            </div>

        </div>

    </section>

@endsection
