<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    
<!-- Mirrored from themesbrand.com/velzon/html/default/auth-signup-basic.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 05 Mar 2022 15:10:53 GMT -->
<head>
        
        <meta charset="utf-8" />
        <title>Sign Up | Velzon - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Layout config Js -->
        <script src="assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />


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
                                    <a href="index.html" class="d-inline-block auth-logo">
                                        <img src="assets/images/logo-light.png" alt="" height="20">
                                    </a>
                                </div>
                                <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row justify-content-center">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Progress Nav Steps</h4>
                                </div>
                                <!-- end card header -->
                                <div class="card-body form-steps">
                                    <form id="process-order-form" method="post" >
                                        @csrf
                                        <div class="text-center pt-3 pb-4 mb-1">
                                            <h5>Signup Your Account</h5>
                                        </div>
                                        <div id="custom-progress-bar" class="progress-nav mb-4">
                                            <div class="progress" style="height: 1px">
                                                <div class="progress-bar" role="progressbar" style="width: 0%"
                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill active"
                                                        data-progressbar="custom-progress-bar" id="pills-gen-info-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-gen-info"
                                                        type="button" role="tab" aria-controls="pills-gen-info"
                                                        aria-selected="true">
                                                        1
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill"
                                                        data-progressbar="custom-progress-bar" id="pills-info-desc-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-info-desc"
                                                        type="button" role="tab" aria-controls="pills-info-desc"
                                                        aria-selected="false">
                                                        2
                                                    </button>
                                                </li>
                                                {{-- <li class="nav-item" role="presentation">
                                                    <button class="nav-link rounded-pill"
                                                        data-progressbar="custom-progress-bar" id="pills-success-tab"
                                                        data-bs-toggle="pill" data-bs-target="#pills-success"
                                                        type="button" role="tab" aria-controls="pills-success"
                                                        aria-selected="false">
                                                        3
                                                    </button>
                                                </li> --}}
                                            </ul>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="pills-gen-info" role="tabpanel"
                                                aria-labelledby="pills-gen-info-tab">
                                                <div>
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="gen-info-password-input">Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="gen-info-password-input" placeholder="Enter full name" />
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="gen-info-email-input">Email</label>
                                                                <input type="email" class="form-control" name="email"
                                                                    id="gen-info-email-input email"
                                                                    placeholder="Enter Email" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="gen-info-username-input">Phone Number</label>
                                                                <input type="number" class="form-control" name="phone"
                                                                    id="gen-info-username-input"
                                                                    placeholder="Enter User Name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="pills-info-desc-tab">
                                                        <i
                                                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go
                                                        to payment info
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            <div class="tab-pane fade" id="pills-info-desc" role="tabpanel"
                                                aria-labelledby="pills-info-desc-tab">
                                                <div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="gen-info-email-input">Referred By</label>
                                                                <input type="text" class="form-control" name="referred_by"
                                                                    id="gen-info-email-input"
                                                                    placeholder="Enter cooperative member number " />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="gen-info-username-input">User Name</label>
                                                                <input type="text" class="form-control" name="username"
                                                                    id="gen-info-username-input"
                                                                    placeholder="Enter User Name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="gen-info-email-input">Password</label>
                                                                <input type="password" class="form-control" name="password"
                                                                    id="gen-info-email-input"
                                                                    placeholder="Enter cooperative member number " />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="gen-info-username-input">Confirm Password</label>
                                                                <input type="password" class="form-control" name="password_confirmation"
                                                                    id="gen-info-username-input"
                                                                    placeholder="Enter User Name" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button"
                                                        class="btn btn-link text-decoration-none btn-label previestab"
                                                        data-previous="pills-gen-info-tab">
                                                        <i
                                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                        Back to General
                                                    </button>
                                                    <button type="submit"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="pills-success-tab">
                                                        <i
                                                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end tab pane -->

                                            {{-- <div class="tab-pane fade" id="pills-success" role="tabpanel"
                                                aria-labelledby="pills-success-tab">
                                                <div>

                                                    <div class="row gy-3">
                                                        <div class="col-md-12">
                                                            <label for="cc-name" class="form-label">Name on
                                                                card</label>
                                                            <input type="text" class="form-control"
                                                                id="cc-name" placeholder="" name="cardholder_name" required />
                                                            <small class="text-muted">Full name as displayed
                                                                on card</small>
                                                            <div class="invalid-feedback">
                                                                Name on card is required
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="cc-number" class="form-label">Credit
                                                                card number</label>
                                                            <input type="text" class="form-control"
                                                                id="cc-number" name="number" placeholder="" required />
                                                            <div class="invalid-feedback">
                                                                Credit card number is required
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="cc-expiration"
                                                                class="form-label">Expiration</label>
                                                            <input type="text" class="form-control"
                                                                id="cc-expiration" name="expiry_date" placeholder=""
                                                                required />
                                                            <div class="invalid-feedback">
                                                                Expiration date required
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label for="cc-cvv"
                                                                class="form-label">CVV</label>
                                                            <input type="text" class="form-control"
                                                                id="cc-cvv" placeholder="" name="cvv" required />
                                                            <div class="invalid-feedback">
                                                                Security code required
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button"
                                                        class="btn btn-link text-decoration-none btn-label previestab"
                                                        data-previous="pills-gen-info-tab">
                                                        <i
                                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                                        Back to General
                                                    </button>
                                                    <button type="submit"
                                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                                        data-nexttab="pills-success-tab">
                                                        <i
                                                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Submit
                                                    </button>
                                                </div>
                                            </div> --}}
                                            <!-- end tab pane -->
                                        </div>
                                        <!-- end tab content -->
                                    </form>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
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
                                <p class="mb-0 text-muted">&copy; <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
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
                        payWithPaystack(e);
                    },
                    error: function(e) {
                        $('.preloader').hide();
                        var errorList = '';
                        Object.keys(e.responseJSON.message).forEach(function(key) {
                        errorList += '<li>' + e.responseJSON.message[key][0] + '</li>';
                        });
                        new swal("Opss",errorList,"error");
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
                        number: 6039,//cardNumber,
                        cvv: 240,//cvv,
                        expiry_month: 03,//expiryMonth,
                        expiry_year: 25,//expiryYear,
                        name: "Amos Oluwasegun Ezekiel",//cardholderName
                    },
                    amount: 1000 * 100 // Paystack API expects the amount in kobo (i.e. multiply by 100)
                    }, function(result) {
                    if (result.status === 'success') {
                        // Display a success message to the user
                        alert('Your payment was successful!');
                    } else {
                        // Handle errors
                        console.log(result.message);
                        alert('There was an error processing your payment. Please try again.');
                    }
                    });
                } else {
                    // Handle errors
                    console.log(response.message);
                    alert('There was an error processing your payment. Please try again.');
                }
                }
            };
            
            // Open the Paystack pop-up
            const paystackPopup = PaystackPop.setup(config);
            paystackPopup.openIframe();
            }
    
            function payWithPaystack(data) {
                console.log(data)
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
                    key: 'pk_test_031c3ba6cf25565da961c7bceea2f75887d08e22',
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
    
                        location.href = "/paystack/transaction-successful?order_id=" + orderObj.order_id +
                            '&reference=' + response.reference;
    
                    },
                    onClose: function() {
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
    </body>


</html>