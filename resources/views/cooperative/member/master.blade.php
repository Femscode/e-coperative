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
    <link href="{{url('memberdashboard/css/appb174.css?ff1e8ee7ca91d18f44ea')}}" rel="stylesheet">


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
                    <button class="btn btn-link btn-square btnsunmoon btn-link-header" id="btn-layout-modes-dark-page"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun sun mx-auto">
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
                        </svg></button>
                    <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i data-feather="bell"></i> <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger p-1"><small>9+</small> <span class="visually-hidden">unread messages</span></span></button>
                    <ul class="dropdown-menu dropdown-menu-end notification-dd sm-mi-95px">

                        <li><a class="dropdown-item p-2" href="#">
                                <div class="row gx-3">
                                    <div class="col-auto">
                                        <figure class="avatar avatar-40 rounded-circle bg-success"><i class="bi bi-patch-check text-white"></i></figure>
                                    </div>
                                    <div class="col">
                                        <p class="mb-2 small">Your property <span class="fw-bold">#H10215</span> is published and live now.</p><span class="row"><span class="col"><span class="badge badge-light rounded-pill text-bg-primary small">System</span></span> <span class="col-auto small opacity-75">1:00 am</span></span>
                                    </div>
                                </div>
                            </a></li>


                        <li class="text-center"><button class="btn btn-link text-center" onclick="notifcationAll()">View all <i class="bi bi-arrow-right fs-14"></i></button></li>
                    </ul>
                </div>
                <div class="dropdown d-inline-block"><a class="dropdown-toggle btn btn-link btn-square btn-link-header style-none no-caret px-0" id="userprofiledd" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                        <div class="row gx-0 d-inline-flex">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-28 rounded-circle coverimg align-middle"><img src="assets/img/modern-ai-image/user-6.jpg" alt="" id="userphotoonboarding2"></figure>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end width-300 pt-0 px-0 sm-mi-45px" aria-labelledby="userprofiledd">
                        <div class="bg-theme-1-space rounded py-3 mb-3 dropdown-dontclose">
                            <div class="row gx-0">
                                <div class="col-auto px-3">
                                    <figure class="avatar avatar-50 rounded-circle coverimg align-middle"><img src="assets/img/modern-ai-image/user-6.jpg" alt=""></figure>
                                </div>
                                <div class="col align-self-center">
                                    <p class="mb-1"><span>SyncoSave</span></p>
                                    <p><i class="bi bi-wallet2 me-2"></i> N1100.00 <small class="opacity-50">Balance</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="px-2">
                            <div><a class="dropdown-item" href="/member/profile"><i data-feather="user" class="avatar avatar-18 me-1"></i> My Profile</a></div>
                            <div><a class="dropdown-item" href="#"><i data-feather="dollar-sign" class="avatar avatar-18 me-1"></i> Referral</a></div>
                            <div><a class="dropdown-item" href="#">
                                    <div class="row">
                                        <div class="col"><i data-feather="gift" class="avatar avatar-18 me-1"></i> Subscription</div>
                                        <div class="col-auto">
                                            <p class="small text-success">Upgrade</p>
                                        </div>
                                        <div class="col-auto"><span class="arrow bi bi-chevron-right"></span></div>
                                    </div>
                                </a></div>
                            <div><a class="dropdown-item" href="#"><i data-feather="settings" class="avatar avatar-18 me-1"></i> Account Setting</a></div>
                            <div><a class="dropdown-item theme-red" href="/logout" onclick="return confirm('Are you sure you want to logout?');"><i data-feather="power" class="avatar avatar-18 me-1"></i> Logout</a></div>
                        </div>
                    </div>
                </div>
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
                <li class="nav-item"><a href="/dashboard" class="nav-link"><i class="menu-icon bi bi-columns-gap"></i> <span class="menu-name">Dashboard</span></a></li>
                <li class="nav-item"><a href="/member/manual-payment" class="nav-link"><i class="menu-icon bi bi-wallet"></i> <span class="menu-name">Pay Dues</span></a></li>
                <li class="nav-item"><a href="/member/loan" class="nav-link"><i class="menu-icon bi bi-piggy-bank"></i> <span class="menu-name">My Loans</span></a>
                    <div class="dropdown-menu">
                        <div class="nav-item"><a href="/member/loan-repayment" class="nav-link"><i class="menu-icon bi bi-bank"></i> <span class="menu-name">Loan Repayment</span></a></div>
                        <div class="nav-item"><a href="/member/loan" class="nav-link"><i class="menu-icon bi bi-cash-coin"></i> <span class="menu-name">Pending Loan Applications</span></a></div>
                        <div class="nav-item"><a href="/member/loan/ongoing" class="nav-link"><i class="menu-icon bi bi-percent"></i> <span class="menu-name">Ongoing Loan Applications</span></a></div>
                        <div class="nav-item"><a href="/member/loan/completed" class="nav-link"><i class="menu-icon bi bi-percent"></i> <span class="menu-name">Completed Loan Applications</span></a></div>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="/member/profile"><i class="menu-icon bi bi-person"></i> <span class="menu-name">Profile</span></a></li>
                <li class="nav-item"><a class="nav-link" href="/member/transactions"><i class="menu-icon bi bi-table"></i> <span class="menu-name">Transactions</span></a></li>
            </ul>
            <div class="mt-auto"></div>
            <div class="px-3 mb-3 not-iconic">
                <h6 class="mb-3 fw-medium">Quick Links</h6>
                <div class="card adminuiux-card">
                    <div class="card-body p-2">
                        <div class="row gx-2">
                            <div class="col-12 d-flex justify-content-between"><a href="investment-search-mutual-funds.html" class="btn btn-square btn-link theme-red"><span class="position-relative"><i data-feather="heart"></i> <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success rounded-circle"><span class="visually-hidden">New alerts</span> </span></span></a><a href="investment-schedule.html" class="btn btn-square btn-link"><span class="position-relative"><i data-feather="calendar"></i> <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning rounded-circle"><span class="visually-hidden">New alerts</span> </span></span></a><a href="investment-inbox.html" class="btn btn-square btn-link"><i data-feather="inbox"></i> </a><a href="investment-help-center.html" class="btn btn-square btn-link"><i data-feather="help-circle"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="nav flex-column menu-active-line">
                <li class="nav-item"><a href="/member/loan-repayment" class="nav-link"><i class="menu-icon" data-feather="users"></i> <span class="menu-name">Loan Repayment</span></a></li>
                <li class="nav-item"><a href="/member/loan" class="nav-link"><i class="menu-icon" data-feather="settings"></i> <span class="menu-name">Pending Loan Applications</span></a></li>
                <li class="nav-item"><a href="/member/loan/ongoing" class="nav-link"><i class="menu-icon" data-feather="settings"></i> <span class="menu-name">Ongoing Loan Applications</span></a></li>
                <li class="nav-item"><a href="/member/loan/completed" class="nav-link"><i class="menu-icon" data-feather="settings"></i> <span class="menu-name">Completed Loan Applications</span></a></li>
                <!-- <li class="nav-item"><a href="{{ route('my-contribution') }}" class="nav-link"><i class="menu-icon" data-feather="settings"></i> <span class="menu-name">My Circle(s)</span></a></li> -->
                <!-- <li class="nav-item"><a href="{{ route('member-contribution-payment') }}" class="nav-link"><i class="menu-icon" data-feather="settings"></i> <span class="menu-name">Contribution Dues</span></a></li> -->
                <li class="nav-item"><a href="/logout" onclick='return confirm("Are you sure you want to log this user out?");' class="nav-link"><i class="menu-icon" data-feather="settings"></i> <span class="menu-name">Logout</span></a></li>
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
<div class="offcanvas offcanvas-end shadow border-0" tabindex="-1" id="theming" data-bs-scroll="true" data-bs-backdrop="false" aria-labelledby="theminglabel">
    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title" id="theminglabel">Personalize</h5>
            <p class="text-secondary small">Make it more like your own</p>
        </div><button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <h6 class="offcanvas-title">Colors</h6>
        <p class="text-secondary small mb-4">Change colors of templates</p>
        <div class="row mb-4 theme-select">
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title=""><span class="avatar avatar-40 rounded-circle mb-2 bg-default"><i class="bi bi-arrow-clockwise"></i></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-blue"><span class="avatar avatar-40 rounded-circle mb-2 bg-blue"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-indigo"><span class="avatar avatar-40 rounded-circle mb-2 bg-indigo"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-purple"><span class="avatar avatar-40 rounded-circle mb-2 bg-purple"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-pink"><span class="avatar avatar-40 rounded-circle mb-2 bg-pink"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-red"><span class="avatar avatar-40 rounded-circle mb-2 bg-red"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-orange"><span class="avatar avatar-40 rounded-circle mb-2 bg-orange"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-yellow"><span class="avatar avatar-40 rounded-circle mb-2 bg-yellow"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-green"><span class="avatar avatar-40 rounded-circle mb-2 bg-green"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-teal"><span class="avatar avatar-40 rounded-circle mb-2 bg-teal"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-cyan"><span class="avatar avatar-40 rounded-circle mb-2 bg-cyan"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-grey"><span class="avatar avatar-40 rounded-circle mb-2 bg-grey"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-brown"><span class="avatar avatar-40 rounded-circle mb-2 bg-brown"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-chocolate"><span class="avatar avatar-40 rounded-circle mb-2 bg-chocolate"></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="theme-black"><span class="avatar avatar-40 rounded-circle mb-2 bg-dark"></span></div>
            </div>
        </div>
        <h6 class="offcanvas-title">Backgrounds</h6>
        <p class="text-secondary small mb-4">Change color for background</p>
        <div class="row mb-4 theme-background">
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-default"><span class="avatar avatar-40 rounded-circle mb-2 bg-default"><i class="bi bi-arrow-clockwise"></i></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-white"><span class="avatar avatar-40 rounded-circle mb-2 bg-white"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-r-gradient"><span class="avatar avatar-40 rounded-circle mb-2 bg-r-gradient"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-1"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-1"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-2"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-2"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-3"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-3"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-4"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-4"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-5"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-5"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-6"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-6"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-7"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-7"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-8"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-8"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-9"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-9"></span></div>
            </div>
            <div class="col-auto">
                <div class="gradient-box text-center mb-2" data-title="bg-gradient-10"><span class="avatar avatar-40 rounded-circle mb-2 bg-gradient-10"></span></div>
            </div>
        </div>
        <h6 class="offcanvas-title">Sidebar Layout</h6>
        <p class="text-secondary small mb-4">Change sidebar layout style</p>
        <div class="row mb-4 sidebar-layout">
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="adminuiux-sidebar-standard" data-bs-toggle="tooltip" title="None"><span class="avatar avatar-40 rounded-circle mb-2 bg-default"><i class="bi bi-arrow-clockwise"></i></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="adminuiux-sidebar-iconic" data-bs-toggle="tooltip" title="Iconic"><span class="avatar avatar-40 rounded-circle mb-2 bg-default"><i class="bi bi-bezier h4"></i></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="adminuiux-sidebar-boxed" data-bs-toggle="tooltip" title="Boxed"><span class="avatar avatar-40 rounded-circle mb-2 bg-default"><i class="bi bi-box h5"></i></span></div>
            </div>
            <div class="col-auto">
                <div class="select-box text-center mb-2" data-title="adminuiux-sidebar-boxed adminuiux-sidebar-iconic" data-bs-toggle="tooltip" title="Iconic+Boxed"><span class="avatar avatar-40 rounded-circle mb-2 bg-default"><i class="bi bi-bounding-box h5"></i></span></div>
            </div>
        </div>
        <div class="text-center mb-4"><a href="investment-personalization.html" class="btn btn-sm btn-outline-theme">More options <i class="bi bi-arrow-right-short"></i></a></div>
    </div>
</div>
<script src="{{url('memberdashboard/js/investment/investment-cooperative.admin.js')}}"></script>
<script src="{{ asset('js\requestController.js') }}"></script>
<script src="{{ asset('js\formController.js') }}"></script>
@yield('script')