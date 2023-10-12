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
                        <form action="{{route('registerpost')}}" class="form-signin needs-validation" novalidate method="POST">
                            @csrf
                            <h1 class="h5 mb-3 font-weight-normal text-center text-uppercase mb-4">Register</h1>
                            <div class="form-group">
                                <label for="name">Name: </label>
                                <input type="text" id="name" name="name" placeholder="Masukan username..." class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Level: <span class="text-danger">*</span></label>
                                <select type="text" class="form-control" name="level" required>
                                    <option value="admin">admin</option>
                                    <option value="bpo">bpo</option>
                                    <option value="bpomanager">bpomanager</option>
                                    <option value="boss">boss</option>
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="level">level: </label>
                                <input type="text" id="level" name="level" placeholder="Masukan username..." class="form-control @error('level') is-invalid @enderror" value="{{ old('level') }}" required autocomplete="level">
                                @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> -->
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan alamat email..." name="email" required autofocus>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <button class="btn btn-warning btn-block mt-4 text-uppercase" type="submit">REGISTER</button>
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