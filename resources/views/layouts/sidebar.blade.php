<div class="sidebar">
    <div class="widget">
        <h2 class="widget-title">Popular Posts</h2>
        <div class="blog-list-widget">
            <div class="list-group">
                @foreach($popular_posts as $post)
                    <a href="{{ route('posts.single', ['slug' => $post->slug]) }}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="w-100 justify-content-between">
                            <img src="{{ $post->getImage() }}" alt="" class="img-fluid float-left">
                            <h5 class="mb-1">{{ $post->title }}</h5>
                            <small>{{ $post->getPostDate() }}</small>
                            <small><i class="fa fa-eye"></i>{{ $post->views }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </div><!-- end blog-list -->
    </div><!-- end widget -->

    <div id="" class="widget">
        <h2 class="widget-title">Advertising</h2>
        <div class="banner-spot clearfix">
            <div class="banner-img">
                <img src="{{ asset('upload/banner_03.jpg') }}" alt="" class="img-fluid">
            </div><!-- end banner-img -->
        </div><!-- end banner -->
    </div><!-- end widget -->

    <div class="widget">
        <h2 class="widget-title">Categories</h2>
        <div class="link-widget">
            <ul>
                @foreach($cats as $cat)
                    <li><a href="{{ route('categories.single', ['slug' => $cat->slug]) }}">{{ $cat->title }} <span>{{ $cat->posts_count }}</span></a></li>
                @endforeach
            </ul>
        </div><!-- end link-widget -->
    </div><!-- end widget -->
</div><!-- end sidebar -->