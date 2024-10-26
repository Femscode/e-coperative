@extends('frontend.master')
@section('header')
<script src="{{url('assets/js/layout.js')}}"></script>
        <!-- Bootstrap Css -->
        <link href="{{url('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{url('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{url('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{url('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
   
@endsection

@section('content')
<div class="page-banner-area position-relative overflow-hidden" style="background-image: url(frontend_assets/images/hero/hero-image-1.svg)">
    <div class="container">
        <div class="page-banner-content">
            <h1>Sign Into Your Account</h1>
            <ul>
                <li><a href="/">Home</a></li>
                <li>Sign In</li>
            </ul>
        </div>
    </div>
    <div class="shape-image">
        <img class="page-banner-shape-1 moveHorizontal_reverse" src="frontend_assets/images/shape/feature-shape-1.png" alt="shape">
        <img class="page-banner-shape-2 moveVertical" src="frontend_assets/images/shape/feature-shape-1.png" alt="shape">
    </div>
</div>

<body>

<div class="auth-page-wrapper pt-5">
   

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">
                    
                        <div style='background-color: #e5f7b3;' class="card-body p-4 bg-color-e5f7b3"> 
                            <div class="text-center mt-2">
                                <h3 class="text-primary" style='color:#082720'>Welcome Back !</h3>
                                <p class="text-dark">Sign in to access your account.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" action="{{route('login')}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Enter email address" value="{{ old('email') }}" required autocomplete="email" autofocus>  
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror     
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password-fieldp" placeholder="Enter password" required>
                                        <span toggle="#password-fieldp" class="fas toggle-password field-icon fa-eye-slash"></span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    
                                   

                                    <div class="mb-4">
                                        <!-- <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the Velzon <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p> -->
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button style='background-color: #082720 ;border:0px' class="btn btn-success w-100" type="submit">
                                        {{ __('Login') }}
                                        </button>

                                        @if (Route::has('password.request'))
                                         <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>

                                    
                                </form>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Don't have an account ? <a href="{{route('register')}}" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script>, 1 Million Hands Global Initiative! Crafted with <i class="mdi mdi-heart text-danger"></i> by HBH Software!</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="assets/js/plugins.js"></script>

<!-- particles js -->
<script src="assets/libs/particles.js/particles.js"></script>
<!-- particles app js -->
<script src="assets/js/pages/particles.app.js"></script>
<!-- validation init -->
<script src="assets/js/pages/form-validation.init.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".toggle-password").click(function() {			
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    });
</script>
</body>

@endsection
