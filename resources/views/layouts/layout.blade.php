<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet"> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/version/marketing.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('mainstyle.css') }}">

</head>
<body>

    <div id="wrapper">
        @include('layouts.header')

        @yield('header')

        <section class="section lb @if (!Request::is('/')) m3rem @endif">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                        @yield('content')
                    </div><!-- end col -->

                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        @include('layouts.sidebar')
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>
        @include('layouts.footer')
        <div class="dmtop">Scroll to Top</div>
        
    </div><!-- end wrapper -->

    <script>

        like = document.getElementById('like');
        dislike = document.getElementById('dislike');

        like.addEventListener('click', () => {
            if (dislike.classList.contains('rateOut')) {
                dislike.classList.remove('rateOut');
                dislike.classList.add('rateIn');
            }

            like.classList.add('rateOut');
            setTimeout(() => {
                like.src = 'http://localhost/images/icons/like_3.png';
            }, 200);

            setTimeout(() => {
                dislike.classList.remove('rateIn');
            }, 500);
        });

        dislike.addEventListener('click', () => {
            if (like.classList.contains('rateOut')) {
                like.classList.remove('rateOut');
                like.classList.add('rateIn');
            }

            dislike.classList.add('rateOut');
            setTimeout(() => {
                dislike.src = 'http://localhost/images/icons/like_2.png';
            }, 200);

            setTimeout(() => {
                like.classList.remove('rateIn');
            }, 500);
        })

    </script>
    
</body>
</html>