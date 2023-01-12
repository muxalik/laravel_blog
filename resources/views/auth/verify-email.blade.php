<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>

    @vite(['resources/assets/admin/plugins/fontawesome-free/css/all.min.css'])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="{{ asset('mainstyle.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</head>

<body class="hold-transition register-page">
    <div class="register-box" data-aos="zoom-in">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1>Verify Email</h1>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">
                        <h5 class="m-0"><i class="icon fas fa-check" style="margin-right: 25px"></i>{{ session('message') }}</h5>
                    </div>
                @endif
                <form action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Resend Verification Email</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        AOS.init({
            duration: 600,
        });
    </script>
</body>

</html>
