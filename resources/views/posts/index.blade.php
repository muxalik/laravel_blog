@extends('layouts.layout')


@section('title', 'Markedia - Home')

@section('header')

    <section id="cta" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 align-self-center" data-aos="zoom-in">
                    <h2>A digital marketing blog</h2>
                    <p class="lead"> Aenean ut hendrerit nibh. Duis non nibh id tortor consequat cursus at mattis felis.
                        Praesent sed lectus et neque auctor dapibus in non velit. Donec faucibus odio semper risus rhoncus
                        rutrum. Integer et ornare mauris.</p>
                    <a href="#" class="btn">Try for free</a>
                </div>
                <div class="col-lg-4 col-md-12" data-aos="fade-left">
                    @include('layouts.subscribe')
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
                @include('layouts.posts_index')
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
