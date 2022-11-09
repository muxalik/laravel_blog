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
                            <a href="{{ route('posts.single', ['slug' => $post->slug]) }}" title="">
                                <img src="{{ $post->getImage() }}" alt="" class="img-fluid">
                                <div class="hovereffect">
                                    <span></span>
                                </div>
                            </a>
                        </div>
                        <div class="blog-meta big-meta text-center">
                            <div class="post-sharing">
                                <ul class="list-inline share-icon-container">
                                    <li>
                                        <a href="https://vk.com/share.php?url={{ Request::url() }}" class="btn btn-primary"
                                            style="background-color: #1d4393!important; border-radius: 5px !important;">
                                            <img src="{{ asset('images/icons/vk_1.png') }}" alt="vk">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.facebook.com/sharer.php?u={{ Request::url() }}"
                                            class="fb-button btn btn-primary" style="border-radius: 5px !important;">
                                            <img src="{{ asset('images/icons/facebook_1.png') }}" alt="facebook">
                                            <span class="down-mobile">Share on Facebook</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/intent/tweet?text={{ $post->title }}"
                                            class="tw-button btn btn-primary" style="border-radius: 5px !important;">
                                            <img src="{{ asset('images/icons/twitter_1.png') }}" alt="twitter">
                                            <span class="down-mobile">Tweet on Twitter</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <h4><a href="{{ route('posts.single', ['slug' => $post->slug]) }}"
                                    title="">{{ $post->title }}</a></h4>
                            <p>{!! $post->description !!}</p>
                            <small><a href="{{ route('categories.single', ['slug' => $category->slug]) }}"
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
