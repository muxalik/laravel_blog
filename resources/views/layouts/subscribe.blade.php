<div class="newsletter-widget text-center align-self-center">
    <h3>Subscribe Today!</h3>
    <p>Subscribe to our weekly Newsletter and receive updates via email.</p>
    <form action="{{ route('newsletter') }}" class="form-inline" method="POST">
        @csrf
        <input type="text" name="email" placeholder="Add your email here.." required class="form-control"
            value="{{ auth()->user()?->email ?? '' }}" />
        <input type="submit" value="Subscribe" class="btn btn-default btn-block" />
    </form>
</div><!-- end newsletter -->
