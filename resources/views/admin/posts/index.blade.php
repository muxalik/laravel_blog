@extends('admin.layouts.layout')

@section('title', 'Posts Index')

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
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Статьи</a></li>
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
                <h3 class="card-title">Список статей</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                            class="fas fa-expand"></i></button>
                </div>
            </div>

            <div class="card-body table-responsive p-0" id="table">
                @include('admin.posts.table')
            </div>

            <div class="card-footer clearfix" style="">
                <a href="{{ route('posts.create') }}" class="btn btn-primary mb-2 mr-2 my-icon-container">
                    <img src="{{ asset('images/icons/add_1.png') }}" class="my-icon" alt="add">
                    Добавить статью
                </a>
                <button class="btn btn-primary mb-2 mr-2 my-icon-container" id="refresh">
                    <img src="{{ asset('images/icons/refresh_1.png') }}" class="my-icon" alt="refresh">
                    Обновить
                </button>
                @if (count($posts))
                    <form action="{{ route('posts.destroy', ['post' => 'all']) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mb-2 mr-2 my-icon-container" id="deleteAll">
                            <img src="{{ asset('images/icons/delete_1.png') }}" class="my-icon" alt="deleteAll">
                            Удалить все статьи
                        </button>
                    </form>
                @endif
            </div>

        </div>

    </section>

@endsection
