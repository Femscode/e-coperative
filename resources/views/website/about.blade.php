@extends('website.master')

@section('content')
<!-- about section start -->
<div class="about_section layout_padding">
    <div class="container">
       <div class="row">
          <div class="col-md-6">
             <h1 class="about_text">About Us</h1>
             <p class="lorem_text">Learn about our mission, values, and the people behind our cooperative. We're a diverse group of individuals united by a common purpose.</p>
             <div class="read_bt1"><a href="#">Read More</a></div>
          </div>
          <div class="col-md-6">
             <div class="image_1"><img src="{{ asset('website/images/img5.jpg') }}"></div>
          </div>
       </div>
    </div>
 </div>
 <!-- about section end -->
@endsection