@extends('member_dashboard.master')

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
       


        <div class="container mt-4" id="main-content">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Loan</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Application</a></li>
                                <li class="breadcrumb-item active">Loan</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            @livewire('loan-application')


            <!-- Modal -->
            <div class="modal fade zoomIn" id="addSeller" tabindex="-1" aria-labelledby="addSellerLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form id="loanApplication" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Amount</label>
                                                    <input type="text" name="total_applied" required
                                                        data-min="{{ auth()->user()->plan()->min_loan_range ?? ""}}"
                                                        data-max="{{ auth()->user()->plan()->max_loan_range ?? "" }}"
                                                        data-refund="{{ auth()->user()->plan()->month ?? ""}}"
                                                        min="{{ auth()->user()->plan()->min_loan_range ?? "" }}"
                                                        max="{{ auth()->user()->plan()->max_loan_range ?? "" }}"
                                                        class="form-control loanAmount amount" id=""
                                                        placeholder="Enter amount">
                                                    <div id="passwordHelpBlock" class="form-text">
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="lastnameInput" class="form-label">Monthly Refund</label>
                                                    <input type="text" required readonly name="monthly_return"
                                                        class="form-control refund" id="" placeholder="monthly refund">
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-end">
                                                    {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                                                    <button type="button"
                                                        class="btn btn-link link-success text-decoration-none fw-medium"
                                                        data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                        Close</button>
                                                    <button type="submit" class="btn btn-primary submitBtn"><i
                                                            class="ri-save-3-line align-bottom me-1"></i> Save</button>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end modal-->

        </div>
</main>
<!-- container-fluid -->
@endsection

@section('script')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    // function myFunction(event) {
    //  console.log("here")
    $(".loanAmount").keypress(function(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        $(".loanAmount").on('keyup', function() {
            // event.preventDefault();
            var n = parseInt($(this).val().replace(/\D/g, ''), 10);
            $(this).val(n.toLocaleString());
            if (isNaN(n)) {
                $(".loanAmount").val("");
                // $(this).val();
            }

        });
    });
    // }
</script>
<script>
    function processPayment(element) {
        var uuid = $(element).data('id');
        // alert(uuid)
        var totalAmount = $(element).data('amount');
        $('.preloader').show();
        var ajaxUrl = "{{ route('pay-form') }}";
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            dataType: 'json',
            data: {
                uuid: uuid,
                total_amount: totalAmount,
            },
            success: function(e) {
                $('.preloader').hide();
                $("#amountToBePaid").html(totalAmount.toLocaleString())
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
                new swal("Opss", e.responseJSON.message, "error");
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
            email: data.email,
            amount: data.amount_paid * 100,
            order_id: data.order_id,
            phone: data.phone,
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

                location.href = "/paystack/transaction-successful?order_id=" + orderObj
                    .order_id +
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
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $("#loanApplication").on('submit', async function(e) {
            e.preventDefault();
            const serializedData = $("#loanApplication").serializeArray();
            $('.preloader').show();
            try {
                const postRequest = await request("/member/loan/apply",
                    processFormInputs(
                        serializedData), 'post');
                console.log('postRequest.message', postRequest.message);
                new swal("Good Job", postRequest.message, "success");
                $('#loanApplication').trigger("reset");
                $("#loanApplication .close").click();
                window.location.reload();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    // console.log('e.message', e.message);
                    new swal("Opss", e.message, "error");

                }
            }
        })

        $('.amount').on('keyup', function() {
            var min = $(this).data('min');
            var max = $(this).data('max');
            var refund = $(this).data('refund');
            var value = $(this).val().replace(/\D/g, '');
            var newValue = parseFloat(value);
            var newMax = parseFloat(max);
            if (value == "") {
                $('.refund').val('');
            } else {
                if (newValue > max) {
                    $('#passwordHelpBlock').html('Maximum amount to apply for is ' + newMax
                        .toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }))
                    $("#passwordHelpBlock").css("color", "red");
                    $('.submitBtn').hide()
                    // new swal("Opss", 'Maximum amount to apply for is ' + max, "error");
                } else {
                    var refund = newValue / refund;
                    if (Number.isInteger(refund)) {
                        $('.refund').val(refund.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }))
                    } else {
                        var roundedValue = Math.round(refund / 100) * 100 + 100;
                        $('.refund').val(roundedValue.toLocaleString(undefined, {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }))
                    }
                    $('.submitBtn').show()
                    // var refundRound = Math.round(refund/100) * 100 + 100;
                    $('#passwordHelpBlock').html('')

                }
            }


        });

    })
</script>
@endsection