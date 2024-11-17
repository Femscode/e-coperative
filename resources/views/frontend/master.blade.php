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

    <title>E-Cooperative</title>
    <link rel="shortcut icon" href="{{ url('assets/images/cooplogo.png') }}">
    @yield('header')
</head>

<body>

    <div class="preloader-area text-center position-fixed top-0 bottom-0 start-0 end-0" id="preloader">
        <div class="loader position-absolute start-0 end-0">
            <div class="wavy position-relative fw-light">
                <!-- <span class="d-inline-block"><img src="{{url('frontend_assets/images/favicon.png')}}" alt="favicon"></span> -->
                <span class="d-inline-block">E</span>
                <span class="d-inline-block">-</span>
                <span class="d-inline-block">C</span>
                <span class="d-inline-block">O</span>
                <span class="d-inline-block">O</span>
                <span class="d-inline-block">P</span>
                <span class="d-inline-block">E</span>
                <span class="d-inline-block">R</span>
                <span class="d-inline-block">A</span>
                <span class="d-inline-block">T</span>
                <span class="d-inline-block">I</span>
                <span class="d-inline-block">V</span>
                <span class="d-inline-block">E</span>
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
                            <!-- <li><a href="tel:+2349058744473"><i class="flaticon-phone-call"></i> <b>Call:</b> +234 (905) 8744473</a></li>
                            <li><a href="#"><i class="flaticon-email-1"></i> <b>Mail:</b> <span class="__cf_email__">support@e-cooperative.com</span></a></li> -->
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <ul class="right-side">
                            <li><a href="/about-us">More Info</a></li>
                            <li><a href="#">Help</a></li>
                          
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <nav class="navbar navbar-expand-lg bg-color-ffffff" id="navbar">
            <div class="container-fluid side-padding position-relative">
                <a class="navbar-brand logo-brand p-0" href="#">
                    <img src="{{ asset('assets/images/cooplogo.png') }}" width="70" alt="image">
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
                            <a class="nav-link dropdown-toggle active" href="/" role="button">
                                Home
                            </a>
                          
                        </li>
                      
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="/cooperative/signup" role="button">
                                Cooperative Registration
                            </a>
                           
                        </li>
                     
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="/register">
                                Member Registration
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="https://wa.me/2349058744473">
                                Contact Us
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
                            <a href="/login" class="search-btn login"><i class="ri-account-circle-line"></i>Sign In</a>
                        </li>
                        <li>
                            <a href="/register" class="default-btn">Get Started <i class="ri-arrow-right-up-line"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>

    <div class="mobile-navbar offcanvas offcanvas-end border-0" data-bs-backdrop="static" tabindex="-1" id="navbarOffcanvas">
        <div class="offcanvas-header">
            <a href="/" class="logo d-inline-block">
                <img src="{{ asset('assets/images/cooplogo.png') }}" width=50 alt="logo">
            </a>
            <button type="button" class="close-btn bg-transparent position-relative lh-1 p-0 border-0" data-bs-dismiss="offcanvas" aria-label="close">
                <i class="ri-close-fill"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <ul class="mobile-menu">
                <li class="mobile-menu-list active">
                    <a href="/">
                        Home
                    </a>
                   
                </li>
                <li class="mobile-menu-list">
                    <a href="/cooperative/signup" >
                        Cooperative Registration
                    </a>
                  
                </li>
                <li class="mobile-menu-list">
                    <a href="/register" >
                        Member Registration
                    </a>
                 
                </li>
             
          
                <li class="mobile-menu-list without-icon">
                    <a href="http://wa.me/2349058744473" class="nav-link">
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
                        <a href="/register" class="search-btn login"><i class="ri-account-circle-line"></i> Sign Up</a>
                    </li>
                    <li>
                        <a href="/cooperative/signup" class="default-btn">Get Started <i class="ri-arrow-right-up-line"></i></a>
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

    @yield('content')
    
    <div class="footer-area bg-color-0c3a30 pt-120">
        <div class="container">
            <div class="row" data-cues="slideInUp" data-duration="800">
                <div class="col-xl-4 col-lg-9 col-md-6">
                    <div class="footer-weight">
                        <h2 class="text-white">Follow the organizers of ABK FINHACK</h2>
                       
                        <ul class="social">
                           
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
                                <a href="/login">Sign In</a>
                            </li>
                            <li>
                                <a href="/cooperative/signup">Cooperative Registration</a>
                            </li>
                            
                            <li>
                                <a href="/register">Member's Registration</a>
                            </li>
                           
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="footer-weight part-three ps-5">
                        <h3 class="text-white">Project Features</h3>
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
                                <a><span class="__cf_email__">fasanyafemi@gmail.com</span></a>
                                <a><span class="__cf_email__">amospersie@gmail.com</span></a>
                                <a><span class="__cf_email__">gloryo@gmail.com</span></a>
                            </li>
                            <li>
                                <img class="phone" src="frontend_assets/images/svg/phone.svg" alt="image">
                                <span class="text-white"><b>Phone:</b></span>
                                <a href="tel:09058744473">+234 (905) 8744473</a>
                                <a href="tel:0018085550148">+234 (905) 8744473</a>
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
                                <a href="#">Project for the Abk Finhack</a>
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
    @yield('script')
</body>

<!-- Mirrored from templates.hibootstrap.com/finto/default/# by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 24 Oct 2024 15:02:48 GMT -->

</html>