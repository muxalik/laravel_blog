<div class="link-widget">
    <ul>
        @foreach ($categories as $category)
            <li><a href="{{ route('categories.single', ['slug' => $category->slug]) }}">{{ $category->title }}
                    <span>{{ $category->posts_count }}</span></a></li>
        @endforeach
    </ul>
</div>
