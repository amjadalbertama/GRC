<!DOCTYPE html>
<html lang="en">

<head>
    <title>GRC - Wimconsult</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="website">
    <meta name="description" content="website">
    <link rel="stylesheet" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/lib/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


</head>

<body id="signup" class="h-100vh d-flex flex-column justify-content-between">

    <header id="header" class="border-bottom">
        <div class="container">
            <nav class="navbar navbar-expand-lg px-0">
                <a class="navbar-brand rounded p-0 mx-auto" href="./index.html">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" height="40" class="brand-logo">
                    <div class="clearfix"></div>
                </a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="row" id="body-sidemenu">
            <!-- MAIN -->
            <div id="main-content" class="col">

                <div class="row mt-3">
                    <div class="col-12 col-md-6 col-lg-4 offset-md-3 offset-lg-4">
                        <form action="{{route('loginpost')}}" class="form-signin needs-validation" novalidate method="POST">
                            @csrf
                            <h1 class="h5 mb-3 font-weight-normal text-center text-uppercase mb-4">Login</h1>
                            @if(session('relogin'))
                            <div class="sufee-alert alert with-close alert-warning alert-dismissible fade show text-center">
                                <span class="badge badge-pill badge-warning">Failed</span>
                                {{ session('relogin') }}
                            </div>
                            @elseif(session('regist'))
                            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show text-center">
                                <span class="badge badge-pill badge-success">Success</span>
                                {{ session('regist') }}
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan alamat email..." name="email" required autofocus>
                                <!-- <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Wajib diisi.</div> -->
                            </div>
                            <div class="form-group">
                                <label for="pass1">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password..." required>
                                <!-- <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Wajib diisi.</div> -->
                            </div>

                            <div class="mt-4">
                                <img src="{{ asset('assets/images/recaptcha.png') }}" class="img-fluid" alt="" title="recaptcha" />
                            </div>

                            <button class="btn btn-warning btn-block mt-4 text-uppercase" type="submit">LOGIN</button>
                            <a href="./home-passreminder.html" class="btn btn-link btn-block mt-4">Lupa Password?</a>
                        </form>
                        <div class="text-center mt-5">
                            <p class="mb-1">Powered by</p>
                            <img src="{{ asset('assets/images/logo-wim.png') }}" alt="Logo" height="60" class="brand-logo">
                        </div>
                    </div> <!-- .col-* -->
                </div> <!-- .row -->

            </div><!-- #main-content -->
        </div><!-- .row -->
    </div><!-- .container -->

    <footer id="footer" class="bg-dark">
        <div class="container">
            <div class="copyright py-3 text-center text-light small">
                &copy; 2022 Hak Cipta PT. Wisma Inti Manajemen
            </div>
        </div>
    </footer><!-- #footer -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>