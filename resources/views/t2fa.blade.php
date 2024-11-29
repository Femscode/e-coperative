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
<style>
    .field-icon {
        float: right;
        left: -10px;
        margin-top: -23px;
        position: relative;
        z-index: 2;
    }
</style>
@endsection

@section('content')
{{-- <div class="page-banner-area position-relative overflow-hidden" style="background-image: {{ url('frontend_assets/images/hero/hero-image-1.svg') }}"> --}}
{{-- <div class="page-banner-area position-relative overflow-hidden" style='background-color: #e5f7b3;' class="card-body p-4 bg-color-e5f7b3"> --}}
<div class="page-banner-area position-relative overflow-hidden" style="background-image: url(frontend_assets/images/hero/hero-image-1.svg)">
    {{-- <div style='background-color: #e5f7b3;' class="card-body p-4 bg-color-e5f7b3"> --}}
    <div class="container">
        <div class="page-banner-content">
            <h1>OTP VERIFICATION</h1>
            <ul>
                <li><a href="/">Home</a></li>
                <li>Sign In</li>
            </ul>
        </div>
    </div>
    <div class="shape-image">
        <img class="page-banner-shape-1 moveHorizontal_reverse" src="{{ url('frontend_assets/images/shape/feature-shape-1.png') }}" alt="shape">
        <img class="page-banner-shape-2 moveVertical" src="{{ url('frontend_assets/images/shape/feature-shape-1.png') }}" alt="shape">
    </div>
</div>

<body>

    <div class="auth-page-wrapper pt-5">


        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">

                {{-- <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                        
                            <div class="card-body p-4"> 
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Forgot Password?</h5>
                                    <p class="text-muted">Reset password with email</p>
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <div class="alert alert-borderless alert-warning text-center mb-2 mx-2" role="alert">
                                    Enter your email and instructions will be sent to you!
                                </div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="text-center mt-4">
                                            <button class="btn btn-success w-100" type="submit">Send Reset Link</button>
                                        </div>
                                    </form><!-- end form -->
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Wait, I remember my password... <a href="/logout" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
                        </div>

                    </div>
                </div> --}}

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                        
                            <div class="card-body p-4"> 
                                <div class="mb-4">
                                    <div class="avatar-lg mx-auto">
                                        <div class="avatar-title bg-light text-primary display-5 rounded-circle">
                                            <i class="ri-mail-line"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="p-2 mt-4">
                                    <div class="text-muted text-center mb-4 mx-lg-3">
                                        <h4 class="">Verify Your OTP</h4>
                                        <p>Please enter the 4 digit code sent to  <span class="fw-semibold">{{ substr(explode('@', Auth::user()->email )[0], 0, 4) . 'xxxx@' . explode('@', Auth::user()->email )[1] }}</span></p>
                                    </div>
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form method="post" id="verifyOtp" >
                                        @csrf
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit1-input" class="visually-hidden">Dight 1</label>
                                                    <input type="text" name="a"
                                                        class="form-control form-control-lg bg-light border-light text-center"
                                                        onkeyup="moveToNext(this, 2)" maxLength="1"
                                                        id="digit1-input">
                                                </div>
                                            </div><!-- end col -->
        
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit2-input" class="visually-hidden">Dight 2</label>
                                                    <input type="text" name="b"
                                                        class="form-control form-control-lg bg-light border-light text-center"
                                                        onkeyup="moveToNext(this, 3)" maxLength="1"
                                                        id="digit2-input">
                                                </div>
                                            </div><!-- end col -->
        
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit3-input" class="visually-hidden">Dight 3</label>
                                                    <input type="text" name="c"
                                                        class="form-control form-control-lg bg-light border-light text-center"
                                                        onkeyup="moveToNext(this, 4)" maxLength="1"
                                                        id="digit3-input">
                                                </div>
                                            </div><!-- end col -->
        
                                            <div class="col-3">
                                                <div class="mb-3">
                                                    <label for="digit4-input" class="visually-hidden">Dight 4</label>
                                                    <input type="text" name="d"
                                                        class="form-control form-control-lg bg-light border-light text-center"
                                                        onkeyup="moveToNext(this, 4)" maxLength="1"
                                                        id="digit4-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-success w-100">Confirm</button>
                                        </div>
                                    </form><!-- end form -->
        
                                    
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Didn't receive a code ? <a href="{{ route('t2fa') }}" class="fw-semibold text-primary text-decoration-underline">Resend</a> </p>
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
                            <p class="mb-0 text-muted">&copy; <script>
                                    document.write(new Date().getFullYear())
                                </script>, 1 Million Hands Global Initiative! Crafted with <i class="mdi mdi-heart text-danger"></i> by HBH Software!</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $("#member_login").on('click', function() {
                $("#email").val('member2@gmail.com')
                $("#password").val('Password123')
            });
            $("#admin_login").on('click', function() {
                $("#email").val('payazacooperative@gmail.com')
                $("#password").val('Password123')
            });
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $("#password");
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
              $('#loginButton').click(function(e) {
            e.preventDefault();

            // Display loading alert
            Swal.fire({
                title: 'Logging in...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX request for login
            $.ajax({
                url: "{{ route('login') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function(response) {
                    Swal.close(); // Close loading alert
                    
                    // Check if login was successful
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful!',
                            text: 'Redirecting...',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = response.redirect || '/dashboard'; // Redirect after successful login
                        });
                    } else {
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text:  'Invalid email or password.'
                            // text: response.message || 'Invalid email or password.'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Error',
                        text: 'An error occurred. Please try again.'
                    });
                }
            });
        });

        });
    </script>
</body>

@endsection