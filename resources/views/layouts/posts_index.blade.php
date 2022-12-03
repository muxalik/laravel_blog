@foreach ($posts as $post)
    <div class="blog-box wow fadeIn" data-aos="zoom-in">
        <div class="post-media">
            <a href="{{ route('posts.single', ['slug' => $post->slug]) }}" title="{{ $post->slug }}">
                <img src="{{ $post->thumbnail }}" alt="" class="img-fluid">
                <div class="hovereffect">
                    <span></span>
                </div>
            </a>
        </div>

        <div class="blog-meta big-meta text-center">
            <div class="post-sharing">
                @include('layouts.share_buttons')
            </div>
            <h4><a href="{{ route('posts.single', ['slug' => $post->slug]) }}"
                    title="{{ $post->slug }}">{{ $post->title }}</a>
            </h4>
            <p>{!! $post->description !!}</p>
            <small><a href="{{ route('categories.single', ['slug' => $post->category->slug]) }}"
                    title="">{{ $post->category->title }}</a></small>
            <small>{{ $post->getPostDate() }}</small>
            <small><i class="fa fa-eye"></i> {{ $post->views }}</small>
        </div>
    </div>

    <hr class="invis">
@endforeach
