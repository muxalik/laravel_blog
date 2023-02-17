@extends('admin.layouts.layout')


@section('title', 'Messages Index')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Сообщения</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Сообщения</a></li>
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
                <h3 class="card-title">Список сообщений</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                            class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                            class="fas fa-expand"></i></button>
                </div>
            </div>

            <div class="card-body table-responsive p-0" id="table">
                @include('admin.messages.table')
            </div>

            <div class="card-footer clearfix">
                <form action="{{ route('messages.markAllAsRead') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <x-button text="Отметить прочитанными" action="read" />
                </form>
                <form action="{{ route('messages.markAllAsUnread') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <x-button text="Отметить непрочитанными" action="unread" />
                </form>
                <x-button text="Обновить" action="refresh" />
                @if ($messages->count())
                    <form action="{{ route('messages.destroy', ['id' => 'all']) }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <x-delete-all-button text="Удалить все сообщения" />
                    </form>
                @endif
            </div>

        </div>

    </section>

@endsection
