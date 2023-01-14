<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="widget" data-aos="zoom-in-right">
                    <h2 class="widget-title">Recent Posts</h2>
                    <div class="blog-list-widget">
                        <div class="list-group">
                            @forelse ($recent_posts as $post)
                                <a href="{{ route('posts.single', ['slug' => $post->slug]) }}"
                                    class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="w-100">
                                        <img src="{{ $post->thumbnail }}" alt="recent_post"
                                            class="img-fluid float-left">
                                        <div>
                                            <h5 class="mb-1">{{ $post->title }}</h5>
                                            <span>
                                                <small>{{ $post->getPostDate() }}</small>
                                                <span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p>Nothing here...</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="widget" data-aos="zoom-in">
                    <h2 class="widget-title">Popular Posts</h2>
                    @include('layouts.popular_posts')
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="widget" data-aos="zoom-in-left">
                    <h2 class="widget-title">Categories</h2>
                    @include('layouts.categories')
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    AOS.init({
        duration: 500,
    });
</script>
