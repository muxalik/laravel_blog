<div class="blog-list-widget">
    <div class="list-group">
        @foreach ($popular_posts as $post)
            <a href="{{ route('posts.single', ['slug' => $post->slug]) }}"
                class="list-group-item list-group-item-action flex-column align-items-start">
                <div class="w-100 justify-content-start">
                    <img src="{{ $post->getImage() }}" alt="" class="img-fluid float-left">
                    <div>
                        <h5 class="mb-1">{{ $post->title }}</h5>
                        <small>{{ $post->getPostDate() }}</small>
                        <small><i class="fa fa-eye"></i>{{ $post->views }}</small>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
