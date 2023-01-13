<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password Page</title>

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
                <h1>Forgot your password?</h1>
            </div>
            <div class="card-body">
                @include('layouts.errors')
                @if (session('status'))
                    <div class="alert alert-success">
                        <p><i class="icon fas fa-check"></i>{{ session('status') }}</p>
                    </div>
                @endif
                <form action="{{ route('password.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
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
