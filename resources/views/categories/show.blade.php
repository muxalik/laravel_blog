@extends('layouts.category_layout')


@section('title', 'Markedia - ' . $category->title)

@section('page-title')
    <div class="page-title db">
        <div class="container">
            <div class="row" data-aos="zoom-in">
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                    <h2>{{ $category->title }} <small class="hidden-xs-down hidden-sm-down">Nulla felis eros, varius sit amet
                            volutpat non. </small></h2>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $category->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('posts-aos', 'fade-right')

@section('categories-aos', 'fade-right')

@section('content')

    @if ($posts->count())
        <div class="page-wrapper">
            <div class="blog-custom-build">

                @foreach ($posts as $post)
                    <div class="blog-box wow fadeIn" data-aos="zoom-in">
                        <div class="post-media">
                            <a href="{{ route('posts.single', ['post' => $post->slug]) }}" title="{{ $post->slug }}">
                                <img src="{{ $post->thumbnail }}" alt="image" class="img-fluid">
                                <div class="hovereffect">
                                    <span></span>
                                </div>
                            </a>
                        </div>
                        <div class="blog-meta big-meta text-center">
                            <div class="post-sharing">
                                @include('layouts.share_buttons')
                            </div>
                            <h4><a href="{{ route('posts.single', ['post' => $post->slug]) }}"
                                    title="">{{ $post->title }}</a></h4>
                            <p>{!! $post->description !!}</p>
                            <small><a href="{{ route('categories.single', ['category' => $category->slug]) }}"
                                    title="">{{ $category->title }}</a></small>
                            <small>{{ $post->getPostDate() }}</small>
                            <small><i class="fa fa-eye"></i> {{ $post->views }}</small>
                        </div>
                    </div>

                    <hr class="invis">
                @endforeach

            </div>
        </div>

        <hr class="invis">

        <div class="row">
            <div class="col-md-12">
                <nav aria-label="Page navigation">
                    {{ $posts->links() }}
                </nav>
            </div>
        </div>
    @endif

@endsection
