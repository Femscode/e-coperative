<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from templates.hibootstrap.com/finto/default/# by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Oct 2024 14:59:12 GMT -->

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{url('frontend_assets/css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{url('frontend_assets/css/flaticon_finto.css')}}">
    <link rel="stylesheet" href="{{url('frontend_assets/css/scrollCue.css')}}">
    <link rel="stylesheet" href="{{url('frontend_assets/css/remixicon.css')}}">
    <link rel="stylesheet" href="{{url('frontend_assets/css/style.css')}}">
    <link rel="stylesheet" href="{{url('frontend_assets/css/responsive.css')}}">

    <title>E-Coperative</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
</head>

<body>

    <div class="preloader-area text-center position-fixed top-0 bottom-0 start-0 end-0" id="preloader">
        <div class="loader position-absolute start-0 end-0">
            <div class="wavy position-relative fw-light">
                <span class="d-inline-block"><img src="{{url('frontend_assets/images/favicon.png')}}" alt="favicon"></span>
                <span class="d-inline-block">C</span>
                <span class="d-inline-block">O</span>
                <span class="d-inline-block">O</span>
                <span class="d-inline-block">P</span>
            </div>
        </div>
    </div>

    <div class="top-header-info">

        <div class="top-header-area bg-color-0c3a30">
            <div class="container-fluid side-padding">
                <div class="row">
                    <div class="col-lg-8 col-md-12">
                        <ul class="left-side">
                            <li><span>Local Cooperatives to the Digital Era</span></li>
                            <li><a href="tel:+2349058744473"><i class="flaticon-phone-call"></i> <b>Call:</b> +234 (905) 8744473</a></li>
                            <li><a href="#"><i class="flaticon-email-1"></i> <b>Mail:</b> <span class="__cf_email__" data-cfemail="6008050c0c0f2006090e140f4e030f0d">support@ecoop.com</span></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <ul class="right-side">
                            <li><a href="#">Support</a></li>
                            <li><a href="#">Help</a></li>
                          
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <nav class="navbar navbar-expand-lg bg-color-ffffff" id="navbar">
            <div class="container-fluid side-padding position-relative">
                <a class="navbar-brand logo-brand p-0" href="#">
                    <img src="{{ asset('assets/images/favicon.ico') }}" width="50" alt="image">
                </a>
                <a class="navbar-toggler" data-bs-toggle="offcanvas" href="#navbarOffcanvas" role="button" aria-controls="navbarOffcanvas">
                    <span class="burger-menu">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                    </span>
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Home
                            </a>
                          
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Services
                            </a>
                           
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                About Us
                            </a>
                           
                        </li>
                     
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="contact.html">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="others-options">
                    <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled">
                        <!-- <li>
                            <button type="button" class="search-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="ri-search-line"></i> Search
                            </button>
                        </li> -->
                        <li>
                            <a href="/signup" class="search-btn login"><i class="ri-account-circle-line"></i> Sign Up</a>
                        </li>
                        <li>
                            <a href="#" class="default-btn">Get Started <i class="ri-arrow-right-up-line"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>

    <div class="mobile-navbar offcanvas offcanvas-end border-0" data-bs-backdrop="static" tabindex="-1" id="navbarOffcanvas">
        <div class="offcanvas-header">
            <a href="#" class="logo d-inline-block">
                <img src="frontend_assets/images/white-logo.png" alt="logo">
            </a>
            <button type="button" class="close-btn bg-transparent position-relative lh-1 p-0 border-0" data-bs-dismiss="offcanvas" aria-label="close">
                <i class="ri-close-fill"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="mobile-menu">
                <li class="mobile-menu-list active">
                    <a href="javascript:void(0);">
                        Home
                    </a>
                   
                </li>
                <li class="mobile-menu-list">
                    <a href="javascript:void(0);">
                        Services
                    </a>
                  
                </li>
                <li class="mobile-menu-list">
                    <a href="javascript:void(0);">
                        About Us
                    </a>
                 
                </li>
             
          
                <li class="mobile-menu-list without-icon">
                    <a href="#" class="nav-link">
                        Contact
                    </a>
                </li>
            </ul>

            <div class="others-options">
                <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled">
                    <!-- <li>
                        <button type="button" class="search-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="ri-search-line"></i> Search
                        </button>
                    </li> -->
                    <li>
                        <a href="/signup" class="search-btn login"><i class="ri-account-circle-line"></i> Sign Up</a>
                    </li>
                    <li>
                        <a href="#" class="default-btn">Get Started <i class="ri-arrow-right-up-line"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <div class="search-modal modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <form class="popup-form">
                        <input type="text" class="form-control" placeholder="Search here">
                        <button type="submit" class="popup-btn">
                            <i class="ri-search-line"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="main-banner-area overflow-hidden position-relative" style="background-image: url(frontend_assets/images/hero/hero-image-1.svg)">
        <div class="container-fluid side-padding pb-100">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-12" data-cues="slideInRight" data-duration="800">
                    <div class="main-banner-content">
                        <span class="sub-t">WELCOME TO E-COOPERATIVE</span>
                        <h1>Your <span><img src="frontend_assets/images/svg/your.svg" alt="image"> Cooperative</span> Now at Your Fingertips.</h1>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="info">
                        <h4>Manage your cooperative effortlessly with our all-in-one digital platform</h4>
                        <p>Access savings, make payments, track loans, and engage with members anytime, anywhere.
                        Bringing the power of financial communities right to your fingertips.</p>
                        <div class="row align-items-center g-4">
                            <div class="col-lg-5 col-md-5">
                                <ul class="user bg-color-ffffff radius">
                                    <li>
                                        <img class="rounded-circle" src="frontend_assets/images/user/user-image-2.jpg" alt="image">
                                    </li>
                                    <li>
                                        <img class="rounded-circle" src="frontend_assets/images/user/user-image-3.jpg" alt="image">
                                    </li>
                                    <li>
                                        <img class="rounded-circle" src="frontend_assets/images/user/user-image-1.jpg" alt="image">
                                    </li>
                                    <li>
                                        8k+
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="star-review">
                                    <ul>
                                        <li>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                            <i class="flaticon-star-2"></i>
                                        </li>
                                        <li>
                                            <strong>4.9/5</strong> <span>Member's Satisfactions</span>
                                        </li>
                                        <li>
                                            <span>From over 1000+ reviews</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-area">
            <div class="container-fluid side-padding">
                <div class="row g-4 justify-content-center" data-cues="slideInUp" data-duration="800">
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="banner-card bg-color-ffffff radius-30">
                            <div class="flex-warp position-relative">
                                <i>
                                    <img src="frontend_assets/images/svg/grow.svg" alt="image">
                                </i>
                                <h3>Register Your Cooperative</h3>
                                <p>Create an account and set up your cooperative in minutes.</p>
                            </div>
                            <div class="banner-card-body bg-color-def1ee">
                                <img src="frontend_assets/images/service/service-image-1.png" alt="image">
                            </div>
                        </div>

                        <div class="advice-area bg-color-ffffff radius-20">
                            <div class="container-fluid">
                                <div class="advice-content">
                                    <ul>
                                        <li>Member's management</li>
                                        <li>Loan Management</li>
                                        <li>Payment Management</li>
                                        <li>Revenue Management</li>
                                        <li>Transaction</li>
                                        <li>Member's management</li>
                                        <li>Loan Management</li>
                                        <li>Payment Management</li>
                                        <li>Revenue Management</li>
                                        <li>Transaction</li>
                                        <li>Member's management</li>
                                        <li>Loan Management</li>
                                        <li>Payment Management</li>
                                        <li>Revenue Management</li>
                                        <li>Transaction</li>
                                        <li>Member's management</li>
                                        <li>Loan Management</li>
                                        <li>Payment Management</li>
                                        <li>Revenue Management</li>
                                        <li>Transaction</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="banner-card part-two bg-color-9edd05 radius-30 position-relative">
                            <div class="flex-warp position-relative">
                                <i>
                                    <img src="frontend_assets/images/svg/corporation.svg" alt="image">
                                </i>
                                <h3>Invite Members to Join</h3>
                            </div>
                            <p class="mb-0">Share your unique registration link so members can easily sign up.</p>
                            <div class="banner-card-image">
                                <div class="text-end">
                                    <img src="frontend_assets/images/service/service-image-2.png" alt="image">
                                </div>
                            </div>
                            <div class="total bg-color-ffffff radius">
                                <h4>Total Members</h4>
                                <h5>9,647</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="banner-card part-three bg-color-ffffff radius-30 position-relative">
                            <div class="flex-warp position-relative">
                                <i>
                                    <img src="frontend_assets/images/svg/euro.svg" alt="image">
                                </i>
                                <h3>Manage Members and Transactions</h3>
                                <p>Track savings, process loans, and handle payments seamlessly</p>
                            </div>
                            <div class="banner-image-body">
                                <div class="text-end">
                                    <img class="service-image-3" src="frontend_assets/images/service/service-image-3.png" alt="image">
                                </div>
                                <img class="service-image-4" src="frontend_assets/images/service/service-image-4.png" alt="image">
                            </div>
                            <i class="flaticon-star-5 star-5 moveHorizontal_reverse"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="features-area bg-color-0c3a30 ptb-120 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-12" data-cues="slideInRight" data-duration="800">
                    <div class="features-image bg-color-9edd05 radius-30 position-relative">
                        <img class="feature-image-1" src="frontend_assets/images/feature/feature-image-1.png" alt="image">
                        <img class="feature-image-2 bounce" src="frontend_assets/images/feature/feature-image-2.png" alt="image">
                        <img class="feature-shape-1 moveVertical" src="frontend_assets/images/shape/feature-shape-1.png" alt="image">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="features-content">
                        <div class="section-heading">
                            <span class="sub-title">TOP FEATURES</span>
                            <h2 class="text-white">Features That Empower Your <span><img src="frontend_assets/images/svg/lines-1.svg" alt="image">Cooperative</span> To The Next Level</h2>
                            <!-- <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients.</p> -->
                        </div>
                        <ul>
                            <li class="bg-color-29594b radius-20">
                                <i class="flaticon-businessman-1"></i>
                                <h3 class="text-white">Streamlined Member Management</h3>
                                <p class="text-white">Easily add, track, and engage with members through a user-friendly dashboard, ensuring everyone stays connected and informed.</p>
                            </li>
                            <li class="bg-color-29594b radius-20">
                                <i class="flaticon-payment-method"></i>
                                <h3 class="text-white">Secure Payment Processing</h3>
                                <p class="text-white">Simplify transactions with robust payment solutions that allow members to make deposits, pay dues, and apply for loans with confidence.</p>
                            </li>
                            <li class="bg-color-29594b radius-20">
                                <i class="flaticon-laptop-2"></i>
                                <h3 class="text-white">Loan Management System</h3>
                                <p class="text-white">Offer transparent and efficient loan applications, approvals, and repayments, helping your members access funds when they need them most.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="partner-area pt-120">
            <div class="container">
                <div class="title">
                    <p>TRUSTED BY INDUSTRY LEADING COMPANIES AROUND THE GLOBE</p>
                </div>
                <div class="partner-items">
                    <div class="swiper partner-slide">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-1.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-2.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-3.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-4.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-5.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-1.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-2.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-3.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-4.png" alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/partner-logo-5.png" alt="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="services-area ptb-120 position-relative overflow-hidden">
        <div class="container left-padding">
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="section-heading position-relative mb-0">
                        <span class="sub-title">OUR SERVICES</span>
                        <h2>Syncing <span><img src="frontend_assets/images/svg/lines-2.svg" alt>Your</span> Finances</h2>
                        <p class="mb-5">With a robust suite of products ranging from digital banking and payment processing to wealth</p>
                        <a href="services.html" class="default-btn two">See All Services <i class="ri-arrow-right-up-line"></i></a>
                        <div class="services-btn">
                            <div class="swiper-button-next">
                                <i class="ri-arrow-right-line"></i>
                            </div>
                            <div class="swiper-button-prev">
                                <i class="ri-arrow-left-line"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="services-items">
                        <div class="swiper services-slide">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="frontend_assets/images/service/service-image-5.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-businessman-5 businessman"></i>
                                            <h3>
                                                <a href="service-details.html">Funds Remittance</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="service-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="frontend_assets/images/service/service-image-6.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-browser-1 businessman"></i>
                                            <h3>
                                                <a href="service-details.html">Personal Loan</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="service-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="frontend_assets/images/service/service-image-7.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-laptop-1 businessman"></i>
                                            <h3>
                                                <a href="service-details.html">Forex Trading</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="service-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="frontend_assets/images/service/service-image-5.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-businessman-5 businessman"></i>
                                            <h3>
                                                <a href="service-details.html">Funds Remittance</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="service-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="frontend_assets/images/service/service-image-6.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-browser-1 businessman"></i>
                                            <h3>
                                                <a href="service-details.html">Personal Loan</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="service-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="services-card position-relative">
                                        <img class="radius-30" src="frontend_assets/images/service/service-image-7.jpg" alt="image">
                                        <div class="services-card-body bg-color-fffaeb radius-30">
                                            <i class="flaticon-laptop-1 businessman"></i>
                                            <h3>
                                                <a href="service-details.html">Forex Trading</a>
                                            </h3>
                                            <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing.</p>
                                            <a href="service-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="about-us-area pb-120 overflow-hidden">
        <div class="container">
            <div class="about-top mb-5">
                <div class="row align-items-center" data-cues="slideInUp" data-duration="800">
                    <div class="col-lg-7 col-md-7">
                        <div class="section-heading mb-0">
                            <span class="sub-title">ABOUT US</span>
                            <h2 class="mb-0">Leveraging Technology <span><img src="frontend_assets/images/svg/lines-3.svg" alt="image">For</span> Secure & Banking</h2>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="content">
                            <p>By integrating advanced technology with financial expertise we provide a comprehensive suite of services that cater to both individuals and businesses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-info bg-color-edf1ee radius-30">
                <div class="row g-4">
                    <div class="col-lg-6" data-cues="slideInRight" data-duration="800">
                        <div class="about-content">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="miss-tab" data-bs-toggle="tab" data-bs-target="#miss-tab-pane" type="button" role="tab" aria-controls="miss-tab-pane" aria-selected="true">Our Mission</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="qua-tab" data-bs-toggle="tab" data-bs-target="#qua-tab-pane" type="button" role="tab" aria-controls="qua-tab-pane" aria-selected="false">Our Quality</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="vis-tab" data-bs-toggle="tab" data-bs-target="#vis-tab-pane" type="button" role="tab" aria-controls="vis-tab-pane" aria-selected="false">Our Vision</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="top-tab" data-bs-toggle="tab" data-bs-target="#top-tab-pane" type="button" role="tab" aria-controls="top-tab-pane" aria-selected="false">Top Security</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="miss-tab-pane" role="tabpanel" aria-labelledby="miss-tab" tabindex="0">
                                    <div class="title">
                                        <h2>Passionate For Your Financial Support Here</h2>
                                        <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                                    </div>
                                    <ul class="check">
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Pay Bills On Time Without Missing A Beat
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Create And Send Invoices In Seconds
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Control Your Cash Flow On Demand
                                        </li>
                                    </ul>
                                    <a href="about.html" class="default-btn mt-5">More About Us <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                                <div class="tab-pane fade" id="qua-tab-pane" role="tabpanel" aria-labelledby="qua-tab" tabindex="0">
                                    <div class="title">
                                        <h2>Financial For Your Passionate Support Here</h2>
                                        <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                                    </div>
                                    <ul class="check">
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Pay Bills On Time Without Missing A Beat
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Create And Send Invoices In Seconds
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Control Your Cash Flow On Demand
                                        </li>
                                    </ul>
                                    <a href="about.html" class="default-btn mt-5">More About Us <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                                <div class="tab-pane fade" id="vis-tab-pane" role="tabpanel" aria-labelledby="vis-tab" tabindex="0">
                                    <div class="title">
                                        <h2>Passionate For Your Financial Support Here</h2>
                                        <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                                    </div>
                                    <ul class="check">
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Pay Bills On Time Without Missing A Beat
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Create And Send Invoices In Seconds
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Control Your Cash Flow On Demand
                                        </li>
                                    </ul>
                                    <a href="about.html" class="default-btn mt-5">More About Us <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                                <div class="tab-pane fade" id="top-tab-pane" role="tabpanel" aria-labelledby="top-tab" tabindex="0">
                                    <div class="title">
                                        <h2>Financial For Your Passionate Support Here</h2>
                                        <p class="mb-0">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                                    </div>
                                    <ul class="check">
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Pay Bills On Time Without Missing A Beat
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Create And Send Invoices In Seconds
                                        </li>
                                        <li>
                                            <i class="ri-check-line"></i>
                                            Control Your Cash Flow On Demand
                                        </li>
                                    </ul>
                                    <a href="about.html" class="default-btn mt-5">More About Us <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-cues="slideInLeft" data-duration="800">
                        <div class="about-image bg-color-ffffff radius-30">
                            <img class="about-image-1" src="frontend_assets/images/about/about-image-1.jpg" alt="image">
                            <img class="about-image-2" src="frontend_assets/images/about/about-image-1.png" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="why-choose-us-area mb-5 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12" data-cues="slideInRight" data-duration="800">
                    <div class="choose-image position-relative">
                        <img class="radius-30" src="frontend_assets/images/about/about-image-2.jpg" alt="image">
                        <div class="paly-content">
                            <a data-fslightbox="one" href="https://www.youtube.com/watch?v=Y7cpCDlRfV0" class="popup-btn">
                                <i class="flaticon-play-buttton"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12" data-cues="slideInLeft" data-duration="800">
                    <div class="why-choose-us-content">
                        <div class="section-heading mb-0">
                            <span class="sub-title">WHY CHOOSE US</span>
                            <h2>Grow Your <span><img src="frontend_assets/images/svg/lines-1.svg" alt="image">Transaction</span> From Another Level</h2>
                            <p class="mb-5">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients.</p>
                            <a href="about-us.html" class="default-btn two">Learn More <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="choose-card-area pb-120">
        <div class="container">
            <div class="row g-4 justify-content-center" data-cues="slideInUp" data-duration="800">
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card bg-color-fffaeb radius-30">
                        <i class="flaticon-money-5"></i>
                        <h3>Global Payments</h3>
                        <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card bg-color-fffaeb radius-30">
                        <i class="flaticon-dollar-symbol-1"></i>
                        <h3>Revenue & Finance</h3>
                        <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card bg-color-fffaeb radius-30">
                        <i class="flaticon-tablet"></i>
                        <h3>Bank As A Service</h3>
                        <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="how-it-works-area bg-color-0c3a30 ptb-120">
        <div class="container">
            <div class="about-top mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-7" data-cues="slideInRight" data-duration="800">
                        <div class="section-heading mb-0">
                            <span class="sub-title text-white">HOW IT WORKS</span>
                            <h2 class="text-white mb-0">Commitment To <span><img src="frontend_assets/images/svg/lines-1.svg" alt="image">Exceptional</span> Services And Solutions</h2>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5" data-cues="slideInLeft" data-duration="800">
                        <div class="content">
                            <p class="text-white">By integrating advanced technology with financial expertise we provide a comprehensive suite of services that cater to both individuals and businesses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-xl-4 col-lg-12">
                    <div class="works-btn">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="crea-tab" data-bs-toggle="tab" data-bs-target="#crea-tab-pane" type="button" role="tab" aria-controls="crea-tab-pane" aria-selected="true">Create Account <i class="ri-arrow-right-up-line"></i></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="use-tab" data-bs-toggle="tab" data-bs-target="#use-tab-pane" type="button" role="tab" aria-controls="use-tab-pane" aria-selected="false">User Confirmation <i class="ri-arrow-right-up-line"></i></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="enj-tab" data-bs-toggle="tab" data-bs-target="#enj-tab-pane" type="button" role="tab" aria-controls="enj-tab-pane" aria-selected="false">Enjoy Full Access <i class="ri-arrow-right-up-line"></i></button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="mob-tab" data-bs-toggle="tab" data-bs-target="#mob-tab-pane" type="button" role="tab" aria-controls="mob-tab-pane" aria-selected="false">Mobile Transaction <i class="ri-arrow-right-up-line"></i></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="crea-tab-pane" role="tabpanel" aria-labelledby="crea-tab" tabindex="0">
                            <div class="row g-4" data-cues="slideInUp" data-duration="800">
                                <div class="col-lg-6">
                                    <div class="single-works-image">
                                        <img class="radius-30" src="frontend_assets/images/about/about-image-3.jpg" alt="image">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single-works-card bg-color-29594b radius-30">
                                        <i class="flaticon-payment-method-1 method"></i>
                                        <h3 class="text-white">Create Account</h3>
                                        <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients to navigate the complexities of the financial world with ease confidence</p>
                                        <a href="contact.html" class="default-btn two">Get Started <i class="ri-arrow-right-up-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="use-tab-pane" role="tabpanel" aria-labelledby="use-tab" tabindex="0">
                            <div class="row" data-cues="slideInUp" data-duration="800">
                                <div class="col-lg-6">
                                    <div class="single-works-image">
                                        <img class="radius-30" src="frontend_assets/images/about/about-image-10.jpg" alt="image">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single-works-card bg-color-29594b radius-30">
                                        <i class="flaticon-tablet method"></i>
                                        <h3 class="text-white">User Confirmation</h3>
                                        <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients to navigate the complexities of the financial world with ease confidence</p>
                                        <a href="contact.html" class="default-btn two">Get Started <i class="ri-arrow-right-up-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="enj-tab-pane" role="tabpanel" aria-labelledby="enj-tab" tabindex="0">
                            <div class="row" data-cues="slideInUp" data-duration="500">
                                <div class="col-lg-6">
                                    <div class="single-works-image">
                                        <img class="radius-30" src="frontend_assets/images/about/about-image-11.jpg" alt="image">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single-works-card bg-color-29594b radius-30">
                                        <i class="flaticon-payment-method-2 method"></i>
                                        <h3 class="text-white">Enjoy Full Access</h3>
                                        <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients to navigate the complexities of the financial world with ease confidence</p>
                                        <a href="contact.html" class="default-btn two">Get Started <i class="ri-arrow-right-up-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mob-tab-pane" role="tabpanel" aria-labelledby="mob-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="single-works-image">
                                        <img class="radius-30" src="frontend_assets/images/about/about-image-12.jpg" alt="image">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="single-works-card bg-color-29594b radius-30">
                                        <i class="flaticon-businessman-4 method"></i>
                                        <h3 class="text-white">Mobile Transaction</h3>
                                        <p class="text-white">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications we empower our clients to navigate the complexities of the financial world with ease confidence</p>
                                        <a href="contact.html" class="default-btn two">Get Started <i class="ri-arrow-right-up-line"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <div class="pricing-plan-area ptb-120 bg-color-def1ee">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">PRICING PLAN</span>
                <h2>Choose The Best <span><img src="frontend_assets/images/svg/lines-2.svg" alt="image">Plans</span> Which For You</h2>
            </div>
            <div class="row g-4 justify-content-center" data-cues="slideInUp" data-duration="800">
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card bg-color-ffffff radius-30">
                        <div class="title position-relative">
                            <h3>Essentials Plan</h3>
                            <h4>$140/ <span>Per Month</span></h4>
                            <img class="about-image-2" src="frontend_assets/images/about/about-image-2.png" alt="image">
                        </div>
                        <div class="pricing-card-body">
                            <ul class="check">
                                <li>
                                    <i class="ri-check-line"></i>
                                    Global Corporate Cards
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Business Account And Bill Pay
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Real-Time Spend Reporting
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Billing In 50+ Countries
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Dedicated Support For Admins
                                </li>
                            </ul>
                            <a href="contact.html" class="default-btn two w-100 text-center">Get Started <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card active bg-color-ffffff radius-30">
                        <div class="title position-relative">
                            <h3>Premium Plan</h3>
                            <h4>$160/ <span>Per Month</span></h4>
                            <img class="about-image-2" src="frontend_assets/images/about/about-image-2.png" alt="image">
                        </div>
                        <div class="pricing-card-body">
                            <ul class="check">
                                <li>
                                    <i class="ri-check-line"></i>
                                    Up To 10 Team Members
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Unlimited Usage
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Unlimited Drive Storage
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Concierge Help Center
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Custom AI Brand Models
                                </li>
                            </ul>
                            <a href="contact.html" class="default-btn two w-100 text-center">Get Started <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card bg-color-ffffff radius-30">
                        <div class="title position-relative">
                            <h3>Enterprise Plan</h3>
                            <h4>$180/ <span>Per Month</span></h4>
                            <img class="about-image-2" src="frontend_assets/images/about/about-image-2.png" alt="image">
                        </div>
                        <div class="pricing-card-body">
                            <ul class="check">
                                <li>
                                    <i class="ri-check-line"></i>
                                    Wallet management
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Secure protocols
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Transaction editing
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Enhanced security
                                </li>
                                <li>
                                    <i class="ri-check-line"></i>
                                    Advanced reporting
                                </li>
                            </ul>
                            <a href="contact.html" class="default-btn two w-100 text-center">Get Started <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="testimonials-area ptb-120">
        <div class="container">
            <div class="about-top mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-7" data-cues="slideInRight" data-duration="800">
                        <div class="section-heading mb-0">
                            <span class="sub-title">TESTIMONIALS</span>
                            <h2 class="mb-0">Hear What Our <span><img src="frontend_assets/images/svg/lines-1.svg" alt="image">Clients</span> Say About Us</h2>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-5" data-cues="slideInLeft" data-duration="800">
                        <div class="content">
                            <p>By integrating advanced technology with financial expertise we provide a comprehensive suite of services that cater to both individuals and businesses</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" data-cues="slideInUp" data-duration="800">
                <div class="col-lg-6 col-md-12">
                    <div class="testimonials-image bg-color-9edd05 radius-30 position-relative">
                        <img class="about-image-3" src="frontend_assets/images/about/about-image-3.png" alt="image">
                        <img class="feature-shape-1 rotate" src="frontend_assets/images/shape/feature-shape-1.png" alt="image">
                        <img class="feature-shape-2 rotate" src="frontend_assets/images/shape/feature-shape-1.png" alt="image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="testimonials-content">
                        <div class="testimonials-card bg-color-fffaeb radius-30 mb-4">
                            <ul>
                                <li>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                </li>
                            </ul>
                            <p>“We are at the forefront of revolutionizing the financial landscape through cutting fintech solutions Our mission is to bridge the gap between traditional banking and modern technology, offering innovative and seamless financial services that cater to the evolving needs of individuals.”</p>
                            <div class="flex-warp d-flex align-items-center justify-content-between">
                                <div class="d-flex gap-4 align-items-center">
                                    <img class="user-image-4 rounded-circle" src="frontend_assets/images/user/user-image-4.jpg" alt="image">
                                    <div>
                                        <h3>Steven H. Britten</h3>
                                        <span>CEO & Founder</span>
                                    </div>
                                </div>
                                <img class="right-quote" src="frontend_assets/images/svg/right-quote.svg" alt="image">
                            </div>
                        </div>
                        <div class="testimonials-card bg-color-fffaeb radius-30">
                            <ul>
                                <li>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                    <i class="flaticon-star-2"></i>
                                </li>
                            </ul>
                            <p>“We are at the forefront of revolutionizing the financial landscape through cutting fintech solutions Our mission is to bridge the gap between traditional banking and modern technology, offering innovative and seamless financial services that cater to the evolving needs of individuals.”</p>
                            <div class="flex-warp d-flex align-items-center justify-content-between">
                                <div class="d-flex gap-4 align-items-center">
                                    <img class="user-image-4 rounded-circle" src="frontend_assets/images/user/user-image-5.jpg" alt="image">
                                    <div>
                                        <h3>Kevin M. Rueda</h3>
                                        <span>Businessman</span>
                                    </div>
                                </div>
                                <img class="right-quote" src="frontend_assets/images/svg/right-quote.svg" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!-- <div class="blog-area pb-120">
        <div class="container">
            <div class="section-title">
                <span class="sub-title">LATEST BLOG</span>
                <h2>Smart Tools For <span><img src="frontend_assets/images/svg/lines-1.svg" alt="image">Creative</span> Financial Planning</h2>
            </div>
            <div class="row g-4" data-cues="slideInUp" data-duration="800">
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="blog-card bg-color-edf1ee radius-30 mb-4">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-5">
                                <div class="blog-image">
                                    <a href="blog-details.html" class="d-block">
                                        <img src="frontend_assets/images/blog/blog-image-1.jpg" class="blog-image-1" alt="image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <div class="blog-card-body">
                                    <ul>
                                        <li><i class="ri-calendar-2-line"></i> Aug 06, 2024</li>
                                        <li><i class="ri-message-line"></i> No Comment</li>
                                    </ul>
                                    <h3>
                                        <a href="blog-details.html">How To Easily Understand Your Insurance Contract</a>
                                    </h3>
                                    <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                                    <a href="blog-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-card bg-color-edf1ee radius-30">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-5">
                                <div class="blog-image">
                                    <a href="blog-details.html" class="d-block">
                                        <img src="frontend_assets/images/blog/blog-image-2.jpg" class="blog-image-1" alt="image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7">
                                <div class="blog-card-body">
                                    <ul>
                                        <li><i class="ri-calendar-2-line"></i> Aug 07, 2024</li>
                                        <li><i class="ri-message-line"></i> No Comment</li>
                                    </ul>
                                    <h3>
                                        <a href="blog-details.html">The Basics Of Financial Responsibility</a>
                                    </h3>
                                    <p>With a robust suite of products ranging from digital banking and payment processing.</p>
                                    <a href="blog-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12 col-md-12">
                    <div class="single-blog bg-color-edf1ee radius-30">
                        <a href="blog-details.html" class="d-block">
                            <img src="frontend_assets/images/blog/blog-image-3.jpg" class="blog-image-3" alt="image">
                        </a>
                        <div class="single-blog-card-body">
                            <ul>
                                <li><i class="ri-calendar-2-line"></i> Aug 08, 2024</li>
                                <li><i class="ri-message-line"></i> No Comment</li>
                            </ul>
                            <h3>
                                <a href="blog-details.html">Effective Financial Management Crucial For Most Organizations</a>
                            </h3>
                            <p>We are at the forefront of revolutionizing the financial landscape through cutting solutions Our mission is to bridge the gap between traditional banking.</p>
                            <a href="blog-details.html" class="read-more">Read More <i class="ri-arrow-right-up-line"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <div class="faq-area pb-120 overflow-hidden">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6 col-md-12" data-cues="slideInRight" data-duration="800">
                    <div class="question-card bg-color-9edd05 radius-30">
                        <div class="section-heading">
                            <span class="sub-title">FAQ</span>
                            <h2>Frequently <span><img src="frontend_assets/images/svg/lines-4.svg" alt="image">Asked</span> Questions</h2>
                            <!-- <p>With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p> -->
                        </div>
                        <img class="radius-30" src="frontend_assets/images/blog/blog-image-4.jpg" alt="image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12" data-cues="slideInLeft" data-duration="800">
                    <div class="faq-content">
                        <div class="accordion" id="accordionFAQ">
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBang" aria-expanded="false" aria-controls="collapseBang">
                                    1. What is an e-cooperative?
                                </button>
                                <div id="collapseBang" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        <p>An e-cooperative is a digital platform that enables local cooperatives to manage their operations, finances, and member interactions online..</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSunam" aria-expanded="false" aria-controls="collapseSunam">
                                    2. How do I register my cooperative?
                                </button>
                                <div id="collapseSunam" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        <p> Simply click on the “Register” button on our homepage, fill out the required information, and you’ll be set up in no time!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDinaj" aria-expanded="false" aria-controls="collapseDinaj">
                                    3. Can members register on their own?
                                </button>
                                <div id="collapseDinaj" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        <p>Yes! Once you create your cooperative, members can easily register using the unique link provided to you.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePage" aria-expanded="false" aria-controls="collapsePage">
                                    4. Is my financial information secure?
                                </button>
                                <div id="collapsePage" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        <p>Absolutely! We use advanced encryption and security measures to protect all sensitive data and transactions.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLoan" aria-expanded="false" aria-controls="collapseLoan">
                                    5. What payment methods are accepted?
                                </button>
                                <div id="collapseLoan" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                    <div class="accordion-body">
                                        <p>We support various payment options, including bank transfers, credit/debit cards, and mobile payment solutions.</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="app-area pb-120 overflow-hidden">
        <div class="container">
            <div class="download-area bg-color-edf1ee radius-30">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-6 col-md-12" data-cues="slideInRight" data-duration="800">
                        <div class="section-heading mb-0">
                            <span class="sub-title">DOWNLOAD OUR APP</span>
                            <h2>Experience <span><img src="frontend_assets/images/svg/lines-1.svg" alt="image">The</span> Future Of Banking</h2>
                            <p class="mb-5">With a robust suite of products ranging from digital banking and payment processing to wealth management and blockchain applications.</p>
                            <div class="app-btn">
                                <a href="https://play.google.com/store/apps/category/FAMILY?hl=en" target="_blank" class="me-3">
                                    <img class="rounded-3" src="frontend_assets/images/app/app-image-2.jpg" alt="image">
                                </a>
                                <a href="https://www.apple.com/app-store/" target="_blank">
                                    <img class="rounded-3" src="frontend_assets/images/app/app-image-3.jpg" alt="image">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12" data-cues="slideInLeft" data-duration="800">
                        <div class="app-image">
                            <img class="radius-30" src="frontend_assets/images/app/app-image-1.jpg" alt="image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <div class="footer-area bg-color-0c3a30 pt-120">
        <div class="container">
            <div class="row" data-cues="slideInUp" data-duration="800">
                <div class="col-xl-4 col-lg-9 col-md-6">
                    <div class="footer-weight">
                        <h2 class="text-white">Subscribe Newsletter</h2>
                        <form class="footer-form position-relative">
                            <input type="email" class="form-control" placeholder="Enter Your Email">
                            <button type="submit" class="default-btn">Subscribe <i class="ri-arrow-right-up-line"></i></button>
                        </form>
                        <ul class="social">
                            <li><span>Follow Us:</span></li>
                            <li>
                                <a href="https://www.facebook.com/" target="_blank">
                                    <i class="ri-facebook-fill"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.twitter.com/" target="_blank">
                                    <i class="ri-twitter-x-line"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/" target="_blank">
                                    <i class="ri-instagram-line"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/" target="_blank">
                                    <i class="ri-linkedin-fill"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-4 col-md-6">
                    <div class="footer-weight part-two ps-5">
                        <h3 class="text-white">Quick Links</h3>
                        <ul class="service-link">
                            <li>
                                <a href="#">Terms & Conditions</a>
                            </li>
                            <li>
                                <a href="#">Blog & News</a>
                            </li>
                            
                            <li>
                                <a href="#">Why Choose Us</a>
                            </li>
                            <li>
                                <a href="#">Pricing Plan</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="footer-weight part-three ps-5">
                        <h3 class="text-white">Our Services</h3>
                        <ul class="service-link">
                            <li>
                                <a href="#">Cooperative registrations</a>
                            </li>
                            <li>
                                <a href="#">Member's management</a>
                            </li>
                            <li>
                                <a href="#">Loan processing</a>
                            </li>
                            <li>
                                <a href="#">Automatic Payment</a>
                            </li>
                            <li>
                                <a href="#">Easy Transactions</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="footer-weight ps-5">
                        <h3 class="text-white">Get In Touch</h3>
                        <ul class="get-touch">
                            <li>
                                <img src="frontend_assets/images/svg/map.svg" alt="image">
                                <span class="text-white"><b>Location:</b></span>
                                <a href="https://www.google.com/maps/search/18+Tanglewood+Lane+Gulfport/@30.4216847,-89.1511032,12z/data=!3m1!4b1?entry=ttu" target="_blank">Abeokuta, Ogun State</a>
                            </li>
                            <li>
                                <img class="phone" src="frontend_assets/images/svg/mail.svg" alt="image">
                                <span class="text-white"><b>Email:</b></span>
                                <a href="https://templates.hibootstrap.com/cdn-cgi/l/email-protection#6b030e0707042b0d02051f0445080406"><span class="__cf_email__" data-cfemail="167e737a7a7956707f7862793875797b">support@e-coperative.com</span></a>
                            </li>
                            <li>
                                <img class="phone" src="frontend_assets/images/svg/phone.svg" alt="image">
                                <span class="text-white"><b>Phone:</b></span>
                                <a href="tel:0018085550148">+234 (905) 8744473</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="copyright-area bg-color-0c3a30">
        <div class="container">
            <div class="copyright-border">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-4 col-md-6">
                        <p>© <span>E-cooperative</span> <a href="#" target="_blank"><?php echo Date('Y');?></a></p>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="copy-image" data-cues="zoomIn" data-duration="700">
                            <a href="#" class="d-block">
                                <!-- <img src="frontend_assets/images/white-logo.png" alt="image"> -->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <ul>
                            <li>
                                <a href="privacy-policy.html">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="terms-conditions.html">Terms & Conditions</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="go-top">
        <i class="ri-arrow-up-fill"></i>
    </div>


    <script data-cfasync="false" src="https://templates.hibootstrap.com/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{url('frontend_assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('frontend_assets/js/swiper-bundle.min.js')}}"></script>
    <script src="{{url('frontend_assets/js/fslightbox.min.js')}}"></script>
    <script src="{{url('frontend_assets/js/smooth-scroll.js')}}"></script>
    <script src="{{url('frontend_assets/js/scrollCue.min.js')}}"></script>
    <script src="{{url('frontend_assets/js/script.js')}}"></script>
</body>

<!-- Mirrored from templates.hibootstrap.com/finto/default/# by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Oct 2024 15:02:48 GMT -->

</html>