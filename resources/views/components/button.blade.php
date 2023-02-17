@props(['text', 'action'])
<button class="btn btn-primary mb-2 mr-2 my-icon-container" id="{{ $action }}">
    <img src="{{ asset("images/icons/{$action}.png") }}" class="my-icon" alt="{{ $action }}">
    {{ $text }}
</button>