@extends('cooperative.member.master')

@section('main')
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
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
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <!-- start page title -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manual Payment</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manual</a></li>
                            <li class="breadcrumb-item active">Payment</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-md-4 mb-4">


                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h5 class="text-primary">Fund Savings</h5>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <form method="POST" id="monthly-dues">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="email" class="form-label">{{ __('Amount To Pay ') }} <span class="text-danger">*</span></label>
                                                <input type="number" name="amount" class="form-control " id="total" placeholder="Enter amount to pay " required>
                                            </div>
                                            <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                                            <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">
                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">
                                                    {{ __('Pay Now') }}
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                                <!-- end card body -->
                            </div>

                        </div>
                    </div>
                </div><!-- end card-body -->

            </div>

            <div class="col-md-8">
            <div class="card-body px-1">
                                <div class="card adminuiux-card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6>Recent Transaction</h6>
                                            </div>
                                            <div class="col-auto px-0"><a class="btn btn-sm btn btn-link">See All</a></div>
                                            <div class="col-auto"><button class="btn btn-sm btn-outline-theme"><i class="bi bi-arrow-up-right me-1"></i> Export </button></div>
                                        </div>
                                    </div>

                                    <ul class="list-group list-group-flush border-top bg-none">
                                        @foreach($transactions as $tranx)
                                        @if($tranx->type !== 'funded')
                                        <li class="list-group-item">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-40 rounded-circle border"><i class="bi bi-arrow-up-right h5"></i></div>
                                                </div>
                                                <div class="col">
                                                    <p class="mb-1 fw-medium">{{$tranx->payment_type}}</p>
                                                    <p class="text-secondary small">{{Date('d-m-y', strtotime($tranx->created_at))}}</p>
                                                </div>
                                                <div class="col-auto">
                                                    <h6>- N{{number_format($tranx->amount)}}</h6>
                                                </div>
                                            </div>
                                        </li>
                                        @else
                                        <li class="list-group-item theme-green">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-40 rounded-circle border border-theme-1 bg-theme-1-subtle text-theme-1"><i class="bi bi-arrow-down-left h5"></i></div>
                                                </div>
                                                <div class="col">
                                                    <p class="mb-1 fw-medium">{{$tranx->payment_type}}</p>
                                                    <p class="text-secondary small">{{Date('d-m-y', strtotime($tranx->created_at))}}</p>
                                                </div>
                                                <div class="col-auto">
                                                    <h6 class="text-theme-1">+ N{{number_format($tranx->amount)}}</h6>
                                                </div>
                                            </div>
                                        </li>
                                        @endif

                                        @endforeach

                                    </ul>
                                </div>
                            </div>
            </div>
            <!-- end col -->
        </div><!--end row-->
    </div>
</main>
@endsection

