@extends('cooperative.member.master')
@section('header')
<script src="https://checkout.flutterwave.com/v3.js"></script>
@endsection

@section('main')
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <img src='{{url("admindashboard/images/logo/syncologo2.png")}}' alt='payaza' class="payment-logo" />
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">



                <div class="amount-display text-center mb-4">
                    <span class="text-muted">Amount To Be Paid</span>
                    <h2 class="amount-text mb-0">₦<span id="amountToBePaid">0</span></h2>
                </div>

                <div class="card-details">
                    <form id="paymentForm" method="POST" accept-charset="UTF-8" onsubmit="return handlePaymentSubmit(event)">
                        @csrf
                        <input required name="amount" type="hidden" min="100" class="form-control real_amount" placeholder="Enter Amount">
                        <span class="text-danger" id="show_charge"></span>

                        <div class="mt-4">
                            <label class="form-label fw-medium mb-3">Select Payment Method</label>
                            <div class="payment-options">
                                <div class="form-check payment-option-card mb-3">
                                    <input required type="radio" name="type" value="transfer" class="form-check-input" id="transferOption">
                                    <label class="form-check-label d-flex align-items-center gap-3" for="transferOption">
                                        <span class="payment-icon bg-soft-primary">
                                            <i class="bi bi-bank fs-4"></i>
                                        </span>
                                        <div>
                                            <span class="d-block fw-medium">Automatic Bank Transfer</span>
                                            <small class="text-muted">Pay directly from your bank account</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check payment-option-card">
                                    <input required type="radio" name="type" value="card" class="form-check-input" id="cardOption">
                                    <label class="form-check-label d-flex align-items-center gap-3" for="cardOption">
                                        <span class="payment-icon bg-soft-success">
                                            <i class="bi bi-credit-card fs-4"></i>
                                        </span>
                                        <div>
                                            <input id='phone' value='{{ $user->phone }}' type='hidden' />
                                            <input id='name' value='{{ $user->name }}' type='hidden' />
                                            <input id='email' value='{{ $user->email }}' type='hidden' />
                                            <input class='real_amount' value='' type='hidden' />
                                            <input id='redirect_url' value='https://vtubiz.com/payment/callback' type='hidden' />
                                            <input id='public_key' value='{{  env('FLW_PUBLIC_KEY') }}' type='hidden' />
                                            <span class="d-block fw-medium">Credit Card</span>
                                            <small class="text-muted">Pay with your credit or debit card</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
                            <i class="bi bi-lock me-2"></i>Pay Now
                        </button>
                    </form>
                </div>

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
                $(".real_amount").val(totalAmount)
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


    function makePayment() {
        const phone = document.getElementById('phone').value;
        const email = document.getElementById('email').value;
        const name = document.getElementById('name').value;
        const amount = parseFloat(document.querySelector('.real_amount').value.replace(/,/g, ''));
        const public_key = document.getElementById('public_key').value;
        const redirect_url = document.getElementById('redirect_url').value;

        FlutterwaveCheckout({
            public_key: public_key,
            tx_ref: "titanic-48981487343MDI0NzJD",
            amount: amount,
            currency: "NGN",
            payment_options: "card, mobilemoneyghana, ussd",
            redirect_url: redirect_url,
            meta: {
                consumer_id: 13,
                consumer_mac: "92a3-983jd-1192a",
            },
            customer: {
                email: email,
                phone_number: phone,
                name: name,
            },
            customizations: {
                title: "Syncosave Checkout",
                description: "Fast and Easy Payment",
                logo: "https://syncosave.com/admindashboard/images/logo/syncologo2.png",
            },
        });
    }

    function generateBankDetails() {
        const amount = parseFloat(document.querySelector('.real_amount').value.replace(/,/g, ''));
        const submitBtn = document.querySelector('button[type="submit"]');
        
        // Disable button and show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating Account...';

        $.ajax({
            url: "{{ route('generateBankDetails') }}",
            type: "POST",
            data: {
                amount: amount,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // Create modal content
                const modalContent = `
                    <div class="text-center mb-4">
                        <div class="payment-icon bg-soft-primary rounded-circle mx-auto mb-3" style="width: 64px; height: 64px;">
                            <i class="bi bi-bank fs-2 text-primary d-flex align-items-center justify-content-center h-100"></i>
                        </div>
                        <h4 class="mb-1">Bank Transfer Details</h4>
                        <p class="text-muted">Complete your payment using the details below</p>
                    </div>
                    <div class="bank-details bg-light rounded-4 p-4 mb-4">
                        <div class="detail-item mb-3">
                            <label class="text-muted small mb-1">Bank Name</label>
                            <div class="fw-medium">${response.bank_name}</div>
                        </div>
                        <div class="detail-item mb-3">
                            <label class="text-muted small mb-1">Account Number</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-medium fs-5">${response.account_no}</span>
                                <button class="btn btn-sm btn-light" onclick="copyToClipboard('${response.account_no}')" title="Copy">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </div>
                        <div class="detail-item mb-3">
                            <label class="text-muted small mb-1">Amount</label>
                            <div class="fw-medium fs-5">₦${response.amount}</div>
                        </div>
                        <div class="detail-item">
                            <label class="text-muted small mb-1">Expires In</label>
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-danger fw-medium" id="countdown"></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <small>Please complete your transfer before the expiry time. The account will be automatically deactivated after expiry.</small>
                    </div>`;

                // Update modal content
                $('.modal-body').html(modalContent);

                // Start countdown timer
                const expiryDate = new Date(response.expiry_date).getTime();
                const countdownTimer = setInterval(() => {
                    const now = new Date().getTime();
                    const distance = expiryDate - now;
                    
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    document.getElementById("countdown").innerHTML = `${hours}h ${minutes}m ${seconds}s`;
                    
                    if (distance < 0) {
                        clearInterval(countdownTimer);
                        document.getElementById("countdown").innerHTML = "EXPIRED";
                    }
                }, 1000);

                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-lock me-2"></i>Pay Now';
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Error generating bank details. Please try again.');
                
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-lock me-2"></i>Pay Now';
            }
        });
    }
    function handlePaymentSubmit(event) {
        event.preventDefault();

        const paymentType = document.querySelector('input[name="type"]:checked').value;

        if (paymentType === 'card') {
            makePayment();
        } else {
            generateBankDetails();
        }

        return false;
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show a brief success message or tooltip
            alert('Account number copied!');
        });
    }

</script>
@endsection