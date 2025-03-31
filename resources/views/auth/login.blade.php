<!doctype html>
<html lang="en">
<!-- Mirrored from www.adminuiux.com/adminuiux/investment-uiux/investment-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Dec 2024 11:53:11 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SyncoSave | Login</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Open+Sans:ital,wght@0,300..800;1,300..800&amp;display=swap" rel="stylesheet">
    <style>
        :root {
            --adminuiux-content-font: "Open Sans", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Lexend", sans-serif;
            --adminuiux-title-font-weight: 600
        }
    </style>
    <script defer="defer" src="{{url('memberdashboard/js/appb174.js?ff1e8ee7ca91d18f44ea')}}"></script>
    <link href="{{url('memberdashboard/css/appb174.css?ff1e8ee7ca91d18f44ea')}}" rel="stylesheet">


    <script src="{{ url('admindashboard/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('admindashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">


    <link href="{{ url('admindashboard/css/sweetalert-custom.css') }}" rel="stylesheet">

    <script src="{{ asset('admindashboard/js/sweetalert-custom.js') }}"></script>
    <!-- <style>
        .login-box {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(9, 65, 104, 0.1);
            border-color: #094168;
        }

        .btn-theme {
            background: linear-gradient(45deg, #094168, #1a6ba1);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 500;
            transition: transform 0.2s ease;
        }

        .btn-theme:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(9, 65, 104, 0.2);
        }

        .pageloader {
            background: linear-gradient(135deg, #094168, #1a6ba1);
        }

        .loader10 {
            border-color: #ffffff;
        }

        .adminuiux-card {
            border-radius: 20px;
            overflow: hidden;
        }

        .toggle-password {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .toggle-password:hover {
            color: #094168;
        }

        /* Animation for page load */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-box {
            animation: fadeInUp 0.6s ease-out;
        }
    </style> -->
    @yield('header')
</head>

<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed theme-blue roundedui" data-theme="theme-blue" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0"></body>

</html>
<div class="pageloader">
    <div class="container h-100">
        <div class="row justify-content-center align-items-center text-center h-100">
            <div class="col-12 mb-auto pt-4"></div>
            <div class="col-auto">
                <img src="{{ asset('admindashboard/images/logo/syncologo2.png') }}" alt="" class="height-60 mb-3">
                <p class="h6 mb-0">Welcome to SyncoSave</p>
                <p class="h3 mb-4">Your Financial Future Starts Here</p>
                <div class="loader10 mb-2 mx-auto"></div>
            </div>
            <div class="col-12 mt-auto pb-4">
                <p class="text-secondary">Preparing your personalized experience...</p>
            </div>
        </div>
    </div>
</div>
<main class="flex-shrink-0 pt-0 h-100">
    <div class="container-fluid">
        <div class="auth-wrapper">
            <div class="row">
                <div class="col-12 col-md-6 col-xl-6 minvheight-100 d-flex flex-column px-0">
                    <header class="adminuiux-header">
                        <nav class="navbar">
                            <div class="container-fluid"><a class="navbar-brand" href="investment-dashboard.html">
                                    <img src="{{ asset('admindashboard/images/logo/syncologo2.png') }}" alt="" style="width:150px" class="height-60 mb-3">


                                </a>
                                <div class="ms-auto"></div>
                                <div class="ms-auto"></div>
                            </div>
                        </nav>
                    </header>
                    <div class="h-100 py-4 px-3">
                        <div class="row h-100 align-items-center justify-content-center mt-md-4">
                            <div class="col-11 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box">
                                <div class="text-center mb-4">
                                    <h1 class="mb-2">Welcome Back</h1>
                                    <p class="text-secondary">Enter your credential to login</p>
                                </div>
                                <form id="loginForm" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" placeholder="Enter email address" autofocus="">
                                        <label for="emailadd">Email Address</label>
                                    </div>
                                    <div class="position-relative">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="password" placeholder="Enter your password">
                                            <label for="passwd">Password</label>
                                        </div>
                                        <button type="button" class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2 toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    <div class="row align-items-center mb-3">
                                        <div class="col">
                                            <div class="form-check"><input class="form-check-input" type="checkbox" name="rememberme" id="rememberme"> <label class="form-check-label" for="rememberme">Remember me</label></div>
                                        </div>
                                        <div class="col-auto"><a href="/forgot-password" class="">Forget Password?</a></div>
                                    </div><button id="loginButton" type="submit" class="btn btn-lg btn-theme w-100 mb-4">Login</button>
                                </form>
                                <div class="text-center mb-3">Don't have account? <a href="/register" class="">Create Account</a></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6 col-xl-6 p-4 d-none d-md-block">
                    <div class="card adminuiux-card bg-theme-1-space position-relative overflow-hidden h-100">
                        <div class="position-absolute start-0 top-0 h-100 w-100 coverimg opacity-75 z-index-0"><img src="assets/img/background-image/background-image-8.html" alt=""></div>
                        <div class="card-body position-relative z-index-1">
                            <div class="row h-100 d-flex flex-column justify-content-center align-items-center gx-0 text-center">
                                <div class="col-10 col-md-11 col-xl-8 mb-4 mx-auto">
                                    <div class="swiper swipernavpagination pb-5">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="assets/img/investment/slider.png" alt="" class="mw-100 mb-3">
                                                <h2 class="text-white mb-3">"When we save together, we grow together. Cooperative savings is the foundation of community wealth."</h2>
                                                <p class="lead opacity-75">- Fasanya Oluwapelumi</p>
                                            </div>


                                        </div>
                                        <div class="swiper-pagination white bottom-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="assets/js/investment/investment-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Fade out preloader
    setTimeout(function() {
        $('.pageloader').fadeOut(500);
    }, 1500);

    // Password toggle
    $('.toggle-password').click(function() {
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        var input = $('#password');
        input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
    });

    // Form validation
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        if (!$('#email').val() || !$('#password').val()) {
            showCustomAlert({
                icon: 'warning',
                title: 'Missing Information',
                text: 'Please fill in all required fields'
            });
            return;
        }
        // Continue with your existing login logic
        $('#loginButton').click();
    });

    $('#loginButton').click(function(e) {
                e.preventDefault();

                // Display loading alert
                showCustomAlert({
                    title: 'Logging in...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // AJAX request for login
                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: $('#email').val(),
                        password: $('#password').val()
                    },
                    success: function(response) {
                        Swal.close(); // Close loading alert

                        // Check if login was successful
                        if (response.success) {
                            showCustomAlert({
                                icon: 'success',
                                title: 'Login Successful!',
                                text: 'Redirecting...',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href =  '/dashboard'; // Redirect after successful login
                            });
                        } else {

                            showCustomAlert({
                                icon: 'error',
                                title: 'Login Failed',
                                text: 'Invalid email or password.'
                                // text: response.message || 'Invalid email or password.'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        showCustomAlert({
                            icon: 'error',
                            title: 'Login Error',
                            text: 'An error occurred. Please try again.'
                        });
                    }
                });
            });

    // Input focus effects
    $('.form-control').focus(function() {
        $(this).parent('.form-floating').addClass('focused');
    }).blur(function() {
        if (!$(this).val()) {
            $(this).parent('.form-floating').removeClass('focused');
        }
    });
});
</script>