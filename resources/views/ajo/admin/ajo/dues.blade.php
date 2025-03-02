@extends('cooperative.admin.master')
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
<style>
    .due-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 1.5rem;
        position: relative;
        transition: all 0.3s ease;
        border: 1px solid rgba(9, 65, 104, 0.1);
        overflow: hidden;
    }

    .due-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #094168, #FF821A);
    }

    .due-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(9, 65, 104, 0.1);
    }

    .due-card .form-check {
        top: 1rem;
        right: 1rem;
        z-index: 1;
    }

    .due-card-body {
        text-align: center;
    }

    .due-month {
        font-size: 1.25rem;
        font-weight: 600;
        color: #094168;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .due-type {
        margin-bottom: 1.5rem;
    }

    .due-amount {
        padding-top: 1rem;
        border-top: 1px dashed rgba(9, 65, 104, 0.1);
    }

    .amount-label {
        display: block;
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .due-amount h3 {
        color: #FF821A;
        font-weight: 700;
    }

    .form-check-input:checked~.due-card-body {
        opacity: 0.8;
    }

    .form-check-input:checked+.due-card {
        border-color: #094168;
    }
</style>

<style>
    .page-title-box {
        background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
        border-left: 4px solid #094168;
    }

    .search-box .form-control {
        padding-left: 2.8rem;
        padding-right: 1.2rem;
        height: 48px;
        background: #ffffff;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    .search-box .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #094168;
        font-size: 1.2rem;
    }

    .table> :not(caption)>*>* {
        padding: 1rem;
    }

    .fs-12 {
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .bg-soft-primary {
        background-color: rgba(9, 65, 104, 0.1) !important;
    }

    .text-primary {
        color: #094168 !important;
    }

    .form-check-input:checked {
        background-color: #094168;
        border-color: #094168;
    }

    .card {
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(9, 65, 104, 0.02);
    }

    .avatar-lg {
        height: 80px;
        width: 80px;
    }

    .avatar-title {
        align-items: center;
        display: flex;
        font-weight: 500;
        height: 100%;
        justify-content: center;
        width: 100%;
    }

    .bg-soft-primary {
        background-color: rgba(9, 65, 104, 0.1) !important;
    }
</style>

@endsection

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="page-title-box bg-light rounded-3 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1">My Dues</h4>
                        
                    </div>
                    <div class="search-box">
                        <div class="position-relative">
                            <input type="text" class="form-control form-control-lg rounded-pill" wire:model="search"
                                placeholder="Search dues...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    @if(count($months) > 0)
                    <div class="row g-4">
                        @foreach ($months as $month)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="due-card">
                                <div class="form-check position-absolute">
                                    <input class="form-check-input controlledCheckbox"
                                        @isset($month['amount']) data-id="{{ $month['amount'] }}"
                                        @else data-id="{{ $plan->dues }}" @endisset
                                        name="check[]" type="checkbox">
                                </div>

                                <input type="hidden" @isset($month['amount']) value="Contribution" @else value="Contribution" @endisset name="payment_type[]">
                                <input type="hidden" @isset($month['amount']) value="{{ $month['uuid'] }}" @else value="" @endisset name="uuid[]">
                                <input type="hidden" @isset($month['amount']) value="{{ $month['amount'] }}" @else value="{{ $plan->dues }}" @endisset name="fee[]">

                                <div class="due-card-body">
                                    <div class="due-month">{{ $month['month'] ?? 0 }}</div>
                                    <div class="due-type">
                                        <span class="badge bg-soft-primary text-primary rounded-pill px-3">
                                            Contribution
                                        </span>
                                    </div>
                                    <div class="due-amount">
                                        <span class="amount-label">Amount Due</span>
                                        <h3 class="mb-0">₦{{ number_format($month['amount'] ?? $plan->dues, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="avatar-lg mx-auto mb-4">
                            <div class="avatar-title bg-soft-primary text-primary fs-1 rounded-circle">
                                <i class="ri-calendar-todo-line"></i>
                            </div>
                        </div>
                        <h5>No Dues Found</h5>
                        <p class="text-muted">There are no dues to display at the moment.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


</div>

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

        return checkedData;
    }

    function processPayment(data) {
        data = data;
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