@extends('frontend.master')

@section('header')
@endsection

@section('content')

<div class="page-banner-area position-relative overflow-hidden" style="background-image: url({{url('frontend_assets/images/hero/hero-image-1.svg')}})">
    <div class="container">
        <div class="page-banner-content">
            <h1>All Cooperatives</h1>
            <h5> Join a Cooperative Today</h5>
            {{-- <ul>
                <li><a href="index.html">Home</a></li>
                <li>Services</li>
            </ul> --}}
        </div>
    </div>

    <div class="shape-image">
        <img class="page-banner-shape-1 moveHorizontal_reverse" src="frontend_assets/images/coopicon.png" alt="shape">
        <img class="page-banner-shape-2 moveVertical" src="frontend_assets/images/coopicon.png" alt="shape">
    </div>
</div>

<div class="our-services-area ptb-120">
    <div class="container">
        {{-- <div class="section-title">
            <span class="sub-title two bg-color-9edd05 rounded-pill">OUR SERVICES</span>
            <h2>Get Started And Enjoy Full Service Features</h2>
        </div>  --}}
        <div class="row g-4 justify-content-center" data-cues="slideInUp" data-duration="800" data-disabled="true">
            
            @foreach($cooperatives as $cooperative)
            <div class="col-lg-4 col-md-6" data-cue="slideInUp" data-duration="800" data-show="true" style="animation-name: slideInUp; animation-duration: 800ms; animation-timing-function: ease; animation-delay: 0ms; animation-direction: normal; animation-fill-mode: both;">
                <div class="single-services-card bg-color-fffaeb radius-30">
                    <h3>
                        <a href="{{ route('cooperatives.details', $cooperative->id) }}">{{ $cooperative->name }}</a>
                    </h3>
                    <p>{{ $cooperative->description }}</p>
                   
                    <div class="flex-wrap d-flex align-items-center justify-content-between">
                        <i class="fas fa-building mission" style="font-size: 0.85rem; color: #555;">
                            Reg Fee: &#8358;{{ number_format($cooperative->reg_fee, 2) }}
                        </i>
                        <a href="/signup/{{$cooperative->slug}}" class="arrow-btn">
                            <i class="ri-arrow-right-up-line"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        
        <div class="service-pagination mt-5">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="services.html" aria-label="Next">
                            <span aria-hidden="true">
                                <i class="ri-arrow-left-s-line"></i>
                            </span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link active" href="services.html">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="services.html">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="services.html">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="services.html" aria-label="Next">
                            <span aria-hidden="true">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@section('script')
@endsection