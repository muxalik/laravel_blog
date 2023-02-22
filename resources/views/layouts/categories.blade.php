<div class="link-widget">
    <ul>
        @forelse ($categories as $category)
            <li><a href="{{ route('categories.single', ['category' => $category->slug]) }}">{{ $category->title }}
                    <span>{{ $category->posts_count }}</span></a></li>
        @empty
            <p>Nothing here...</p>
        @endforelse
    </ul>
</div>