@section('script')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    $('#monthly-dues').submit(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // $('.preloader').show();
        e.preventDefault();
        // alert("ere")
        var checkedData = $(this).serializeArray(); //filterCheckedData();
        processPayment(checkedData);
    })


    function processPayment(data) {
        data = data;
        var email = $('#userEmail').val();
        var phone = $('#userPhone').val();
        var totalAmount = $('#total').val();
        $('.preloader').show();
        var ajaxUrl = "{{ route('pay-anytime') }}";
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            dataType: 'json',
            data: {
                checkedData: data,
                email: email,
                phone: phone,
                total_amount: totalAmount,
            },
            success: function(e) {

                $('.preloader').hide();
                $('.preloader').hide();
                $("#amountToBePaid").html(totalAmount)
                $("#order_id").val(e.order_id.transaction_id)
                $('#paymentModal').modal('show');
                // payWithPaystack(e);
            },
            error: function(e) {
                $('.preloader').hide();
                // var errorList = '';
                // Object.keys(e.responseJSON.message).forEach(function(key) {
                // errorList += '<li>' + e.responseJSON.message[key][0] + '</li>';
                // });
                new Swal.fire("Opss", e.responseJSON.message, "error");
            }
        })

    }


    $('#payaza-form').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Processing payment, please wait...',
            icon: 'info',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading()
            }
        })

        // Collect card details
        var cardDetails = {
            number: $('#card-number').val(),
            expiryMonth: $('#expiry-date').val().split('/')[0], // Extract month from MM/YY
            expiryYear: $('#expiry-date').val().split('/')[1], // Extract year from MM/YY
            cvv: $('#cvv').val()
        };


        // Prepare the data for the Payaza API request
        var payload = {
            "service_payload": {
                "first_name": "{{$user->name}}",
                "last_name": "{{$user->name}}",
                "email_address": "{{$user->email}}",
                "phone_number": "{{$user->phone}}",
                "amount": 100, // The amount to charge (adjust as needed)
                "transaction_reference": "PL-1KBPSCJCRD" + Math.floor((Math.random() * 10000000) + 1), // Unique transaction reference
                "currency": "NGN", // Currency code (adjust as needed)
                "description": "E-cooperative payment testing.", // Payment description
                "card": {
                    "expiryMonth": cardDetails.expiryMonth,
                    "expiryYear": cardDetails.expiryYear,
                    "securityCode": cardDetails.cvv,
                    "cardNumber": cardDetails.number
                },
                "callback_url": "https://e-coop.cthostel.com/api/payment/webhook" // Your callback URL for payment updates
            }
        };

        // Set up headers for the request
        var headers = {
            "Authorization": "Payaza " + "{{env('PAYAZA_API')}}", // Authorization token from Payaza
            "Content-Type": "application/json"
        };

        // Send the AJAX request to Payaza API
        $.ajax({
            url: "https://cards-live.78financials.com/card_charge/", // Payaza endpoint
            method: "POST",
            headers: headers,
            data: JSON.stringify(payload),
            contentType: "application/json",
            success: function(response) {
                console.log("RAW RESULT: ", response);
                if (response.statusOk) {
                    if (response.do3dsAuth) {
                        if (response.formData && response.threeDsUrl) {
                            const creq = document.getElementById("creq");
                            creq.value = response.formData;
                            const form = document.getElementById("threedsChallengeRedirectForm");
                            form.setAttribute("action", response.threeDsUrl);
                            form.submit();
                        } else {
                            console.log("Missing 3DS data:", response);
                            Swal.fire({
                                title: '3DS Authentication data missing. Please try again.',
                                icon: 'error'
                            })

                        }
                    } else {
                        console.log("Payment Process Journey Completed");
                        $('#process-order-form').submit();
                        Swal.fire('Payment Completed', 'Payment completed successfully!', 'success')

                        location.href = "/payaza/transaction-successful?order_id=" + $("#order_id").val() +
                            '&reference=' + response.transactionReference;

                        // Optionally submit your order form here if payment is successful

                    }
                } else {
                    console.log("Error found:", response.debugMessage);
                    Swal.fire({
                        title: "Payment Failed: " + response.debugMessage,
                        icon: 'error'
                    })
                }
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
                Swal.fire({
                    title: "Exception Error: " + (error.debugMessage || error.message || "Unknown error"),
                    icon: 'error'
                })
            }
        });
    });

    function handlePaystackPopup(event) {
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
            key: paystackSecretKey, //'pk_test_031c3ba6cf25565da961c7bceea2f75887d08e22',
            // key: 'pk_test_a36f058d84321e7d8f7f2d27655ddddd6a700b3f',
            // key: 'pk_live_e139b3ad8d001c8219ed6ea7fb1cb756d2ce66f1',
            email: orderObj.email,
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
<script>
    // toggle all
    function toggleAllCheckboxes() {
        const masterCheckbox = document.getElementById('masterCheckbox');
        const controlledCheckboxes = document.getElementsByClassName('controlledCheckbox');
        const isChecked = masterCheckbox.checked;
        let totalAmount = 0; // Initialize the total amount variable

        for (let i = 0; i < controlledCheckboxes.length; i++) {
            controlledCheckboxes[i].checked = isChecked;
            if (isChecked) {
                // If the master checkbox is checked, add the data('id') to the totalAmount
                const amount = parseFloat(controlledCheckboxes[i].getAttribute('data-id'));
                totalAmount += amount;
            }
        }
        $("#total").val(totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        if (totalAmount == 0) {
            $(".submit-btn").hide();
            $(".submit-btn").hide();
        } else {
            $(".submit-btn").show();
            $(".submit-btn").show();
        }
    }
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".submit-btn").hide();
        $(".submit-btn").hide();
        // check or uncheck any data
        $(".controlledCheckbox").on("change", function(e) {
            // console.log("is_checked", $(this).is(":checked"));
            // $(this).data('id');
            const total = $("#total").val().replace(/,/g, '');
            var sign = Number.parseFloat(total);
            // const service = $(this).attr('value');
            const amount = $(this).data('id');
            var signet = Number.parseFloat(amount);
            if ($(this).is(":checked") == true)
                var addSum = sign + signet; //.toFixed(2);
            $("#total").val(addSum);
            // alert("heree")
            if ($(this).is(":checked") == false)
                var addSum = sign - signet; //.toFixed(2);

            $("#total").val(addSum.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

            if (addSum == 0) {
                $(".submit-btn").hide();
                $(".submit-btn").hide();
            } else {
                $(".submit-btn").show();
                $(".submit-btn").show();
            }

        })

    })
</script>
@endsection