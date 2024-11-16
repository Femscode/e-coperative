@extends('frontend.master')

@section('header')
@endsection

@section('content')


<div class="main-banner-area overflow-hidden position-relative" style="background-image: url(frontend_assets/images/hero/hero-image-1.svg)">
        <div class="container-fluid side-padding pb-100">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-12" data-cues="slideInRight" data-duration="800">
                    <div class="main-banner-content">
                        <span class="sub-t">A project for the Abeokuta FinHack</span>
                        <h1><span><img src="frontend_assets/images/svg/your.svg" alt="image">Digitalizing</span>  Cooperative Societies.</h1>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="info">
                       
                        <p>The project is all about digitalizing cooperative society operations. Access savings, make payments, track loans, and engage with members anytime, anywhere.
                        Bringing the power of financial communities right to your fingertips.</p>
                       
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
                        <!-- <img class="feature-image-1" src="frontend_assets/images/feature/feature-image-1.png" alt="image"> -->
                        <img class="feature-image-2 bounce" src="frontend_assets/images/ibadan.jpg" alt="image">
                        <!-- <img class="feature-shape-1 moveVertical" src="frontend_assets/images/shape/feature-shape-1.png" alt="image"> -->
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12" data-cues="slideInLeft" data-duration="800">
                    <div class="features-content">
                        <div class="section-heading">
                            <span class="sub-title">TOP FEATURES</span>
                            <h2 class="text-white">Features Of The Digitalized <span><img src="frontend_assets/images/svg/lines-1.svg" alt="image">Cooperative</span> Platform</h2>
                          
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
                    <p>Organisers of the Abk FinHack</p>
                </div>
                <div class="partner-items">
                    <div class="swiper partner-slide">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/payaza1.png" width="70" style='border-radius: 15px;' alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/radiating1.png" width="70" style='border-radius: 15px;'  alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/payaza2.png" width="70" style='border-radius: 15px;'  alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/radiating2.jpeg" width="70" style='border-radius: 15px;'  alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/payaza1.png" width="70" style='border-radius: 15px;' alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/radiating1.png" width="70" style='border-radius: 15px;'  alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/payaza2.png" width="70" style='border-radius: 15px;'  alt="image">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="partner-logo">
                                    <img src="frontend_assets/images/partner/radiating2.jpeg" width="70" style='border-radius: 15px;'  alt="image">
                                </div>
                            </div>
                          
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection 

@section('script')
@endsection