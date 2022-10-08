<ul class="list-inline share-icon-container">
    <li>
        <a href="https://vk.com/share.php?url={{ Request::url() }}" class="btn btn-primary"
            style="background-color: #1d4393!important; border-radius: 5px !important;">
            <img src="{{ asset('images/icons/vk_1.png') }}" alt="vk">
        </a>
    </li>
    <li>
        <a href="https://www.facebook.com/sharer.php?u={{ Request::url() }}" class="fb-button btn btn-primary"
            style="border-radius: 5px !important;">
            <img src="{{ asset('images/icons/facebook_1.png') }}" alt="facebook">
            <span class="down-mobile">Share on Facebook</span>
        </a>
    </li>
    <li>
        <a href="https://twitter.com/intent/tweet?text={{ $post->title }}" class="tw-button btn btn-primary"
            style="border-radius: 5px !important;">
            <img src="{{ asset('images/icons/twitter_1.png') }}" alt="twitter">
            <span class="down-mobile">Tweet on Twitter</span>
        </a>
    </li>
</ul>
