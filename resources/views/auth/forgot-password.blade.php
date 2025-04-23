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
    <link href="{{url('memberdashboard/css/appb174.css')}}" rel="stylesheet">


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
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Left Column - Login Form -->
            <div class="col-12 col-lg-5 d-flex flex-column p-4">
                <div class="text-center mb-5">
                    <img src="{{ asset('admindashboard/images/logo/syncologo2.png') }}" alt="SyncoSave" class="mb-4" style="width: 180px;">
                </div>

                <div class="login-container my-auto">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-1">Welcome Back</h2>
                        <p class="text-muted">Sign in to continue to SyncoSave</p>
                    </div>

                    <form id="loginForm" method="POST" action="{{ route('login') }}" class="mx-auto" style="max-width: 400px;">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control form-control-lg" id="email" placeholder="name@example.com">
                            <label for="email">Email Address</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control form-control-lg" id="password" placeholder="Password">
                            <label for="password">Password</label>
                            <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3 toggle-password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberme">
                                <label class="form-check-label" for="rememberme">Remember me</label>
                            </div>
                            <a href="/forgot-password" class="text-decoration-none">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3" id="loginButton">Sign In</button>

                        <div class="d-flex gap-2 mb-4">
                            <button type="button" class="btn btn-outline-secondary w-50" id="memberLogin">
                                <i class="bi bi-person me-2"></i>Demo Member
                            </button>
                            <button type="button" class="btn btn-outline-secondary w-50" id="adminLogin">
                                <i class="bi bi-shield-lock me-2"></i>Demo Admin
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <span class="text-muted">New to SyncoSave?</span>
                        <a href="/register" class="text-decoration-none ms-1">Create Account</a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Image -->
            <div class="col-lg-7 d-none d-lg-block p-0">
                <div class="h-100 position-relative bg-primary bg-gradient">
                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white p-4" style="max-width: 600px;">
                        <h1 class="display-5 fw-bold mb-4">Cooperative Savings Made Simple</h1>
                        <p class="lead mb-4">"When we save together, we grow together. Cooperative savings is the foundation of community wealth."</p>
                        <p class="opacity-75">- Fasanya Oluwapelumi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
    .login-container {
        max-width: 480px;
        margin: 0 auto;
        width: 100%;
    }



    .form-control {
        border: 1.5px solid #e5e9f2;
        padding: 0.6rem 1rem;
        height: 3.2rem;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
        border-radius: 6px;
        /* Added this line to reduce border radius */
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .btn-primary {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        border: none;
        padding: 0.8rem;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #0a58ca, #084298);
        transform: translateY(-1px);
    }

    .toggle-password {
        color: #6c757d;
        z-index: 10;
    }

    .toggle-password:hover {
        color: #0d6efd;
    }
</style>
<script src="assets/js/investment/investment-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Fade out preloader

        // Quick login buttons
        $('#memberLogin').click(function() {
            $('#email').val('pelumi333@gmail.com');
            $('#password').val('Password123');
            $('#loginButton').click();
        });

        $('#adminLogin').click(function() {
            $('#email').val('proxycoop@gmail.com');
            $('#password').val('Password123');
            $('#loginButton').click();
        });
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
                    console.log(response);
                    Swal.close(); // Close loading alert

                    // Check if login was successful
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful!',
                            text: 'Redirecting...',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect || '/dashboard'; // Redirect after successful login
                        });
                    } else {

                        Swal.fire({
                            // icon: 'success',
                            title: 'Processing Login!',
                            text: 'Pleae wait...',
                            timer: 100,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect || '/dashboard'; // Redirect after successful login
                        });
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: 'Login Failed',
                        //     text: 'Invalid email or password.'
                        //     // text: response.message || 'Invalid email or password.'
                        // }).then(() => {
                        //     window.location.href = response.redirect || '/dashboard'; // Redirect after successful login
                        // });

                    }
                },
                error: function(xhr) {
                    Swal.close();
                    let errorMessage = 'An error occurred. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }

                    showCustomAlert({
                        icon: 'error',
                        title: 'Login Error',
                        text: errorMessage
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