<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">


<head>

    <meta charset="utf-8" />
    <title>Sign Up | 1 Million Hands COOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="1 Million Hands" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="{{url('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{url('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{url('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{url('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{url('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        .field-icon {
            float: right;
            left: -10px;
            margin-top: -23px;
            position: relative;
            z-index: 2;
        }

        .preloader {
            align-items: center;
            background: gray;
            display: flex;
            height: 100vh;
            justify-content: center;
            left: 0;
            position: fixed;
            top: 0;
            transition: opacity 0.3s linear;
            width: 100%;
            z-index: 9999;
            opacity: 0.4;
        }

    </style>
</head>

<body>
    <div class="preloader" style="display:none">
        <div class="spinner-grow text-info m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        {{-- <img src="spinner.svg" alt="spinner"> --}}
    </div>
    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
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
                    <div class="col-xl-6" style="display: none">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Progress Nav Steps</h4>
                            </div>
                            <!-- end card header -->
                            <div class="card-body form-steps">
                                <form action="#">
                                    <div class="text-center pt-3 pb-4 mb-1">
                                        <h5>Signup Your Account</h5>
                                    </div>
                                    <div id="custom-progress-bar" class="progress-nav mb-4">
                                        <div class="progress" style="height: 1px">
                                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                        <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link rounded-pill active" data-progressbar="custom-progress-bar" id="pills-gen-info-tab" data-bs-toggle="pill" data-bs-target="#pills-gen-info" type="button" role="tab" aria-controls="pills-gen-info" aria-selected="true">
                                                    1
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-info-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-info-desc" type="button" role="tab" aria-controls="pills-info-desc" aria-selected="false">
                                                    2
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar" id="pills-success-tab" data-bs-toggle="pill" data-bs-target="#pills-success" type="button" role="tab" aria-controls="pills-success" aria-selected="false">
                                                    3
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="pills-gen-info" role="tabpanel" aria-labelledby="pills-gen-info-tab">
                                            <div>
                                                <div class="mb-4">
                                                    <div>
                                                        <h5 class="mb-1">General Information</h5>
                                                        <p class="text-muted">
                                                            Fill all Information as below
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-email-input">Email</label>
                                                            <input type="text" class="form-control" id="gen-info-email-input" placeholder="Enter Email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-username-input">User Name</label>
                                                            <input type="text" class="form-control" id="gen-info-username-input" placeholder="Enter User Name" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="gen-info-password-input">Password</label>
                                                    <input type="password" class="form-control" id="gen-info-password-input" placeholder="Enter Password" />
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-info-desc-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                                    to more info
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->

                                        <div class="tab-pane fade" id="pills-info-desc" role="tabpanel" aria-labelledby="pills-info-desc-tab">
                                            <div>
                                                <div class="text-center">
                                                    <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                                        <img src="assets/images/users/user-dummy-img.jpg" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image" />
                                                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                            <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/png, image/jpeg" />
                                                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                                <span class="avatar-title rounded-circle bg-light text-body">
                                                                    <i class="ri-camera-fill"></i>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <h5 class="fs-14">Add Image</h5>
                                                </div>
                                                <div>
                                                    <label class="form-label" for="gen-info-description-input">Description</label>
                                                    <textarea class="form-control" placeholder="Enter Description" id="gen-info-description-input" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-link text-decoration-none btn-label previestab" data-previous="pills-gen-info-tab">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to General
                                                </button>
                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-success-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->

                                        <div class="tab-pane fade" id="pills-success" role="tabpanel" aria-labelledby="pills-success-tab">
                                            <div>
                                                <div class="text-center">
                                                    <div class="mb-4">
                                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width: 120px; height: 120px"></lord-icon>
                                                    </div>
                                                    <h5>Well Done !</h5>
                                                    <p class="text-muted">
                                                        You have Successfully Signed Up
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                    </div>
                                    <!-- end tab content -->
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <div class="col-xl-6">
                        <div class="card">
                            <!-- end card header -->
                            <div class="card-body form-steps">
                                <form id="process-order-form" method="post">
                                    @csrf
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Go Digital, Go Far!</h5>
                                        <h6> Bring Your Cooperative into the Digital Age!</h6>

                                    </div>
                                    <div class="step-arrow-nav mb-4">
                                        <ul class="nav nav-pills custom-nav nav-justified" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link done active" id="steparrow-gen-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-gen-info" type="button" role="tab" aria-controls="steparrow-gen-info" aria-selected="true">
                                                    General
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link " id="steparrow-description-info-tab" data-bs-toggle="pill" data-bs-target="#steparrow-description-info" type="button" role="tab" aria-controls="steparrow-description-info" aria-selected="false">
                                                    Description
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-experience-tab" data-bs-toggle="pill" data-bs-target="#pills-experience" type="button" role="tab" aria-controls="pills-experience" aria-selected="false">
                                                    Finish
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="steparrow-gen-info" role="tabpanel" aria-labelledby="steparrow-gen-info-tab">
                                            <div>
                                                <div class="row">                                             
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-password-input">Full Name</label>
                                                            <input type="text" class="form-control" required name="name" id="gen-info-password-input" placeholder="Enter Full Name Of Your Co-operative" />
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-email-input">Email</label>
                                                            <input type="email" class="form-control" required name="email" id="gen-info-email-input email" placeholder="Enter email" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-username-input">Phone Number</label>
                                                            <input type="number" class="form-control" required name="phone" id="gen-info-username-input" placeholder="Enter phone number" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="steparrow-description-info-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                                    to description
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->

                                        <div class="tab-pane fade " id="steparrow-description-info" role="tabpanel" aria-labelledby="steparrow-description-info-tab">
                                            <div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-email-input">Address</label>
                                                            <input type="text" class="form-control" name="address" placeholder="House Address" />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-email-input">Referred By</label>
                                                            <input type="text" class="form-control" name="referred_by" placeholder=" " />
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-email-input">Password</label>
                                                            <input type="password" class="form-control" required name="password" id="password-fieldx" placeholder="enter password " />
                                                            <span toggle="#password-fieldx" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-username-input">Confirm Password</label>
                                                            <input type="password" class="form-control" required name="password_confirmation" id="password-fieldc" placeholder="confirm password" />
                                                            <span toggle="#password-fieldc" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-gen-info-tab">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to General
                                                </button>
                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-experience-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Finish
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
                                                            @if(isset($slug))
                                                            <label class="form-label" for="gen-info-password-input">Coperative Name</label>
                                                            <h4>{{$company->name}}</h4>
                                                            <input class='form-control' value="{{$company->uuid}}" name='company' type='hidden' />

                                                            @else
                                                            <label class="form-label" for="gen-info-password-input">Select Coperative</label>
                                                            <select class='form-control planId' required name='company'>
                                                                <option value="">--Select Cooperative--</option>
                                                                @foreach($coperative ?? App\Models\Company::all() as $coop)
                                                                <option value='{{$coop->uuid}}'>{{ $coop->name }}</option>
                                                                @endforeach

                                                            </select>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 displayReg" style="display:none">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="gen-info-email-input">Registration Fee</label>
                                                            <input type="text" class="form-control feeInput" readonly name="reg_fee" placeholder=" " />
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <input type="radio" /> I Agree to the <a href='#'>terms & conditions.</a>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab" data-previous="steparrow-description-info-tab">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                    Back to Description
                                                </button>
                                                <button type="submit" class="btn btn-success btn-label right ms-auto nexttab nexttab" data-nexttab="pills-experience-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit
                                                </button>
                                            </div>
                                        </div>
                                        <!-- end tab pane -->
                                    </div>
                                    <!-- end tab content -->
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="{{route('login')}}" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
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
                                </script> , 1 Million Hands Global Initiative! Crafted with <i class="mdi mdi-heart text-danger"></i> by HBH Software!</p>
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
    <script src="{{url('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{url('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{url('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{url('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{url('assets/js/plugins.js')}}"></script>

    <!-- particles js -->
    <script src="{{url('assets/libs/particles.js/particles.js')}}"></script>
    <!-- particles app js -->
    <script src="{{url('assets/js/pages/particles.app.js')}}"></script>
    <!-- validation init -->
    <script src="{{url('assets/js/pages/form-validation.init.js')}}"></script>
    <!-- form wizard init -->
    <script src="{{url('assets/js/pages/form-wizard.init.js')}}"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
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
                processPayment(form_details);
            })

        

            function processPayment(data) {
                data = data;
                $('.preloader').show();
                $.ajax({
                    type: 'POST',
                    url: 'pay-for-plan',
                    dataType: 'json',
                    data: data,
                    success: function(e) {
                        $('.preloader').hide();
                        $('.preloader').hide();
                        if(e.status == 0){
                            new swal("Congratulations!","Registration Succesful","success");
                        }else{
                            payWithPaystack(e);
                        }
                    },
                    error: function(e) {
                        $('.preloader').hide();
                        // var errorList = '';
                        // Object.keys(e.responseJSON.message).forEach(function(key) {
                        // errorList += '<li>' + e.responseJSON.message[key][0] + '</li>';
                        // });
                        new swal("Opss",e.responseJSON.message,"error");
                    }
                })

            }

            function handlePaystackPopup(event) {
            // event.preventDefault();

            // Get the amount to be charged from the form
            // const amount = document.getElementById('amount').value;

            // Configure the Paystack pop-up
            const config = {
                key: 'pk_live_af922c7f707c7ad3dc1a03433a3768007f6a0401', // Replace with your Paystack public key
                email: 'amospersie@gmail.com', // Replace with the user's email address
                amount: 1000 * 100, // Paystack API expects the amount in kobo (i.e. multiply by 100)
                currency: 'NGN', // Replace with your preferred currency
                callback: function(response) {
                    if (response.status === 'success') {
                        // Get the card details that the user entered in the pop-up
                        // const cardNumber = response.card.last4;
                        // const expiryMonth = response.card.exp_month;
                        // const expiryYear = response.card.exp_year;
                        // const cvv = response.card.cvv;
                        // const cardholderName = response.card.name;

                        // Use the card details and the amount to charge the user's card
                        Paystack.chargeCard({
                            card: {
                                number: 6039, //cardNumber,
                                cvv: 240, //cvv,
                                expiry_month: 03, //expiryMonth,
                                expiry_year: 25, //expiryYear,
                                name: "Amos Oluwasegun Ezekiel", //cardholderName
                            },
                            amount: 1000 * 100 // Paystack API expects the amount in kobo (i.e. multiply by 100)
                        }, function(result) {
                            if (result.status === 'success') {
                                // Display a success message to the user
                                alert('Your payment was successful!');
                            } else {
                                // Handle errors
                                // console.log(result.message);
                                alert('There was an error processing your payment. Please try again.');
                            }
                        });
                    } else {
                        // Handle errors
                        // console.log(response.message);
                        alert('There was an error processing your payment. Please try again.');
                    }
                }
            };

            // Open the Paystack pop-up
            const paystackPopup = PaystackPop.setup(config);
            paystackPopup.openIframe();
        }
        const paystackSecretKey = @json(env('PAYSTACK_PUBLIC_KEY'));

        function payWithPaystack(data) {
            // console.log(data)
            var orderObj = {
                email: $('[name=email]').val(),
                amount: data.amount_paid * 100,
                order_id: data.order_id,
                phone: $('[name=phone]').val(),
                process_transaction: "1",
                card: data.card,
            };

            var data = data;
            var handler = PaystackPop.setup({
                // key: 'pk_live_af922c7f707c7ad3dc1a03433a3768007f6a0401',
                key: paystackSecretKey,
                // key: 'pk_test_a36f058d84321e7d8f7f2d27655ddddd6a700b3f',
                // key: 'pk_live_e139b3ad8d001c8219ed6ea7fb1cb756d2ce66f1',
                email: orderObj.email,
                // card: {
                //     number: 4105400018676039,//cardNumber,
                //     cvv: 240,//cvv,
                //     expiry_month: 03,//expiryMonth,
                //     expiry_year: 25,//expiryYear,
                //     name: "Amos Oluwasegun Ezekiel",//cardholderName
                // },
                // card: orderObj.card,
                amount: orderObj.amount,
                ref: data.transaction_id,
                metadata: {
                    custom_fields: [{
                        display_name: "Order ID",
                        variable_name: "order_id",
                        value: orderObj.order_id
                    }]
                },
                callback: function(response) {
                    $('.preloader').show();
                    location.href = "/paystack/transaction-successful?order_id=" + orderObj.order_id +
                        '&reference=' + response.reference;

                },
                onClose: function() {
                    $('.preloader').hide();
                    alert('Click "Pay online now" to retry payment.');
                }
            });
            handler.openIframe();
        }
    </script>
    <!--SWEET ALERT JS -->
    <script src="{{asset('swal.js')}}"></script>

    <script>
        @if ($errors->any())
            Swal.fire('Oops...', `{!! implode('', $errors->all('<p>:message</p>')) !!}`, 'error')
        @endif

        @if (session()->has('message'))
            Swal.fire(
                'Success!',
                `{{ session()->get('message') }}`,
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

            $(".planId").on("change", function(e) {
                var id  = $(this).val();//$(this).data('id');
                if(id == ""){
                    $('.displayReg').hide();
                    $('.feeInput').removeAttr('required');
                    $('.feeInput').val("");
                    return;
                }
                $.get('{{ route('get_plan_details_by_id') }}?id=' + id, function (data) {
                    if(data['plan'].reg_fee > 0){
                        $('.displayReg').show();
                        $('.feeInput').attr('required', true);
                        $('.feeInput').val(data['plan'].reg_fee);
                    }else{
                         $('.displayReg').hide();
                        $('.feeInput').removeAttr('required');
                        $('.feeInput').val("");
                    }
                })

            });
        });

    </script>
</body>