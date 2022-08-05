@extends('layouts.layout')


@section('title', 'Markedia - Home')

@section('header')

    <section id="cta" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 align-self-center" data-aos="zoom-in">
                    <h2>A digital marketing blog</h2>
                    <p class="lead"> Aenean ut hendrerit nibh. Duis non nibh id tortor consequat cursus at mattis felis. Praesent sed lectus et neque auctor dapibus in non velit. Donec faucibus odio semper risus rhoncus rutrum. Integer et ornare mauris.</p>
                    <a href="#" class="btn">Try for free</a>
                </div>
                <div class="col-lg-4 col-md-12" data-aos="fade-left">
                    <div class="newsletter-widget text-center align-self-center">
                        <h3>Subscribe Today!</h3>
                        <p>Subscribe to our weekly Newsletter and receive updates via email.</p>
                        <form class="form-inline" method="post">
                            <input type="text" name="email" placeholder="Add your email here.." required class="form-control" />
                            <input type="submit" value="Subscribe" class="btn btn-default btn-block" />
                        </form>         
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection

@section('posts-aos', 'fade-left')

@section('categories-aos', 'fade-left')

@section('content')

    @if ($posts->count())
        <div class="page-wrapper">
            <div class="blog-custom-build">

                @foreach($posts as $post)
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
                                <ul class="list-inline">
                                    <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                                    <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                                    <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                            <h4><a href="{{ route('posts.single', ['slug' => $post->slug]) }}" title="">{{ $post->title }}</a></h4>
                            <p>{!! $post->description !!}</p>
                            <small><a href="{{ route('categories.single', ['slug' => $post->category->slug]) }}" title="">{{ $post->category->title }}</a></small>
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
                <nav aria-label="Page navigation" data-aos="fade-left">
                    {{ $posts->links() }}
                </nav>
            </div>
        </div>

    @endif

@endsection