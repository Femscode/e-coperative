<!doctype html>
<html lang="en">
<!-- Mirrored from www.adminuiux.com/adminuiux/investment-uiux/investment-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Dec 2024 11:53:11 GMT -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SyncoSave | Cooperative Registration</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Open+Sans:ital,wght@0,300..800;1,300..800&amp;display=swap" rel="stylesheet">
    <style>
        :root {
            --adminuiux-content-font: "Open Sans", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Lexend", sans-serif;
            --adminuiux-title-font-weight: 600
        }
    </style>
    <script defer="defer" src="{{url('memberdashboard/js/appb174.js?ff1e8ee7ca91d18f44ea')}}"></script>
    <link href="{{url('memberdashboard/css/appb174.css?ff1e8ee7ca91d18f44ea')}}" rel="stylesheet">


    <script src="{{ url('admindashboard/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('admindashboard/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" integrity="sha384-tViUnnbYAV00FLIhhi3v/dWt3Jxw4gZQcNoSCxCIFNJVCx7/D55/wXsrNIRANwdD" crossorigin="anonymous">


    <link href="{{ url('admindashboard/css/sweetalert-custom.css') }}" rel="stylesheet">

    <script src="{{ asset('admindashboard/js/sweetalert-custom.js') }}"></script>
    <style>
        .step-arrow-nav .nav-pills .nav-link {
            position: relative;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .step-arrow-nav .nav-pills .nav-link.active {
            background: #094168;
            color: white;
        }

        .step-arrow-nav .nav-pills .nav-link.done {
            background: #0941684d;
            color: #094168;
        }

        .tab-pane {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control:focus {
            border-color: #094168;
            box-shadow: 0 0 0 0.2rem rgba(8, 39, 32, 0.25);
        }

        .btn-theme {
            background: #094168;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-theme:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(8, 39, 32, 0.2);
        }

        .progress-indicator {
            height: 4px;
            background: #e9ecef;
            margin: 20px 0;
            border-radius: 2px;
        }

        .progress-indicator .progress {
            height: 100%;
            background: #094168;
            border-radius: 2px;
            transition: width 0.3s ease;
        }
    </style>
    @yield('header')
</head>

<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed theme-blue roundedui" data-theme="theme-blue" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0"></body>

</html>
<div class="pageloader">
    <div class="container h-100">
        <div class="row justify-content-center align-items-center text-center h-100">
            <div class="col-12 mb-auto pt-4"></div>
            <div class="col-auto">
                <img src="{{ asset('admindashboard/images/logo/syncologo2.png') }}" alt="" class="height-60 mb-3">
                <p class="h6 mb-0">Welcome to SyncoSave</p>
                <p class="h3 mb-4">Your Financial Future Starts Here</p>
                <div class="loader10 mb-2 mx-auto"></div>
            </div>
            <div class="col-12 mt-auto pb-4">
                <p class="text-secondary">Preparing your personalized experience...</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title text-center" id="paymentModalLabel">Complete Payment With Payaza</h5> -->
                <img src='{{url("assets/images/payaza1.gif")}}' alt='payaza' width='50%' />

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payaza-form">
                    <div class='alert alert-danger'>For testing purpose, kindly use the default prefilled card details</div>
                    <div class='text-center'>Amount To Be Paid</div>
                    <h1 class='text-center text-red' style='color:#212529;border:0px'>NGN<span id='amountToBePaid'>0</span></h1>
                    <div class="mb-3">
                        <label for="card-number" class="form-label">Card Number</label>
                        <input type='hidden' id='order_id' />

                        <input type="text" value='4012000033330026' id="card-number" class="form-control" required placeholder="Enter Card Number">
                    </div>
                    <div class='form-group row'>
                        <div class="mb-3 col">
                            <label for="expiry-date" class="form-label">Expiry Date</label>
                            <input value='01/39' type="text" id="expiry-date" class="form-control" required placeholder="MM/YY">
                        </div>
                        <div class="mb-3 col">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" value='100' id="cvv" class="form-control" required placeholder="Enter CVV">
                        </div>
                    </div>
                    <div class='justify-content-center d-flex'>
                        <button type="submit" style='background:#212529;border:0px' class="btn btn-success">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<main class="flex-shrink-0 pt-0 h-100">
    <div class="container-fluid">
        <div class="auth-wrapper">
            <div class="row">
                <div class="col-12 col-md-6 col-xl-6 minvheight-100 d-flex flex-column px-0">
                    <header class="adminuiux-header">
                        <nav class="navbar">
                            <div class="container-fluid"><a class="navbar-brand" href="investment-dashboard.html">
                                    <img src="{{ asset('admindashboard/images/logo/syncologo2.png') }}" alt="" style="width:150px" class="height-60 mb-3">


                                </a>
                                <div class="ms-auto"></div>
                                <div class="ms-auto"></div>
                            </div>
                        </nav>
                    </header>
                    <div class="h-100 py-4 px-3">
                        <div class="row h-100 align-items-center justify-content-center mt-md-4">
                            <div class="col-11 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box">

                                <form action='save_coop_reg' method="post">
                                    @csrf
                                    <div class="text-center mt-2">
                                        <h3 style='color:#094168' class="text-">Go Digital, Go Far!</h3>
                                        <h6> Bring Your Cooperative into the Digital Age!</h6>

                                    </div>
                                    <div class="step-arrow-nav mb-4">
                                        <ul class="nav nav-pills custom-nav nav-justified" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link done active" id="steparrow-gen-info-tab"
                                                    data-bs-toggle="pill" data-bs-target="#steparrow-gen-info"
                                                    type="button" role="tab" aria-controls="steparrow-gen-info"
                                                    aria-selected="true">
                                                    General
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link " id="steparrow-description-info-tab"
                                                    data-bs-toggle="pill"
                                                    data-bs-target="#steparrow-description-info" type="button"
                                                    role="tab" aria-controls="steparrow-description-info"
                                                    aria-selected="false">
                                                    Description
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-experience-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-experience"
                                                    type="button" role="tab" aria-controls="pills-experience"
                                                    aria-selected="false">
                                                    Finish
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="steparrow-gen-info" role="tabpanel"
                                            aria-labelledby="steparrow-gen-info-tab">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="gen-info-password-input">Co-operative Name</label>
                                                    <input type="text" class="form-control" required name="name"
                                                        id="gen-info-password-input" placeholder="Enter Full Name Of Your Co-operative" />
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="gen-info-email-input">Email</label>
                                                            <input type="email" class="form-control" required name="email"
                                                                id="gen-info-email-input email"
                                                                placeholder="Enter email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="gen-info-username-input">Phone Number</label>
                                                            <input type="number" class="form-control" required name="phone"
                                                                id="gen-info-username-input"
                                                                placeholder="Enter phone number" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button style='background-color:#094168;border:0px' type="button"
                                                    class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                    data-nexttab="steparrow-description-info-tab">
                                                    <i
                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->

                                        <div class="tab-pane fade " id="steparrow-description-info"
                                            role="tabpanel" aria-labelledby="steparrow-description-info-tab">
                                            <div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="gen-info-email-input">Description</label>
                                                            <textarea type="text" class="form-control" name="description"
                                                                placeholder="Short description / Bio "></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="gen-info-email-input">Address</label>
                                                            <input type="text" class="form-control" name="address"
                                                                placeholder="Physical address of meeting place " />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="gen-info-email-input">Password</label>
                                                            <input type="password" class="form-control" required name="password"
                                                                id="password-fieldx"
                                                                placeholder="Enter password " />
                                                            <span toggle="#password-fieldx" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label"
                                                                for="gen-info-username-input">Confirm Password</label>
                                                            <input type="password" class="form-control" required name="password_confirmation"
                                                                id="password-fieldc"
                                                                placeholder="Confirm password" />
                                                            <span toggle="#password-fieldc" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                        </div>
                                                    </div>
                                                    <div id='danger_password'></div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button style='background-color:#094168;border:0px' type="button" class="btn btn-success btn-label previestab"
                                                    data-previous="steparrow-gen-info-tab">
                                                    <i
                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to General
                                                </button>
                                                <button style='background-color:#094168;border:0px' type="button"
                                                    class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                    data-nexttab="pills-experience-tab">
                                                    <i
                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Finish
                                                </button>
                                                {{-- <button type="button"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="pills-experience-tab">
                                                        <i
                                                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit
                                                    </button> --}}
                                            </div>
                                        </div>
                                        <!-- end tab pane -->

                                        <div class="tab-pane fade" id="pills-experience" role="tabpanel">
                                            <div>

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-password-input">Specification</label>
                                                            <select class='form-control' required name='type'>
                                                                <option value="">--Select Specification--</option>
                                                                <option value='1'>Cooperative</option>
                                                                <option value='2'>Contribution</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <input type="radio" /> I Agree to the <a href='#'>terms & conditions.</a>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button style='background-color:#094168;border:0px' type="button" class="btn btn-light btn-label previestab"
                                                    data-previous="steparrow-description-info-tab">
                                                    <i
                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to Description
                                                </button>
                                                <button style='background-color:#094168;border:0px' type="submit"
                                                    class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                    data-nexttab="pills-experience-tab">
                                                    <i
                                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                    </div>
                                    <!-- end tab content -->
                                </form>
                                <div class="text-center mb-3">Already have an account? <a href="/login" class="">Login</a></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6 col-xl-6 p-4 d-none d-md-block">
                    <div class="card adminuiux-card bg-theme-1-space position-relative overflow-hidden h-100">
                        <div class="position-absolute start-0 top-0 h-100 w-100 coverimg opacity-75 z-index-0"><img src="assets/img/background-image/background-image-8.html" alt=""></div>
                        <div class="card-body position-relative z-index-1">
                            <div class="row h-100 d-flex flex-column justify-content-center align-items-center gx-0 text-center">
                                <div class="col-10 col-md-11 col-xl-8 mb-4 mx-auto">
                                    <div class="swiper swipernavpagination pb-5">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <img src="assets/img/investment/slider.png" alt="" class="mw-100 mb-3">
                                                <h2 class="text-white mb-3">"When we save together, we grow together. Cooperative savings is the foundation of community wealth."</h2>
                                                <p class="lead opacity-75">- Fasanya Oluwapelumi</p>
                                            </div>


                                        </div>
                                        <div class="swiper-pagination white bottom-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
  $(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 3;
    updateStepIndicators(currentStep);

    // Next button click handler - only for navigation buttons
    $('.nexttab:not([type="submit"])').click(function(e) {
        e.preventDefault();
        const nextTabId = $(this).data('nexttab');

        if (validateCurrentStep(currentStep)) {
            $(`#${nextTabId}`).tab('show');
            currentStep++;
            updateStepIndicators(currentStep);
        }
    });

    // Previous button click handler
    $('.previestab').click(function(e) {
        e.preventDefault();
        const prevTabId = $(this).data('previous');
        $(`#${prevTabId}`).tab('show');
        currentStep--;
        updateStepIndicators(currentStep);
    });

    // Form submit handler
    $('form').on('submit', function(e) {
        e.preventDefault();
        if (validateCurrentStep(currentStep)) {
            // If validation passes, submit the form
            this.submit();
        }
    });

    // Rest of the functions remain the same
    function updateStepIndicators(step) {
        $('.nav-link').removeClass('active done');
        for (let i = 1; i < step; i++) {
            $(`.nav-pills .nav-link:nth-child(${i})`).addClass('done');
        }
        $(`.nav-pills .nav-link:nth-child(${step})`).addClass('active');
    }

    function validateCurrentStep(step) {
        let isValid = true;
        const currentPane = $(`.tab-pane:nth-child(${step})`);

        currentPane.find('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
                showCustomAlert({
                    title: 'Required Fields',
                    text: 'Please fill in all required fields',
                    icon: 'warning'
                });
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        return isValid;
    }
});
</script>
<script src="assets/js/investment/investment-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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


        $("#password-fieldx, #password-fieldc").on('input', function() {

            var password = $("#password-fieldx").val()
            var confirm = $("#password-fieldc").val()
            if (password.length > 7) {
                if (password !== confirm) {
                    $("#danger_password").html("<div class='alert alert-danger'>Password not matched!</div>");
                } else {
                    $("#danger_password").html("<div class='alert alert-success'>Password matched!</div>")
                }
            }

        })
    });
</script>