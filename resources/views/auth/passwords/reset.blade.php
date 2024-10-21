<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    
<head>
        
        <meta charset="utf-8" />
        <title>1 Million Hands - Change Password </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="1 Million Hands Global Initiative" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Layout config Js -->
        <script src="{{ asset('assets/js/layout.js') }}"></script>
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
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

    </head>

    <body>

        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->
            <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
                <div class="bg-overlay"></div>
                
                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                    </svg>
                </div>
            </div>

            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                    <a href="/" class="d-inline-block auth-logo">
                                        <img src="{{ asset('website/images/logo4.png')}}" alt="" height="60">
                                    </a>
                                </div>
                                {{-- <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p> --}}
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="card mt-4">
                            
                                <div class="card-body p-4"> 
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Reset Password?</h5>
                                        <p class="text-muted">{{ substr(explode('@', $email ?? old('email'))[0], 0, 4) . 'xxxx@' . explode('@', $email ?? old('email'))[1] }}</p>
                                    </div>
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <div class="p-2">
                                        <form method="POST" action="{{ route('password.update') }}">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $token }}">
                                            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                                            <div class="mb-4">
                                                <label class="form-label">Password</label>
                                                <input type="password" class="form-control" id="password-fieldc" name="password" placeholder="Enter New Password">
                                                <span toggle="#password-fieldc" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label">Confirm Password</label>
                                                <input type="password" class="form-control" id="password-fieldp" name="password_confirmation" placeholder="Confirm New Password">
                                                <span toggle="#password-fieldp" class="fas toggle-password field-icon fa-eye-slash"></span>
                                            </div>
                                            
                                            <div class="text-center mt-4">
                                                <button class="btn btn-success w-100" type="submit">Reset Password</button>
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
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>

        <!-- particles js -->
        <script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
        <!-- particles app js -->
        <script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
        <!-- validation init -->
        <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
        <script src="{{ asset('swal.js') }}"></script>
        <script>
            @if ($errors->any())
                Swal.fire('Oops...', "{!! implode('', $errors->all('<p>:message</p>')) !!}", 'error')
            @endif
    
            @if (session()->has('message'))
                Swal.fire(
                    'Success!',
                    "{{ session()->get('message') }}",
                    'success'
                )
            @endif
            @if (session()->has('success'))
                Swal.fire(
                    'Success!',
                    "{{ session()->get('success') }}",
                    'success'
                )
            @endif
        </script>
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

</html>