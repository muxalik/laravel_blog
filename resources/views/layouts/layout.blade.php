<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">

<title>@yield('title')</title>

<link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

@vite(['resources/assets/admin/plugins/fontawesome-free/css/all.min.css'])

<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('style.css') }}" rel="stylesheet">
<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('css/colors.css') }}" rel="stylesheet">
<link href="{{ asset('css/version/marketing.css') }}" rel="stylesheet">
<link href="{{ asset('mainstyle.css') }}" rel="stylesheet">

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

@yield('links')

</head>

<body>

    <div id="wrapper">
        @include('layouts.header')
        @yield('header')

        <section class="section lb @if (!request()->is('/')) m3rem @endif" id="main-section">
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

</body>

</html>
