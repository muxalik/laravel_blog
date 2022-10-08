<div class="link-widget">
    <ul>
        @foreach ($cats as $cat)
            <li><a href="{{ route('categories.single', ['slug' => $cat->slug]) }}">{{ $cat->title }}
                    <span>{{ $cat->posts_count }}</span></a></li>
        @endforeach
    </ul>
</div>
