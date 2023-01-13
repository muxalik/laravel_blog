@extends('layouts.layout')


@section('title', 'Markedia - ' . $post->title)

@section('posts-aos', 'fade-left')

@section('categories-aos', 'fade-left')

@section('content')

    <div class="page-wrapper">
        <div class="blog-title-area" data-aos="zoom-in">
            <ol class="breadcrumb hidden-xs-down">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('categories.single', ['slug' => $post->category->slug]) }}">{{ $post->category->title }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $post->title }}</li>
            </ol>
            <span class="color-yellow"><a href="{{ route('categories.single', ['slug' => $post->category->slug]) }}"
                    title="">{{ $post->category->title }}</a></span>
            <h3>{{ $post->title }}</h3>
            <div class="blog-meta big-meta">
                <small>{{ $post->getPostDate() }}</small>
                <small><i class="fa fa-eye"></i> <span id="views_count" class="d-inline">{{ $post->views }}</span></small>
            </div><!-- end meta -->
            <div class="post-sharing">
                <ul class="list-inline share-icon-container">
                    <li>
                        <a href="https://vk.com/share.php?url={{ url()->current() }}" class="btn btn-primary"
                            style="background-color: #1d4393!important; border-radius: 5px !important;">
                            <img src="{{ asset('images/icons/vk_1.png') }}" alt="vk">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/sharer.php?u={{ url()->current() }}"
                            class="fb-button btn btn-primary" style="border-radius: 5px !important;">
                            <img src="{{ asset('images/icons/facebook_1.png') }}" alt="facebook">
                            <span class="down-mobile">Share on Facebook</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/intent/tweet?text={{ url()->current() }}"
                            class="tw-button btn btn-primary" style="border-radius: 5px !important;">
                            <img src="{{ asset('images/icons/twitter_1.png') }}" alt="twitter">
                            <span class="down-mobile">Tweet on Twitter</span>
                        </a>
                    </li>
                </ul>
            </div><!-- end post-sharing -->
        </div><!-- end title -->

        <div class="single-post-media" data-aos="zoom-in">
            <img src="{{ $post->thumbnail }}" alt="" class="img-fluid">
        </div><!-- end media -->

        <div class="blog-content" data-aos="zoom-in">
            {!! $post->content !!}
        </div><!-- end content -->

        <div class="blog-title-area" data-aos="fade-left">

            @if ($post->tags->count())
                <div class="tag-cloud-single">
                    <span>Tags</span>
                    @foreach ($post->tags as $tag)
                        <small><a href="{{ route('tags.single', ['slug' => $tag->slug]) }}"
                                title="">{{ $tag->title }}</a></small>
                    @endforeach
                </div>
            @endif

            <div class="post-sharing">
                <ul class="list-inline">
                    <li class="mr-2">
                        <img src="{{ asset('images/icons/like_1.png') }}" alt="like" class="rating-img" id="like">
                        <span id="likes_count">{{ $post->likes }} </span>
                        <span>Likes</span>
                    </li>
                    <li class="mr-2">
                        <img src="{{ asset('images/icons/like_1.png') }}" alt="dislike" class="rating-img" id="dislike">
                        <span id="dislikes_count">{{ $post->dislikes }} </span>
                        <span>Dislikes</span>
                    </li>
                </ul>
                @include('layouts.share_buttons')
            </div><!-- end post-sharing -->
        </div><!-- end title -->

        <hr class="invis1">

        <div class="custombox clearfix" data-aos="zoom-in">
            <h4 class="small-title">You may also like</h4>
            <div class="row">

                @forelse ($similar as $sim_post)
                    <div class="col-lg-6">
                        <div class="blog-box">
                            <div class="post-media">
                                <a href="{{ route('posts.single', ['slug' => $sim_post->slug]) }}" title="">
                                    <img src="{{ $sim_post->thumbnail }}" alt="post_image" class="img-fluid">
                                    <div class="hovereffect">
                                        <span class=""></span>
                                    </div><!-- end hover -->
                                </a>
                            </div><!-- end media -->
                            <div class="blog-meta">
                                <h4><a href="{{ route('posts.single', ['slug' => $sim_post->slug]) }}"
                                        title="{{ $sim_post->title }}">{{ $sim_post->title }}</a></h4>
                                <small><a href="blog-category-01.html"
                                        title="{{ $sim_post->category->title }}">{{ $sim_post->category->title }}</a></small>
                                <small>{{ $sim_post->getPostDate() }}</small>
                            </div><!-- end meta -->
                        </div><!-- end blog-box -->
                    </div><!-- end col -->
                @empty
                @endforelse

            </div><!-- end row -->
        </div><!-- end custom-box -->

        <hr class="invis1">

        @if ($comments->count())
            <div class="custombox clearfix" data-aos="zoom-in">
                <h4 class="small-title">{{ $amount }} Comments</h4>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="comments-list" id="comments-list">
                            @include('posts.comments')
                        </div>

                        @if ($comments->count() < $amount)
                            <div class="d-flex justify-content-center mt-4">
                                <button class="btn btn-primary" id="loadMore" style="cursor: pointer">Load more</button>
                            </div>
                        @endif

                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end custom-box -->
        @endif

        <hr class="invis1">

        <div class="custombox clearfix" data-aos="zoom-in" id="reply">
            <h4 class="small-title">Leave a Reply</h4>
            <div class="row">
                <div class="col-lg-12">
                    <form class="form-wrapper" action="{{ route('comments.store', $post->id) }}" method="POST">
                        @csrf
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" placeholder="Your comment"></textarea>
                        <button type="submit" class="btn btn-primary" style="cursor: pointer">Submit Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- end page-wrapper -->

    <script type="module">

    import { CountUp } from '/js/countUp.min.js';

    window.onload = function() {
        new CountUp('views_count', {{ $post->views }}, { enableScrollSpy: true })
            .handleScroll();

        new CountUp('likes_count', {{ $post->likes }}, { enableScrollSpy: true })
            .handleScroll();

        new CountUp('dislikes_count', {{ $post->dislikes }}, { enableScrollSpy: true })
            .handleScroll();
    }

    let like = document.getElementById('like');
    let dislike = document.getElementById('dislike');
    let likeCount = document.getElementById('likes_count');
    let dislikeCount = document.getElementById('dislikes_count');
    let liked, disliked;

    like.addEventListener('click', () => {
        if (liked) {
            likeCount.textContent = +likeCount.textContent - 1;
            like.classList.add('rateIn');
            liked = false;
            return;
        }

        if (disliked) {
            dislikeCount.textContent = +dislikeCount.textContent - 1; 
            disliked = false;
        }

        if (dislike.classList.contains('rateOut')) {
            dislike.classList.remove('rateOut');
            dislike.classList.add('rateIn');
        }

        if (like.classList.contains('rateIn')) 
            like.classList.remove('rateIn');
            
        like.classList.add('rateOut');
        setTimeout(() => {
            like.src = 'http://localhost/images/icons/like_3.png';
        }, 200);

        setTimeout(() => {
            dislike.classList.remove('rateIn');
        }, 500);

        likeCount.textContent = +likeCount.textContent + 1; 
        liked = true

        console.log('Likes ' + {{ $post->likes }} + ' ' + likeCount.textContent)
    });

    dislike.addEventListener('click', () => {
        if (disliked) {
            dislikeCount.textContent = +dislikeCount.textContent - 1;
            dislike.classList.add('rateIn');
            disliked = false;
            return;
        }

        if (liked) { 
            likeCount.textContent = +likeCount.textContent - 1; 
            liked = false;
        }

        if (like.classList.contains('rateOut')) {
            like.classList.remove('rateOut');
            like.classList.add('rateIn');
        }

        if (dislike.classList.contains('rateIn')) 
            dislike.classList.remove('rateIn');
            
        dislike.classList.add('rateOut');
        setTimeout(() => {
            dislike.src = 'http://localhost/images/icons/like_2.png';
        }, 200);

        setTimeout(() => {
            like.classList.remove('rateIn');
        }, 500);

        dislikeCount.textContent = +dislikeCount.textContent + 1; 
        disliked = true
        console.log('Dislikes' + {{ $post->dislikes }})
    });


    let page = 2;
    let amount = {{ $amount }};

    $('#loadMore').on('click', () => {
        load_more(page);
        page++;
    })

    function load_more(page) {
        $.ajax({
          url: "{{ route('comments.loadmore', ['post_id' => $post->id]) }}" + "?page=" + page,
          type: "get",
          datatype: "json"
        })
        .done(function(data)
        {
            $("#comments-list").append(data);
            if (amount == $('.media').length)
                $('#loadMore').remove()
        });
    }

</script>

@endsection
