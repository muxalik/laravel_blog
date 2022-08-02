@extends('layouts.layout')

@section('title', 'Markedia - ' . $post->title)

@section('content')
<div class="page-wrapper">
    <div class="blog-title-area">
        <ol class="breadcrumb hidden-xs-down">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.single', ['slug' => $post->category->slug]) }}">{{ $post->category->title }}</a></li>
            <li class="breadcrumb-item active">{{ $post->title }}</li>
        </ol>

        <span class="color-yellow"><a href="{{ route('categories.single', ['slug' => $post->category->slug]) }}" title="">{{ $post->category->title }}</a></span>

        <h3>{{ $post->title }}</h3>

        <div class="blog-meta big-meta">
            <small>{{ $post->getPostDate() }}</small>
            <small><i class="fa fa-eye"></i> {{ $post->views }}</small>
        </div><!-- end meta -->

        <div class="post-sharing">
            <ul class="list-inline">
                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
            </ul>
        </div><!-- end post-sharing -->
    </div><!-- end title -->

    <div class="single-post-media">
        <img src="{{ $post->getImage() }}" alt="" class="img-fluid">
    </div><!-- end media -->

    <div class="blog-content">  
        {!! $post->content !!}
    </div><!-- end content -->

    <div class="blog-title-area">
        @if ($post->tags->count())
            <div class="tag-cloud-single">
                <span>Tags</span>
                @foreach ($post->tags as $tag)
                    <small><a href="{{ route('tags.single', ['slug' => $tag->slug]) }}" title="">{{ $tag->title }}</a></small>
                @endforeach
            </div><!-- end meta -->
        @endif

        <div class="post-sharing">
            <ul class="list-inline">
                <li class="mr-2">
                    <img src="{{ asset('images/icons/like_1.png') }}" alt="like" class="rating-img" id="like">
                    <span>{{ $post->likes }} Likes</span>
                </li>
                <li class="mr-2">
                    <img src="{{ asset('images/icons/like_1.png') }}" alt="dislike" class="rating-img" id="dislike">
                    <span>{{ $post->dislikes }} Dislikes</span>
                </li>
            </ul>
            <ul class="list-inline">
                <li><a href="#" class="fb-button btn btn-primary"><i class="fa fa-facebook"></i> <span class="down-mobile">Share on Facebook</span></a></li>
                <li><a href="#" class="tw-button btn btn-primary"><i class="fa fa-twitter"></i> <span class="down-mobile">Tweet on Twitter</span></a></li>
                <li><a href="#" class="gp-button btn btn-primary"><i class="fa fa-google-plus"></i></a></li>
            </ul>
        </div><!-- end post-sharing -->
    </div><!-- end title -->

    <hr class="invis1">

    <div class="custombox clearfix">
        <h4 class="small-title">You may also like</h4>
        <div class="row">
            <div class="col-lg-6">
                <div class="blog-box">
                    <div class="post-media">
                        <a href="marketing-single.html" title="">
                            <img src="{{ asset('upload/market_blog_02.jpg') }}" alt="" class="img-fluid">
                            <div class="hovereffect">
                                <span class=""></span>
                            </div><!-- end hover -->
                        </a>
                    </div><!-- end media -->
                    <div class="blog-meta">
                        <h4><a href="marketing-single.html" title="">We are guests of ABC Design Studio</a></h4>
                        <small><a href="blog-category-01.html" title="">Trends</a></small>
                        <small><a href="blog-category-01.html" title="">21 July, 2017</a></small>
                    </div><!-- end meta -->
                </div><!-- end blog-box -->
            </div><!-- end col -->

            <div class="col-lg-6">
                <div class="blog-box">
                    <div class="post-media">
                        <a href="marketing-single.html" title="">
                            <img src="{{ asset('upload/market_blog_03.jpg') }}" alt="" class="img-fluid">
                            <div class="hovereffect">
                                <span class=""></span>
                            </div><!-- end hover -->
                        </a>
                    </div><!-- end media -->
                    <div class="blog-meta">
                        <h4><a href="marketing-single.html" title="">Nostalgia at work with family</a></h4>
                        <small><a href="blog-category-01.html" title="">News</a></small>
                        <small><a href="blog-category-01.html" title="">20 July, 2017</a></small>
                    </div><!-- end meta -->
                </div><!-- end blog-box -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end custom-box -->

    <hr class="invis1">

    <div class="custombox clearfix">
        <h4 class="small-title">3 Comments</h4>
        <div class="row">
            <div class="col-lg-12">
                <div class="comments-list">
                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="{{ asset('upload/author.jpg') }}" alt="" class="rounded-circle">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading user_name">Amanda Martines <small>5 days ago</small></h4>
                            <p>Exercitation photo booth stumptown tote bag Banksy, elit small batch freegan sed. Craft beer elit seitan exercitation, photo booth et 8-bit kale chips proident chillwave deep v laborum. Aliquip veniam delectus, Marfa eiusmod Pinterest in do umami readymade swag. Selfies iPhone Kickstarter, drinking vinegar jean.</p>
                            <a href="#" class="btn btn-primary btn-sm">Reply</a>
                        </div>
                    </div>
                    <div class="media">
                        <a class="media-left" href="#">
                            <img src="{{ asset('upload/author_01.jpg') }}" alt="" class="rounded-circle">
                        </a>
                        <div class="media-body">

                            <h4 class="media-heading user_name">Baltej Singh <small>5 days ago</small></h4>

                            <p>Drinking vinegar stumptown yr pop-up artisan sunt. Deep v cliche lomo biodiesel Neutra selfies. Shorts fixie consequat flexitarian four loko tempor duis single-origin coffee. Banksy, elit small.</p>

                            <a href="#" class="btn btn-primary btn-sm">Reply</a>
                        </div>
                    </div>
                    <div class="media last-child">
                        <a class="media-left" href="#">
                            <img src="{{ asset('upload/author_02.jpg') }}" alt="" class="rounded-circle">
                        </a>
                        <div class="media-body">

                            <h4 class="media-heading user_name">Marie Johnson <small>5 days ago</small></h4>
                            <p>Kickstarter seitan retro. Drinking vinegar stumptown yr pop-up artisan sunt. Deep v cliche lomo biodiesel Neutra selfies. Shorts fixie consequat flexitarian four loko tempor duis single-origin coffee. Banksy, elit small.</p>

                            <a href="#" class="btn btn-primary btn-sm">Reply</a>
                        </div>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end custom-box -->

    <hr class="invis1">

    <div class="custombox clearfix">
        <h4 class="small-title">Leave a Reply</h4>
        <div class="row">
            <div class="col-lg-12">
                <form class="form-wrapper">
                    <input type="text" class="form-control" placeholder="Your name">
                    <input type="text" class="form-control" placeholder="Email address">
                    <input type="text" class="form-control" placeholder="Website">
                    <textarea class="form-control" placeholder="Your comment"></textarea>
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- end page-wrapper -->
@endsection