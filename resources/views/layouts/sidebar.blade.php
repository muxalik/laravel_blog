<div class="sidebar">
    <div class="widget" data-aos="@yield('posts-aos')">
        <h2 class="widget-title">Popular Posts</h2>
        @include('layouts.popular_posts')
    </div><!-- end widget -->

    <div class="widget" data-aos="@yield('categories-aos')">
        <h2 class="widget-title">Categories</h2>
        @include('layouts.categories')
    </div><!-- end widget -->
</div><!-- end sidebar -->
