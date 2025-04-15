@extends('ajo.member.master')


@section('header')
<style>
    .grand-total-container {
        max-width: 300px;
        margin: auto;
    }

    .grand-total-input {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        background-color: #f8f9fa;
        border: 2px solid #28a745;
        color: #28a745;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    .grand-total-input:focus {
        box-shadow: 0 6px 15px rgba(0, 128, 0, 0.3);
        transform: scale(1.02);
        outline: none;
    }
</style>

@endsection 
@section('main')
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <img src='{{url("assets/images/payaza1.gif")}}' alt='payaza' class="img-fluid" style="max-width: 140px" />
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="payaza-form">
                    <div class='alert alert-danger bg-danger-subtle border-0'>
                        <i class="bi bi-info-circle me-2"></i>
                        For testing purpose, kindly use the default prefilled card details
                    </div>
                    <div class='text-center mb-2'>Amount To Be Paid</div>
                    <h2 class='text-center fw-bold mb-4'>₦<span id='amountToBePaid'>0</span></h2>
                    <div class="mb-3">
                        <label for="card-number" class="form-label small text-muted">Card Number</label>
                        <input type='hidden' id='order_id' />
                        <div class="input-group">
                            <input type="text" value='4012000033330026' id="card-number" 
                                class="form-control" required placeholder="Enter Card Number">
                            <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                        </div>
                    </div>
                    <div class='form-group row g-3'>
                        <div class="col-6">
                            <label for="expiry-date" class="form-label small text-muted">Expiry Date</label>
                            <input value='01/39' type="text" id="expiry-date" 
                                class="form-control" required placeholder="MM/YY">
                        </div>
                        <div class="col-6">
                            <label for="cvv" class="form-label small text-muted">CVV</label>
                            <input type="text" value='100' id="cvv" 
                                class="form-control" required placeholder="Enter CVV">
                        </div>
                    </div>
                    <div class='mt-4'>
                        <button type="submit" class="btn btn-primary w-100 py-2">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <!-- Header -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-sm-0 fw-bold">Pending Contribution Dues</h4>
                        <p class="text-muted mb-0">Select the contributions you want to pay</p>
                    </div>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);" class="text-decoration-none">
                                    <i class="bi bi-wallet me-1"></i>
                                    Contribution Dues
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Pending</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form id="monthly-dues" method="post">
                            @csrf
                            <div class="live-preview">
                                <div class="contribution-list">
                                    @if(count($months) > 0)
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                id="masterCheckbox" onchange="toggleAllCheckboxes()" value="option1">
                                            <label class="form-check-label" for="masterCheckbox">
                                                Select All Contributions
                                            </label>
                                        </div>
                                        <div class="contribution-count">
                                            <span class="badge bg-primary">{{ count($months) }} Pending</span>
                                        </div>
                                    </div>

                                    <div class="contribution-items">
                                        @foreach ($months as $month)
                                        <div class="contribution-item">
                                            <input type="hidden" @isset($month['amount']) value="Contribution" 
                                                @else value="Contribution" @endisset name="payment_type[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['uuid'] }}" 
                                                @else value="" @endisset name="uuid[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['amount'] }}" 
                                                @else value="{{ $plan->dues }}" @endisset name="fee[]">
                                            
                                            <div class="form-check">
                                                <input class="form-check-input controlledCheckbox" 
                                                    @isset($month['amount']) data-id="{{ $month['amount'] }}" 
                                                    @else data-id="{{ $plan->dues }}" @endisset 
                                                    name="check[]" type="checkbox" id="check_{{ $loop->index }}">
                                                <label class="form-check-label" for="check_{{ $loop->index }}">
                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                        <div>
                                                            <input type="hidden" name="month[]" value="{{ $month['month'] }}">
                                                            <h6 class="mb-1">{{ $month['month'] }}</h6>
                                                            <span class="badge bg-light text-dark">
                                                                @isset($month['amount']) Contribution @else Contribution @endisset
                                                            </span>
                                                        </div>
                                                        <div class="contribution-amount">
                                                            <input type="hidden" name="original[]" 
                                                                @isset($month['amount']) value="{{ $month['amount'] }}" 
                                                                @else value="{{ $plan->getMondays($month['month']) * $plan->monthly_dues }}" @endisset>
                                                            <span class="amount">
                                                                ₦@isset($month['amount']) 
                                                                    {{ number_format($month['amount'], 2) }}
                                                                @else 
                                                                    {{ number_format($plan->dues, 2) }}
                                                                @endisset
                                                            </span>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="text-center py-5">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" 
                                            trigger="loop" colors="primary:#094168,secondary:#22c55e" 
                                            style="width:80px;height:80px">
                                        </lord-icon>
                                        <h5 class="mt-3">No Pending Dues!</h5>
                                        <p class="text-muted">You're all caught up with your contributions.</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if(count($months) > 0)
                            <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                            <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">
                            
                            <div class="payment-summary mt-4">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="grand-total-container">
                                            <label for="total" class="form-label text-uppercase fw-bold mb-2">
                                                Grand Total
                                            </label>
                                            <input type="text" class="form-control grand-total-input"
                                                name="total_amount" value="0" readonly id="total">
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <button type="submit" id="submit-btn" 
                                            class="btn btn-primary submit-btn px-4 py-2">
                                            <i class="bi bi-credit-card me-2"></i>
                                            Make Payment
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.modal-content {
    border-radius: 1rem;
    overflow: hidden;
}

