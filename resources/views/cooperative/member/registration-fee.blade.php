@extends('cooperative.member.master')

@section('header')
<script src="https://checkout.flutterwave.com/v3.js"></script>
@endsection

@section('main')
<main class="adminuiux-content has-sidebar">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="text-center mb-4">
                    <img src="{{url('admindashboard/images/logo/syncologo2.png')}}" alt="logo" class="mb-4" style="height: 60px;">
                    <h2 class="mb-2">Registration Fee Payment</h2>
                    <p class="text-muted">Complete your registration by paying the one-time registration fee.</p>
                </div>

                <div class="card adminuiux-card">
                    <div class="card-body p-4">
                        <div class="registration-details mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Registration Fee</span>
                                <h4 class="mb-0">₦{{ number_format($company->reg_fee) }}</h4>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Cooperative</span>
                                <h6 class="mb-0">{{ $company->name }}</h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Applicant</span>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                            </div>
                        </div>

                        <hr class="my-4">

                        <form id="paymentForm" onsubmit="return handlePaymentSubmit(event)">
                            <div class="mb-4">
                                <label class="form-label">Payment Method</label>
                                <div class="payment-methods">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="type" id="cardPayment" value="card" checked>
                                        <label class="form-check-label d-flex align-items-center" for="cardPayment">
                                            <i class="bi bi-credit-card me-2"></i>
                                            Pay with Card
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" id="bankTransfer" value="transfer">
                                        <label class="form-check-label d-flex align-items-center" for="bankTransfer">
                                            <i class="bi bi-bank me-2"></i>
                                            Bank Transfer
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden Fields -->
                            <input type="hidden" id="email" value="{{ $user->email }}">
                            <input type="hidden" id="name" value="{{ $user->name }}">
                            <input type="hidden" id="phone" value="{{ $user->phone }}">
                            <input type="hidden" class="real_amount" value="{{ $company->reg_fee }}">
                            <input id='public_key' value='{{  env('FLW_PUBLIC_KEY') }}' type='hidden' />
                             <input id='redirect_url' value='https://vtubiz.com/payment/callback' type='hidden' />
                                            
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-lock me-2"></i>Pay Now
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                Your payment is secured by Flutterwave
                            </small>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <p class="mb-0">
                        <small class="text-muted">
                            Need help? <a href="#" class="text-decoration-none">Contact Support</a>
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body p-4">
                <!-- Content will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
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

                // Update modal content and show modal
                $('.modal-body').html(modalContent);
                $('#paymentModal').modal('show');

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