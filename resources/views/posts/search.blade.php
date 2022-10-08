@extends('layouts.category_layout')


@section('title', 'Markedia - Search')

@section('page-title')

    <div class="page-title db">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h2>{{ $s }} <small class="hidden-xs-down hidden-sm-down">Nulla felis eros, varius sit amet
                            volutpat non. </small></h2>
                </div><!-- end col -->
                <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Search</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <div class="page-wrapper">
        <div class="blog-custom-build" id="search-block">

            @if ($posts->count())
                @include('layouts.posts_index')
            @else
                По вашему запросу ничего не найдено...
            @endif
        </div>
    </div>

    <hr class="invis">

    <div class="row">
        <div class="col-md-12">
            <nav aria-label="Page navigation">
                {{ $posts->appends(['s' => request()->s])->links() }}
            </nav>
        </div>
    </div>

@endsection
