<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SyncoSave | Dashboard</title>
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
    <style>
        .grand-total-container {
            max-width: 300px;
            margin: auto;
        }

        .grand-total-input {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            background-color: #f8f9fa;
            border: 2px solid #28a745;
            color: #28a745;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .grand-total-input:focus {
            box-shadow: 0 6px 15px rgba(0, 128, 0, 0.3);
            transform: scale(1.02);
            outline: none;
        }

        .payment-logo {
            height: 40px;
            width: auto;
        }

        .amount-display {
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 1rem;
        }

        .amount-text {
            color: #094168;
            font-size: 2rem;
        }

        .custom-table {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .custom-table thead th {
            border: none;
            font-weight: 600;
            color: #6c757d;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dues-row {
            background: #fff;
            transition: transform 0.2s ease;
        }

        .dues-row:hover {
            transform: translateX(5px);
        }

        .week-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(9, 65, 104, 0.1);
            color: #094168;
            border-radius: 8px;
        }

        .amount-badge {
            font-weight: 600;
            color: #094168;
            background: rgba(9, 65, 104, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
        }

        .grand-total-input {
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            background: #fff;
            border: 2px solid #094168;
            color: #094168;
            border-radius: 0.75rem;
        }

        .form-check-input:checked {
            background-color: #094168;
            border-color: #094168;
        }

        .btn-primary {
            background-color: #094168;
            border-color: #094168;
        }

        .btn-primary:hover {
            background-color: #073251;
            border-color: #073251;
        }

        .empty-state-icon {
            background: rgba(9, 65, 104, 0.1);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
    </style>
    <style>
        .loan-nav-wrapper {
            background: #fff;
            border-radius: 0.5rem;
            padding: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .active2 {
            color: #094168 !important;
            background: rgba(9, 65, 104, 0.1) !important;
            border: none;
            box-shadow: 0 1px 2px rgba(9, 65, 104, 0.1);
        }

        .nav-tabs-custom {
            border: 0;
            gap: 0.5rem;
        }

        .nav-tabs-custom .nav-link {
            border: 0;
            padding: 0.75rem 1.25rem;
            border-radius: 0.5rem;
            color: #6c757d;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-tabs-custom .nav-link:hover {
            color: #094168;
            background: rgba(9, 65, 104, 0.05);
        }

        .nav-tabs-custom .nav-link.active {
            color: #094168;
            background: rgba(9, 65, 104, 0.1);
        }

        .nav-tabs-custom .nav-link.active::after {
            display: none;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        .badge.bg-primary {
            background-color: #094168 !important;
        }

        @media (max-width: 768px) {
            .nav-tabs-custom {
                flex-direction: column;
            }

            .nav-tabs-custom .nav-link {
                width: 100%;
                text-align: left;
            }
        }
    </style>
    <style>
        .payment-option-card {
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .payment-option-card:hover {
            border-color: #6c757d;
            background-color: #f8f9fa;
        }

        .payment-option-card .form-check-input:checked~.form-check-label {
            color: var(--bs-primary);
        }

        .payment-option-card .form-check-input:checked~.form-check-label .payment-icon {
            background-color: var(--bs-primary) !important;
            color: white !important;
        }

        .payment-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        .bg-soft-primary {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
        }

        .bg-soft-success {
            background-color: rgba(var(--bs-success-rgb), 0.1);
            color: var(--bs-success);
        }
    </style>

    <link href="{{ url('admindashboard/css/sweetalert-custom.css') }}" rel="stylesheet">

    <script src="{{ asset('admindashboard/js/sweetalert-custom.js') }}"></script>
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
<header class="adminuiux-header">
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <button class="btn btn-link btn-square sidebar-toggler" type="button" onclick="initSidebar()"><i class="sidebar-svg" data-feather="menu"></i></button>
            <a class="navbar-brand" href="/">
                <img src="{{ asset('admindashboard/images/logo/syncologo2.png') }}" alt="" style="width:100px;height:50px">


            </a>

            <div class="ms-auto">

                <div class="dropdown d-inline-block">
                    <!-- <button class="btn btn-link btn-square btnsunmoon btn-link-header" id="btn-layout-modes-dark-page"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun sun mx-auto">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-moon moon mx-auto">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg></button> -->
                    <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="bell"></i> <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger p-1"><small>3+</small> <span class="visually-hidden">unread messages</span></span></button>

                </div>
                <div class="dropdown d-inline-block">
                    <a class="user-profile-toggle" id="userProfileToggle" href="#" role="button">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; padding: 0;">
                                <i class="bi bi-person-circle text-primary" style="font-size: 28px;"></i>
                            </div>
                        </div>
                    </a>
                    <ul class="user-profile-dropdown" id="userProfileDropdown">
                        <li class="p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-circle text-primary" style="font-size: 32px;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="bi bi-wallet2 me-2"></i>
                                        <span>₦{{ number_format(Auth::user()->wallet_balance, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><a class="profile-dropdown-item" href="/member/profile">
                                <i class="bi bi-person me-2"></i> My Profile
                            </a></li>
                        <li><a class="profile-dropdown-item" href="https://wa.me/2349058744473">
                                <i class="bi bi-phone me-2"></i> Contact us
                            </a></li>
                        <!-- <li><a class="profile-dropdown-item" href="/member/subscription">
            <div class="d-flex align-items-center justify-content-between">
                <div><i class="bi bi-star me-2"></i> Subscription</div>
                <div class="d-flex align-items-center">
                    <small class="text-success me-2">Upgrade</small>
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>
        </a></li> -->
                        <li><a class="profile-dropdown-item" href="/member/profile">
                                <i class="bi bi-gear me-2"></i> Account Setting
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="profile-dropdown-item text-danger" href="/logout"
                                onclick="return confirm('Are you sure you want to sign out?');">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a></li>
                        <form id="logoutForm" action="/logout" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
                <style>
                    .user-profile-toggle {
                        text-decoration: none;
                        cursor: pointer;
                    }

                    .user-profile-dropdown {
                        display: none;
                        position: absolute;
                        right: 0;
                        top: 100%;
                        min-width: 300px;
                        background: white;
                        border-radius: 8px;
                        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
                        margin-top: 0.5rem;
                        padding: 0;
                        list-style: none;
                        z-index: 1000;
                    }

                    .user-profile-dropdown.show {
                        display: block;
                    }

                    .profile-dropdown-item {
                        display: block;
                        padding: 0.75rem 1rem;
                        text-decoration: none;
                        color: #333;
                        transition: all 0.2s ease;
                    }

                    .profile-dropdown-item:hover {
                        background-color: rgba(9, 65, 104, 0.1);
                        transform: translateX(5px);
                    }

                    .text-primary {
                        color: #094168 !important;
                    }
                </style>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toggle = document.getElementById('userProfileToggle');
                        const dropdown = document.getElementById('userProfileDropdown');

                        // Toggle dropdown
                        toggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            dropdown.classList.toggle('show');
                        });

                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(e) {
                            if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
                                dropdown.classList.remove('show');
                            }
                        });

                        // Prevent dropdown from closing when clicking inside
                        dropdown.addEventListener('click', function(e) {
                            if (!e.target.classList.contains('profile-dropdown-item')) {
                                e.stopPropagation();
                            }
                        });

                        // Close dropdown when pressing ESC
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape') {
                                dropdown.classList.remove('show');
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </nav>

</header>
<div class="adminuiux-wrap">
    <div class="adminuiux-sidebar">
        <div class="adminuiux-sidebar-inner">
            <div class="px-3 not-iconic mt-3">
                <div class="row">
                    <div class="col align-self-center">
                        <h6 class="fw-medium">Main Menu</h6>
                    </div>
                    <div class="col-auto"><a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile" aria-expanded="false" role="button" aria-controls="usersidebarprofile"><i data-feather="user"></i></a></div>
                </div>
                <div class="text-center collapse" id="usersidebarprofile">
                    <figure class="avatar avatar-100 rounded-circle coverimg my-3"><img src="assets/img/modern-ai-image/user-6.jpg" alt=""></figure>

                </div>
            </div>
            <ul class="nav flex-column menu-active-line">
                <li class="nav-item"><a href="/dashboard" class="nav-link"><i class="menu-icon bi bi-grid-1x2-fill"></i> <span class="menu-name">Dashboard</span></a></li>

                <li class="nav-item"><a class="nav-link" href="/member/profile"><i class="menu-icon bi bi-person-circle"></i> <span class="menu-name">Profile</span></a></li>
                <li class="nav-item"><a class="nav-link" href="/member/transactions"><i class="menu-icon bi bi-receipt"></i> <span class="menu-name">Transactions</span></a></li>

                <li class="nav-item"><a href="{{ route('my-contribution') }}" class="nav-link"><i class="menu-icon bi bi-people-fill"></i> <span class="menu-name">My Circle(s)</span></a></li>
                <li class="nav-item"><a href="{{ route('member-contribution-payment') }}" class="nav-link"><i class="menu-icon bi bi-wallet2"></i> <span class="menu-name">Contribution Dues</span></a></li>
                <li class="nav-item"><a href="/logout" onclick='return confirm("Are you sure you want to log this user out?");' class="nav-link"><i class="menu-icon bi bi-box-arrow-right"></i> <span class="menu-name">Logout</span></a></li>
            </ul>

        </div>
    </div>
    @yield('main')
</div>
<footer class="adminuiux-footer has-adminuiux-sidebar mt-auto">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md col-lg py-2"><span class="small">Copyright @<?php echo Date('Y'); ?>, <a href="/" target="_blank">SyncoSave</a></span></div>
            <div class="col-12 col-md-auto col-lg-auto align-self-center">
                <ul class="nav small">
                    <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                    <li class="nav-item">|</li>
                    <li class="nav-item"><a class="nav-link" href="#">Terms of Use</a></li>
                    <li class="nav-item">|</li>
                    <li class="nav-item"><a class="nav-link" href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="position-fixed bottom-0 end-0 m-3 z-index-5"><button class="btn btn-square btn-theme shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#theming" aria-controls="theming"><i class="bi bi-palette"></i></button><br><button class="btn btn-theme btn-square rounded-circle shadow mt-2 d-none" id="backtotop"><i class="bi bi-arrow-up"></i></button></div>

<script src="{{url('memberdashboard/js/investment/investment-cooperative.admin.js')}}"></script>
<script src="{{ asset('js\requestController.js') }}"></script>
<script src="{{ asset('js\formController.js') }}"></script>
@yield('script')