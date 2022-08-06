<!DOCTYPE html>
<html lang="en">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Markedia - Contact</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet"> 
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="css/colors.css" rel="stylesheet">
    <link href="css/version/marketing.css" rel="stylesheet">
    <link href="{{ asset('css/aos.css') }}" rel="stylesheet">
    <script src="{{ asset('js/aos.js') }}"></script>

</head>
<body>

    <div id="wrapper">
        @include('layouts.header')
        <div class="page-title db">
            <div class="container">
                <div class="row" data-aos="zoom-in">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <h2>Contact <small class="hidden-xs-down hidden-sm-down">Nulla felis eros, varius sit amet volutpat non. </small></h2>
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 hidden-xs-down hidden-sm-down">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Contact</li>
                        </ol>
                    </div><!-- end col -->                    
                </div><!-- end row -->
            </div><!-- end container -->
        </div><!-- end page-title -->

        <section class="section lb">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <div class="sidebar" data-aos="fade-right">
                            <div class="widget-no-style">
                                <div class="newsletter-widget text-center align-self-center">
                                    <h3>Subscribe Today!</h3>
                                    <p>Subscribe to our weekly Newsletter and receive updates via email.</p>
                                    <form class="form-inline" method="post">
                                        <input type="text" name="email" placeholder="Add your email here.." required class="form-control" />
                                        <input type="submit" value="Subscribe" class="btn btn-default btn-block" />
                                    </form>         
                                </div><!-- end newsletter -->
                            </div>
                        </div><!-- end sidebar -->
                    </div><!-- end col -->
                    
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" data-aos="fade-left">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4>Who we are</h4>
                                    <p>Markedia is a personal blog for handcrafted, cameramade photography content, fashion styles from independent creatives around the world.</p>
                                </div>

                                <div class="col-lg-6">
                                    <h4>How we help?</h4>
                                    <p>If you’d like to write for us, <a href="#">advertise with us</a> or just say hello, fill out the form below and we’ll get back to you as soon as possible.</p>
                                </div>
                            </div><!-- end row -->

                            <hr class="invis">

                            <div class="row">
                                <div class="col-lg-12">

                                    @if ($errors->any())
                                        <ul class="alert alert-danger pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <form class="form-wrapper" method="POST" action="{{ route('contact.store') }}">
                                        @csrf
                                        <h4>Contact form</h4>
                                        <input type="text" class="form-control @error('name')is-invalid @enderror" placeholder="Your name" name="name" id="name" value="{{ old('name') }}">
                                        <input type="text" class="form-control @error('email')is-invalid @enderror" placeholder="Email" name="email" id="email" value="{{ old('email') }}">
                                        <input type="tel" class="form-control @error('phone')is-invalid @enderror" placeholder="Phone" name="phone" id="phone" value="{{ old('phone') }}">
                                        <input type="text" class="form-control @error('subject')is-invalid @enderror" placeholder="Subject" name="subject" id="subject" value="{{ old('subject') }}">
                                        <textarea class="form-control @error('message')is-invalid @enderror" placeholder="Your message" name="message" id="message">{{ old('message') }}</textarea>
                                        <button type="submit" class="btn btn-primary">Send <i class="fa fa-envelope-open-o"></i></button>
                                    </form>

                                </div>
                            </div>
                        </div><!-- end page-wrapper -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end container -->
        </section>
        @include('layouts.footer')
        <div class="dmtop">Scroll to Top</div>
        
    </div><!-- end wrapper -->

    <!-- Core JavaScript
    ================================================== -->
    {{-- <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animate.js"></script>
    <script src="js/custom.js"></script> --}}
</body>
</html>