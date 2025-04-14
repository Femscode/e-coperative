<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SyncoSave | Login</title>
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


<main class="flex-shrink-0 min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <!-- Left Column - Registration Form -->
            <div class="col-12 col-lg-5 p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('admindashboard/images/logo/syncologo2.png') }}" alt="SyncoSave" class="mb-4" style="width: 160px;">
                    <h2 class="fw-bold mb-2">Create Your Account</h2>
                    @if(isset($slug))
                    <p class="text-muted">Join {{ $company->name }} today!</p>
                    @else
                    <p class="text-muted">Join a cooperative today!</p>
                    @endif
                </div>

                <form id="process-order-form" method="post" class="registration-form">
                    @csrf
                    <!-- Progress Steps -->
                    <div class="registration-steps mb-4">
                        <div class="step-indicators d-flex justify-content-between position-relative">
                            <div class="progress-line position-absolute">
                                <div class="progress-line-fill"></div>
                            </div>
                            <div class="step active" data-step="1">
                                <div class="step-number">1</div>
                                <span class="step-text">Personal Info</span>
                            </div>
                            <div class="step" data-step="2">
                                <div class="step-number">2</div>
                                <span class="step-text">Account Setup</span>
                            </div>
                            <div class="step" data-step="3">
                                <div class="step-number">3</div>
                                <span class="step-text">Finish</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Steps Content -->
                    <div class="tab-content">
                        <!-- Step 1: Personal Information -->
                        <div class="tab-pane fade show active" id="step1">
                        <div class="mb-3">
                                <label class="form-label">Select Cooperative</label>
                                @if(isset($company) && $company)
                                    <input type="hidden" name="company" value="{{ $company->id }}">
                                    <input type="text" class="form-control" value="{{ $company->name }}" readonly>
                                @else
                                    <select class="form-control form-select planId" name="company" >
                                        <option value="">Choose a cooperative</option>
                                        @foreach(\App\Models\Company::where('visibility','public')->get() as $cooperative)
                                            <option value="{{ $cooperative->id }}">{{ $cooperative->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <div class="invalid-feedback">Please select a cooperative</div>
                            </div>

                            <div class="displayReg mb-3" style="display: none;">
                                <div class="alert alert-info">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <div>
                                            <h6 class="mb-0">Registration Fee Required</h6>
                                            <p class="mb-0">Amount: ₦<span class="fee-amount">0</span></p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="feeInput" name="registration_fee">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name" id="fullName" required>
                                <div class="invalid-feedback">Please enter your full name</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                    <div class="invalid-feedback">Please enter a valid email address</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" class="form-control" name="phone" id="phone" required>
                                    <div class="invalid-feedback">Please enter your phone number</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary px-4 nexttab" data-nexttab="step2">
                                    Next <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Account Setup -->
                        <div class="tab-pane fade" id="step2">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" id="address" required>
                                <div class="invalid-feedback">Please enter your address</div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" name="password" id="password-fieldx" required>
                                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div id="password-strength" class="mt-2"></div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" name="password_confirmation" id="password-fieldc" required>
                                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y toggle-password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="danger_password"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary previestab" data-previous="step1">
                                    <i class="bi bi-arrow-left me-2"></i> Back
                                </button>
                                <button type="button" class="btn btn-primary nexttab" data-nexttab="step3">
                                    Next <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Final Step -->
                        <div class="tab-pane fade" id="step3">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                                </div>
                                <h4>Review Your Information</h4>
                                <div class="review-info mt-4"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary previestab" data-previous="step2">
                                    <i class="bi bi-arrow-left me-2"></i> Back
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Complete Registration <i class="bi bi-check2 ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Already have an account?
                        <a href="/login" class="text-primary">Sign in</a>
                    </p>
                </div>
            </div>

            <!-- Right Column - Banner -->
            <div class="col-lg-7 d-none d-lg-block">
                <div  class="position-relative h-100 bg-primary bg-gradient rounded-4 p-5">
                    <div class="position-absolute top-50 start-50 translate-middle text-center text-white" style="width: 80%;">
                        <h1 class="display-5 fw-bold mb-4">Cooperative Savings Made Simple</h1>
                        <p class="lead">"When we save together, we grow together. Cooperative savings is the foundation of community wealth."</p>
                        <p class="opacity-75 mt-3">- Fasanya Oluwapelumi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .registration-form {
        max-width: 500px;
        margin: 0 auto;
    }

    .registration-steps .step {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .step-number {
        width: 32px;
        height: 32px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .step.active .step-number {
        background: #094168;
        color: white;
    }

    .step.done .step-number {
        background: #28a745;
        color: white;
    }

    .step-text {
        font-size: 14px;
        color: #6c757d;
        display: block;
    }

    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 6px;
        border: 1.5px solid #e5e9f2;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #094168;
        box-shadow: 0 0 0 0.2rem rgba(9, 65, 104, 0.15);
    }

    .btn-primary {
        background: #094168;
        border: none;
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #073251;
        transform: translateY(-1px);
    }
</style>
<script src="assets/js/investment/investment-auth.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#process-order-form').submit(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       
        // $('.preloader').show();
        e.preventDefault();
        // alert("ere")
        var form_details = $(this).serializeArray();

        finalizeRegistration(form_details);
    })

  
  

    function finalizeRegistration(form_details) {
        $.ajax({
            type: 'POST',
            url: "{{ route('signup_user') }}",
            data: form_details,
             
            success: function() {
                showCustomAlert("Success", "Your registration is complete!", "success").then(() => {
                    window.location.href = "/dashboard"; // Redirect on successful registration
                });
            },
            error: function() {
                showCustomAlert("Error", "Could not complete registration. Please contact support.", "error");
            }
        });
    }
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

        $(".planId").on("change", function(e) {
            var id = $(this).val();
            if (id == "") {
                $('.displayReg').hide();
                $('.feeInput').removeAttr('required');
                $('.feeInput').val("");
                $('#amountToBePaid').html('0');
                return;
            }
            
            // Fixed AJAX request
            $.get(`/get-plan-details/${id}`, function(response) {
                if (response.status && response.data) {
                    if (response.data.registration_fee > 0) {
                        const formattedFee = parseFloat(response.data.registration_fee).toLocaleString();
                        $('.fee-amount').text(formattedFee);
                        $('.feeInput').val(response.data.registration_fee);
                        $('#amountToBePaid').html(formattedFee);
                        $('.displayReg').fadeIn();
                        $('.feeInput').attr('required', true);
                    } else {
                        $('.displayReg').hide();
                        $('.feeInput').removeAttr('required').val("");
                        $('#amountToBePaid').html('0');
                    }
                }
            })
            .fail(function(error) {
                showCustomAlert({
                    title: 'Error',
                    text: 'Failed to fetch cooperative details',
                    icon: 'error'
                });
            });
        });
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
</script>
<script>
    $(document).ready(function() {
        let currentStep = 1;
        const totalSteps = 3;
        const formData = {};

        // Initialize form validation
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Update progress bar and step indicators
        function updateProgress() {
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            $('.progress-line-fill').css('width', `${progress}%`);

            $('.step').each(function(index) {
                const stepNum = index + 1;
                $(this).removeClass('active done');
                if (stepNum < currentStep) {
                    $(this).addClass('done');
                } else if (stepNum === currentStep) {
                    $(this).addClass('active');
                }
            });
        }

        // Show/hide steps with animation
        function showStep(step) {
            $('.tab-pane').fadeOut(200).promise().done(function() {
                $(`#step${step}`).fadeIn(200).addClass('show active');
                currentStep = step;
                updateProgress();
                if (step === 3) {
                    updateReviewInfo();
                }
            });
        }

        // Update review information in step 3
        function updateReviewInfo() {
            const reviewHtml = `
            <div class="text-start">
                <div class="review-item mb-3">
                    <h6 class="mb-2">Personal Information</h6>
                    <p class="mb-1"><strong>Name:</strong> ${$('#fullName').val()}</p>
                    <p class="mb-1"><strong>Email:</strong> ${$('#email').val()}</p>
                    <p class="mb-1"><strong>Phone:</strong> ${$('#phone').val()}</p>
                </div>
                <div class="review-item">
                    <h6 class="mb-2">Account Details</h6>
                    <p class="mb-1"><strong>Address:</strong> ${$('#address').val()}</p>
                </div>
            </div>
        `;
            $('.review-info').html(reviewHtml);
        }

        // Next button click handler
        $('.nexttab').click(function(e) {
            e.preventDefault();
            if (validateCurrentStep()) {
                const nextStep = currentStep + 1;
                if (nextStep <= totalSteps) {
                    showStep(nextStep);
                }
            }
        });

        // Previous button click handler
        $('.previestab').click(function(e) {
            e.preventDefault();
            const prevStep = currentStep - 1;
            if (prevStep >= 1) {
                showStep(prevStep);
            }
        });

        // Validate current step
        function validateCurrentStep() {
            const currentPane = $(`#step${currentStep}`);
            let isValid = true;

            // Reset previous validations
            currentPane.find('.is-invalid').removeClass('is-invalid');
            currentPane.find('.invalid-feedback').hide();

            // Validate required fields
            currentPane.find('input[required]').each(function() {
                if (!$(this).val().trim()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.invalid-feedback').show();
                }
            });

            if (currentStep === 1) {
                // if (!$('.planId').val()) {
                //     isValid = false;
                //     $('.planId').addClass('is-invalid');
                // }
            }
            // Special validation for step 2 (password)
            if (currentStep === 2) {
                const password = $('#password-fieldx').val();
                const confirmPassword = $('#password-fieldc').val();

                if (password.length < 8) {
                    isValid = false;
                    $('#password-fieldx').addClass('is-invalid');
                    $('#danger_password').html('<div class="alert alert-danger">Password must be at least 8 characters</div>');
                } else if (password !== confirmPassword) {
                    isValid = false;
                    $('#password-fieldc').addClass('is-invalid');
                    $('#danger_password').html('<div class="alert alert-danger">Passwords do not match</div>');
                } else {
                    $('#danger_password').html('');
                }
            }

            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required Fields',
                    text: 'Please fill in all required fields correctly',
                    confirmButtonColor: '#094168'
                });
            }

            return isValid;
        }

        // Password strength indicator
        $('#password-fieldx').on('input', function() {
            const password = $(this).val();
            const strength = checkPasswordStrength(password);
            updatePasswordStrengthIndicator(strength);
        });

        // Password toggle visibility
        $('.toggle-password').click(function() {
            const input = $(this).closest('.position-relative').find('input');
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        // Initialize form
        showStep(1);
    });
</script>