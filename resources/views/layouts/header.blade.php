<header class="market-header header">
    <div class="container-fluid">
        <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/version/market-logo.png') }}" alt="home" data-aos="zoom-in"></a>
            <div class="collapse navbar-collapse" id="navbarCollapse" data-aos="zoom-in">
                <ul class="navbar-nav mr-auto">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('categories.single', ['slug' => $category->slug]) }}">{{ $category->title }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.create') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.create') }}">Register</a>
                        </li>
                    @endif
                    @if (Auth::check() && Auth::user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">Admin</a>
                        </li>
                    @endif
                </ul>
                <form class="form-inline" method="GET" action="{{ route('search') }}">
                    <input name="s" class="form-control mr-sm-2 @error('s') is-invalid @enderror" type="text" placeholder="How may I help?" required>
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
</header>