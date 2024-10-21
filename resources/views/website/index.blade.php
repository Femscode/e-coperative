@extends('website.master')

@section('content')
    <!-- banner section start -->
    <div class="banner_section layout_padding">
        <div class="container">
            <div id="costum_slider" class="carousel slide" data-ride="carousel" style="height: 200px">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h1 class="furniture_text">Community</h1>
                        <p class="there_text">we believe in the power of collaboration and community. Explore our site to
                            discover how we're making a difference together</p>
                        <div class="contact_bt_main">
                            <div class="contact_bt"><a href="{{ route('register') }}">Join Us</a></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <h1 class="furniture_text">Collaboration</h1>
                        <p class="there_text">Dive into the exciting projects and initiatives we're currently involved in.
                            From renewable energy to community education, we're working on projects that matter</p>
                        <div class="contact_bt_main">
                            <div class="contact_bt"><a href="{{ route('register') }}">Register With Us</a></div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <h1 class="furniture_text">Membership</h1>
                        <p class="there_text">Interested in becoming a member? Learn how to join our cooperative and be a
                            part of a thriving, cooperative movement.</p>
                        <div class="contact_bt_main">
                            <div class="contact_bt"><a href="{{ route('register') }}">Join Today</a></div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#costum_slider" role="button" data-slide="prev">
                    <i class=""><img src="{{ asset('website/images/left-arrow.png') }}"></i>
                </a>
                <a class="carousel-control-next" href="#costum_slider" role="button" data-slide="next">
                    <i class=""><img src="{{ asset('website/images/right-arrow.png') }}"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- banner section end -->
    </div>
    <!-- header section end -->
    <!-- services section start -->
    @if($plans->count() > 0)
    <div class="services_section layout_padding">
        <div class="container">
            <h1 class="services_taital">our plans</h1>
            <p class="many_taital">There are many variations of packages we offer </p>
            <div class="services_section2 layout_padding">
                <div class="row">
                    @foreach ($plans as $plan)
                        <div class="@if($plans->count() == 2)col-lg-6 @elseif ($plans->count() == 3)col-lg-4 @else col-lg-3 @endif col-sm-6">
                            <div class="icon_1"><img src="{{ asset('website/images/icon-2.png') }}"></div>
                            <h2 class="furnitures_text">{{ $plan->name }}</h2>
                            <p class="dummy_text">{{ $plan->note }}
                            </p>
                            <div class="read_bt_main">
                                <div class="read_bt"><a href="{{ route('plan-page') }}">Check Plan</a></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- services section end -->
    <!-- about section start -->
    <div class="about_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="about_text">About Us</h1>
                    <p class="lorem_text">Learn about our mission, values, and the people behind our cooperative. We're a
                        diverse group of individuals united by a common purpose.</p>
                    <div class="read_bt1"><a href="/about-us">Read More</a></div>
                </div>
                <div class="col-md-6">
                    <div class="image_1"><img src="{{ asset('website/images/img5.jpg') }}"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- about section end -->
    <!-- furnitures section start -->
    {{-- <div class="furnitures_section layout_padding">
   <div class="container">
      <h1 class="our_text">OUR furnitures</h1>
      <p class="ipsum_text">There are many variations of passages of Lorem Ipsum </p>
      <div class="furnitures_section2 layout_padding">
         <div class="row">
            <div class="col-md-6">
               <div class="container_main">
                          <img src="{{ asset('website/images/img-2.png')}}" alt="Avatar" class="image">
                  <div class="overlay">
                     <a href="#" class="icon" title="User Profile">
                     <i class="fa fa-search"></i>
                     </a>
                  </div>
               </div>
               <h3 class="temper_text">Tempor incididunt ut labore et dolore</h3>
               <p class="dololr_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi </p>
            </div>
            <div class="col-md-6">
               <div class="container_main">
                          <img src="{{ asset('website/images/img-3.png')}}" alt="Avatar" class="image">
                  <div class="overlay">
                     <a href="#" class="icon" title="User Profile">
                     <i class="fa fa-search"></i>
                     </a>
                  </div>
               </div>
               <h3 class="temper_text">Tempor incididunt ut labore et dolore</h3>
               <p class="dololr_text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi </p>
            </div>
         </div>
      </div>
   </div>
</div> --}}
    <!-- furnitures section end -->
    <!-- who section start -->
    <div class="who_section layout_padding">
        <div class="container">
            <h1 class="who_taital">who we are ?</h1>
            <h4 class="designer_text">HELP & GROWTH</h4>
            <p class="lorem_ipsum_text">At One Million Hands, we are more than just an organization; we are a vibrant
                community of individuals united by a common vision. Our cooperative was founded on the principles of
                collaboration, sustainability, and the belief that together, we can achieve remarkable things.

                Our journey began [Year of Establishment] with a small group of passionate individuals who shared a dream of
                building a better future for our community. Since then, we have grown into a thriving cooperative that
                touches the lives of many.</p>
        </div>
        <div class="get_bt_main">
            <div class="get_bt"><a href="/about-us">Get A Quote</a></div>
        </div>
    </div>
    <!-- who section end -->
    <!-- projects section start -->
    {{-- <div class="projects_section layout_padding">
   <div class="container">
      <h1 class="our_text">Our projects</h1>
      <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
      <div id="main_slider" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="projects_section2">
                  <div class="container_main2">
                     <div class="row">
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-4.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-5.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-6.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <div class="projects_section2">
                  <div class="container_main1">
                     <div class="row">
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-4.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-5.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-6.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <div class="projects_section2">
                  <div class="container_main1">
                     <div class="row">
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-4.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-5.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-4">
                           <div class="container_main1">
                                      <img src="{{ asset('website/images/img-6.png')}}" alt="Avatar" class="image" style="width:100%">
                              <h1 class="modern_text">Modern home designe</h1>
                              <div class="middle">
                                 <div class="text">VIEW MORE</div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
         <i class="fa fa-angle-left"></i>
         </a>
         <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
         <i class="fa fa-angle-right"></i>
         </a>
      </div>
   </div>
</div> --}}
    <!-- projects section end -->
    <!-- client section start -->
    {{-- <div class="clients_section layout_padding">
   <div class="container">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
         <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
         </ol>
         <div class="carousel-inner">
            <div class="carousel-item active">
               <h1 class="client_text">what is says our clients</h1>
               <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
               <div class="clients_section2 layout_padding">
                  <div class="client_1">
                     <div class="row">
                        <div class="col-sm-3">
                                  <div class="image_7"><img src="{{ asset('website/images/img-7.png')}}"></div>
                                  <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
                  <div class="client_2">
                     <div class="row">
                        <div class="col-sm-3">
                                  <div class="image_7"><img src="{{ asset('website/images/img-8.png')}}"></div>
                                  <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <h1 class="client_text">what is says our clients</h1>
               <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
               <div class="clients_section2 layout_padding">
                  <div class="client_1">
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="image_7"><img src="{{ asset('website/images/img-7.png')}}"></div>
                           <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
                  <div class="client_2">
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="image_7"><img src="{{ asset('website/images/img-8.png')}}"></div>
                           <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <h1 class="client_text">what is says our clients</h1>
               <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
               <div class="clients_section2 layout_padding">
                  <div class="client_1">
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="image_7"><img src="{{ asset('website/images/img-7.png')}}"></div>
                           <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
                  <div class="client_2">
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="image_7"><img src="{{ asset('website/images/img-8.png')}}"></div>
                           <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item">
               <h1 class="client_text">what is says our clients</h1>
               <p class="ipsum_text">Lorem ipsum dolor sit amet, consectetur adipiscing</p>
               <div class="clients_section2 layout_padding">
                  <div class="client_1">
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="image_7"><img src="{{ asset('website/images/img-7.png')}}"></div>
                           <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
                  <div class="client_2">
                     <div class="row">
                        <div class="col-sm-3">
                           <div class="image_7"><img src="{{ asset('website/images/img-8.png')}}"></div>
                           <div class="quote_icon"><img src="{{ asset('website/images/quote-icon.png')}}"></div>
                        </div>
                        <div class="col-sm-9">
                           <h1 class="loksans_text">loksans</h1>
                           <p class="dolor_ipsum_text">ipsum dolor sit amet, consectetur adipiscing elit, sed  veniam, quis nostrud exercitation ullamco laboris nisi ut reprehenderit in voluptate velit</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div> --}}
    <!-- client section end -->
    <!-- contact section start -->
    <div class="contact_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="contact_text">CONTACT US</h1>
                    <div class="mail_sectin">
                        <input type="text" class="email-bt" placeholder="Name" name="Name">
                        <input type="text" class="email-bt" placeholder="Email" name="Name">
                        <input type="text" class="email-bt" placeholder="Phone Number" name="Name">
                        <textarea class="massage-bt" placeholder="Massage" rows="5" id="comment" name="Massage"></textarea>
                        <div class="send_bt"><a href="#">SEND</a></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="map_main">
                        <div class="map-responsive">
                            <iframe
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=jgm holiness bible church+Obada+Ogun+Nigeria"
                                width="600" height="500" frameborder="0" style="border:0; width: 100%;"
                                allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
