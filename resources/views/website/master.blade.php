<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>1 Million Hands</title>
      <meta name="keywords" content="1 Million Hands Global Initiative">
      <meta name="description" content="1 Million Hands Global Initiative">
      <meta name="author" content="1 Million Hands Global Initiative">
     @include('website.css')
   </head>
   <body>
      <!-- header section start -->
     @include('website.header')
      @yield('content')
      <!-- contact section end -->
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-3 col-sm-6">
                  <h1 class="customer_text">INFORMATION</h1>
                  <p class="footer_lorem_text">There are many variat
                     ions of passages of L
                     orem Ipsum available
                     , but the majority h
                     ave suffered altera
                     tion in some form, by
                  </p>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h1 class="customer_text">LET US HELP YOU</h1>
                  <p class="footer_lorem_text">There are many variat
                     ions of passages of L
                     orem Ipsum available
                     , but the majority h
                     ave suffered altera
                     tion in some form, by
                  </p>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h1 class="customer_text">UseFul Links</h1>
                  <p class="footer_lorem_text1">About Us<br>
                     Careers<br>
                     Sell on shopee<br>
                     Press & News<br>
                     Competitions<br>
                     Terms & Conditions
                  </p>
               </div>
               <div class="col-lg-3 col-sm-6">
                  <h1 class="customer_text">OUR Design</h1>
                  <p class="footer_lorem_text">There are many variat
                     ions of passages of L
                     orem Ipsum available
                     , but the majority h
                     ave suffered altera
                     tion in some form, by
                  </p>
               </div>
            </div>
            <div class="input-group mb-3">
               <input type="text" class="form-control" placeholder="Enter your email" aria-label="Enter your email" aria-describedby="basic-addon2">
               <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2"><a href="#">Subscribe</a></span>
               </div>
            </div>
         </div>
      </div>
      <!--  footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
      <div class="container">
         <p class="copyright_text">{{ now()->year }} All Rights Reserved By <a href="#">1 Million Hands</a> Designed By <a href="#">HBH Software</a></p>
      </div>
      <!-- copyright section end -->
     @include('website.js')
   </body>
</html>
