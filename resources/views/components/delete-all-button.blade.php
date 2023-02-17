@props(['text'])
<button type="submit" class="btn btn-danger mb-2 mr-2 my-icon-container" id="deleteAll">
    <img src="{{ asset('images/icons/delete.png') }}" class="my-icon" alt="deleteAll">
    {{ $text }}
</button>