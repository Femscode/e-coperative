<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SyncoSave | Login</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        :root {
            --adminuiux-content-font: "Open Sans", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Lexend", sans-serif;
            --adminuiux-title-font-weight: 600
        }
    </style>
    <style>
        .demo-accounts-grid {
            display: grid;
            gap: 1rem;
        }

        .demo-btn {
            padding: 1rem;
            border: 1.5px solid #e5e9f2;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
            text-align: left;
            width: 100%;
            color: #094168;
        }

        .demo-btn:hover {
            border-color: #094168;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(9, 65, 104, 0.1);
        }

        .demo-icon-wrapper {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(9, 65, 104, 0.1);
            border-radius: 10px;
            color: #094168;
        }

        .demo-btn:hover .demo-icon-wrapper {
            background: #094168;
            color: white;
        }

        /* Update other color-related styles */
        .btn-outline-primary {
            color: #094168;
            border-color: #e5e9f2 !important;
            background: rgba(9, 65, 104, 0.1) !important;
            border-radius: 10px;
            color: #094168 !important;
        }

        .btn-outline-primary:hover {
            color: white;
            background-color: #094168;
            border-color: #094168;
        }

        .text-primary {
            color: #094168 !important;
        }

        .bg-primary {
            background-color: #094168 !important;
        }

        /* Update form control focus state */
        .form-control:focus {
            background-color: #fff;
            border-color: #094168;
            box-shadow: 0 0 0 0.2rem rgba(9, 65, 104, 0.15);
        }

        /* Update gradient buttons */
        .btn-primary {
            background: linear-gradient(45deg, #094168, #0a3553);
            border: none;
            padding: 0.8rem;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0a3553, #072942);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .demo-accounts-grid {
                gap: 0.75rem;
            }

            .demo-btn {
                padding: 0.75rem;
            }

            .demo-icon-wrapper {
                width: 40px;
                height: 40px;
            }
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
</head>

<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed theme-blue roundedui" data-theme="theme-blue" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0">
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
                        <div class="text-center mb-5">
                            <h2 class="fw-bold mb-2">Welcome to SyncoSave</h2>
                            <p class="text-muted">Experience our demo accounts to explore SyncoSave's features</p>
                        </div>
                        <div class="mx-auto" style="max-width: 400px;">
                            <div class="demo-accounts-grid mb-4">
                                <button type="button" class="btn btn-outline-primary demo-btn position-relative" id="coopAdminLogin">
                                    <div class="d-flex align-items-center">
                                        <div class="demo-icon-wrapper">
                                            <i class="bi bi-shield-lock fs-4"></i>
                                        </div>
                                        <div class="text-start ms-3">
                                            <span class="d-block fw-medium">Cooperative Admin</span>
                                            <small class="text-muted">Manage cooperative operations</small>
                                        </div>
                                    </div>
                                </button>

                                <button type="button" class="btn btn-outline-primary demo-btn" id="coopMemberLogin">
                                    <div class="d-flex align-items-center">
                                        <div class="demo-icon-wrapper">
                                            <i class="bi bi-person fs-4"></i>
                                        </div>
                                        <div class="text-start ms-3">
                                            <span class="d-block fw-medium">Cooperative Member</span>
                                            <small class="text-muted">Access member features</small>
                                        </div>
                                    </div>
                                </button>

                                <button type="button" class="btn btn-outline-primary demo-btn" id="thriftAdminLogin">
                                    <div class="d-flex align-items-center">
                                        <div class="demo-icon-wrapper">
                                            <i class="bi bi-shield-lock fs-4"></i>
                                        </div>
                                        <div class="text-start ms-3">
                                            <span class="d-block fw-medium">Thrift Admin</span>
                                            <small class="text-muted">Manage thrift contributions</small>
                                        </div>
                                    </div>
                                </button>

                                <button type="button" class="btn btn-outline-primary demo-btn" id="thriftMemberLogin">
                                    <div class="d-flex align-items-center">
                                        <div class="demo-icon-wrapper">
                                            <i class="bi bi-person fs-4"></i>
                                        </div>
                                        <div class="text-start ms-3">
                                            <span class="d-block fw-medium">Thrift Member</span>
                                            <small class="text-muted">Access thrift members features</small>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <span class="text-muted">Ready to start your journey with SyncoSave?</span>
                            <a href="/register" class="text-primary text-decoration-none fw-medium ms-1">Create your account <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>


                </div>
                <!-- Right Column - Image -->
                <div class="col-lg-7 d-none d-lg-block p-0">
                    <div class="h-100 position-relative bg-primary bg-gradient">
                        <div class="position-absolute top-50 start-50 translate-middle text-center text-white p-4" style="max-width: 600px;">
                            <h1 class="display-5 fw-bold mb-4">Cooperative Savings Made Simple</h1>
                            <p class="lead mb-4">"When we save together, we grow together. Cooperative savings is the foundation of community wealth."</p>
                            <p class="opacity-75">- Fasanya Oluwapelumi F.</p>
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
            setTimeout(function() {
                $('.pageloader').fadeOut(500);
            }, 1500);

            // Demo login credentials
            const demoCredentials = {
                cooperative_admin: {
                    email: 'admin@syncocoop.com',
                    password: 'Password123'
                },
                cooperative_member: {
                    email: 'member@syncocoop.com',
                    password: 'Password123'
                },
                thrift_admin: {
                    email: 'thriftadmin@syncocoop.com',
                    password: 'Password123'
                },
                thrift_member: {
                    email: 'thriftmember@syncocoop.com',
                    password: 'Password123'
                }
            };

            // Demo login buttons
            $('#coopAdminLogin').click(function() {
                loginAs('cooperative_admin');
            });
            $('#coopMemberLogin').click(function() {
                loginAs('cooperative_member');
            });
            $('#thriftAdminLogin').click(function() {
                loginAs('thrift_admin');
            });
            $('#thriftMemberLogin').click(function() {
                loginAs('thrift_member');
            });

            function loginAs(userType) {
                const credentials = demoCredentials[userType];

                showCustomAlert({
                    title: 'Logging in...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // AJAX request for demo login
                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: credentials.email,
                        password: credentials.password
                    },
                    success: function(response) {
                        Swal.close();
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful!',
                            text: 'Redirecting...',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect || '/dashboard';
                        });
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
            }
        });
    </script>
</body>

</html>