.form-control {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    border: 1px solid #e0e0e0;
}

.form-control:focus {
    border-color: #094168;
    box-shadow: 0 0 0 0.2rem rgba(9, 65, 104, 0.1);
}

.contribution-list {
    background: #fff;
    border-radius: 0.5rem;
}

.contribution-items {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.contribution-item {
    padding: 1rem;
    border: 1px solid #e0e0e0;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.contribution-item:hover {
    background: #f8f9fa;
}

.contribution-item .form-check {
    margin: 0;
    padding: 0;
}

.contribution-item .form-check-input {
    float: none;
    margin: 0;
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
}

.contribution-item .form-check-label {
    padding-left: 2rem;
    width: 100%;
    cursor: pointer;
}

.contribution-amount {
    font-weight: 600;
    color: #094168;
}

.btn-primary {
    background: #094168;
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #073251;
    transform: translateY(-1px);
}

.payment-summary {
    border-top: 1px solid #e0e0e0;
    padding-top: 1.5rem;
}

.grand-total-input {
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
    color: #094168;
    background: #f8f9fa;
    border: 2px solid #094168;
}

@media (max-width: 768px) {
    .page-title-box {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .page-title-right {
        margin-top: 1rem;
    }
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
        var checkedData = filterCheckedData();
        processPayment(checkedData);
    })

    function filterCheckedData() {
        var checkedData = [];

        // Iterate through the checked checkboxes and collect data from the same row
        $('.controlledCheckbox:checked').each(function() {
            var $row = $(this).closest('tr'); // Find the closest row
            var paymentType = $row.find('[name="payment_type[]"]').val();
            var fee = $row.find('[name="fee[]"]').val();
            var month = $row.find('[name="month[]"]').val();
            var original = $row.find('[name="original[]"]').val();
            var uuid = $row.find('[name="uuid[]"]').val();

            checkedData.push({
                payment_type: paymentType,
                fee: fee,
                month: month,
                original: original,
                uuid: uuid
            });
        });
        console.log(checkedData)
        return checkedData;
    }

    function processPayment(data) {
        data = data;
        // console.log(data)
        var email = $('#userEmail').val();
        var phone = $('#userPhone').val();
        var totalAmount = $('#total').val();
        $('.preloader').show();
        var ajaxUrl = "{{ route('pay-dues') }}";
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