@extends('cooperative.member.master')

@section('main')
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <img src='{{url("assets/images/payaza1.gif")}}' alt='payaza' height="40" />
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="payaza-form">
                    <div class="alert alert-warning border-0 rounded-3">
                        <i class="bi bi-info-circle me-2"></i>
                        For testing purpose, kindly use the default prefilled card details
                    </div>
                    
                    <div class="amount-display text-center mb-4">
                        <span class="text-muted">Amount To Be Paid</span>
                        <h2 class="amount-text mb-0">₦<span id="amountToBePaid">0</span></h2>
                    </div>

                    <div class="mb-3">
                        <label for="card-number" class="form-label">Card Number</label>
                        <input type="hidden" id="order_id" />
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                            <input type="text" value="4012000033330026" id="card-number" 
                                class="form-control" required placeholder="Enter Card Number">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col">
                            <label for="expiry-date" class="form-label">Expiry Date</label>
                            <input value="01/39" type="text" id="expiry-date" 
                                class="form-control" required placeholder="MM/YY">
                        </div>
                        <div class="col">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" value="100" id="cvv" 
                                class="form-control" required placeholder="Enter CVV">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-lock me-2"></i>Pay Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="page-header d-flex align-items-center justify-content-between bg-light rounded-4 p-4">
                    <div>
                        <h4 class="mb-1">Manual Payment</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Manual</a></li>
                                <li class="breadcrumb-item active">Payment</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="payment-icon mb-3">
                                <i class="bi bi-wallet2 fs-1 text-primary"></i>
                            </div>
                            <h4 class="card-title mb-2">Fund Your Savings</h4>
                            <p class="text-muted">Enter any amount you'd like to save</p>
                        </div>

                        <form method="POST" id="monthly-dues" class="payment-form">
                            @csrf
                            <div class="mb-4">
                                <label for="total" class="form-label">Amount to Pay</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">₦</span>
                                    <input type="number" name="amount" class="form-control form-control-lg" 
                                        id="total" placeholder="Enter amount" required>
                                </div>
                            </div>

                            <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                            <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">

                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                <i class="bi bi-credit-card me-2"></i>
                                {{ __('Proceed to Payment') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.payment-icon {
    width: 80px;
    height: 80px;
    background: rgba(9, 65, 104, 0.1);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.amount-display {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 1rem;
}

.amount-text {
    color: #094168;
    font-size: 2rem;
}

.payment-form .form-control:focus {
    border-color: #094168;
    box-shadow: 0 0 0 0.25rem rgba(9, 65, 104, 0.1);
}

.btn-primary {
    background-color: #094168;
    border-color: #094168;
}

.btn-primary:hover {
    background-color: #073251;
    border-color: #073251;
}
</style>
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
                new showCustomAlert("Opss", e.responseJSON.message, "error");
            }
        })

    }


    $('#payaza-form').submit(function(e) {
        e.preventDefault();
        showCustomAlert({
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
                            showCustomAlert({
                                title: '3DS Authentication data missing. Please try again.',
                                icon: 'error'
                            })

                        }
                    } else {
                        console.log("Payment Process Journey Completed");
                        $('#process-order-form').submit();
                        showCustomAlert('Payment Completed', 'Payment completed successfully!', 'success')

                        location.href = "/payaza/transaction-successful?order_id=" + $("#order_id").val() +
                            '&reference=' + response.transactionReference;

                        // Optionally submit your order form here if payment is successful

                    }
                } else {
                    console.log("Error found:", response.debugMessage);
                    showCustomAlert({
                        title: "Payment Failed: " + response.debugMessage,
                        icon: 'error'
                    })
                }
            },
            error: function(xhr, status, error) {
                console.log("Error:", error);
                showCustomAlert({
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