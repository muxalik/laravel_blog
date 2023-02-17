@props(['text', 'url'])
<a href="{{ $url }}" class="btn btn-primary mb-2 mr-2 my-icon-container">
    <img src="{{ asset('images/icons/add.png') }}" class="my-icon">
    {{ $text }}
</a>
