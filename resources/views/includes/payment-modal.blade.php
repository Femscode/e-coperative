<style>
    .payment-logo {
        height: 40px;
        width: auto;
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

    .payment-option-card {
        padding: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .payment-option-card:hover {
        border-color: #6c757d;
        background-color: #f8f9fa;
    }

    .payment-option-card .form-check-input:checked~.form-check-label {
        color: var(--bs-primary);
    }

    .payment-option-card .form-check-input:checked~.form-check-label .payment-icon {
        background-color: var(--bs-primary) !important;
        color: white !important;
    }

    .payment-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .bg-soft-primary {
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        color: var(--bs-primary);
    }

    .bg-soft-success {
        background-color: rgba(var(--bs-success-rgb), 0.1);
        color: var(--bs-success);
    }
</style>
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
                    <h2 class="amount-text mb-0">₦<span id="amountToBePaid">{{ number_format($amount ?? 0, 2) }}</span></h2>
                </div>

                <div class="card-details">
                    <form id="paymentForm" method="POST" accept-charset="UTF-8" onsubmit="return handlePaymentSubmit(event)">
                        @csrf
                        <input required name="amount" type="hidden" min="100" class="form-control real_amount" value="{{ $amount ?? 0 }}" placeholder="Enter Amount">
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
                                            <input id='phone' value='{{ auth()->user()->phone }}' type='hidden' />
                                            <input id='name' value='{{ auth()->user()->name }}' type='hidden' />
                                            <input id='email' value='{{ auth()->user()->email }}' type='hidden' />
                                            <input class='real_amount' value='{{ $amount ?? 0 }}' type='hidden' />
                                            <input id='redirect_url' value='{{ $redirect_url ?? "https://vtubiz.com/payment/callback" }}' type='hidden' />
                                            <input id='public_key' value='{{ env("FLW_PUBLIC_KEY") }}' type='hidden' />
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

<script src="https://checkout.flutterwave.com/v3.js"></script>
<script>
    // Payment handling functions
    function handlePaymentSubmit(event) {
        event.preventDefault();
        const paymentType = document.querySelector('input[name="type"]:checked').value;

        if (paymentType === 'card') {
            makePayment();
        } else if (paymentType === 'transfer') {
            generateBankDetails();
        }
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
        const submitBtn = document.querySelector('#paymentForm button[type="submit"]');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating Account...';

        $.ajax({
            url: "/generateBankDetails",
            type: "POST",
            data: {
                amount: amount,
                _token: document.querySelector('meta[name="csrf-token"]').content
            },
            success: function(response) {
                // Handle the bank details response
                console.log(response);
                const formattedAmount = new Intl.NumberFormat('en-NG', {
                    style: 'currency',
                    currency: 'NGN'
                }).format(amount);

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
                                <label class="text-muted small mb-1">Account Name</label>
                                <div class="fw-medium">SYNCOSAVE</div>
                            </div>
                            <div class="detail-item mb-3">
                                <label class="text-muted small mb-1">Amount to Transfer</label>
                                <div class="fw-medium fs-5">${formattedAmount}</div>
                            </div>
                            <div class="detail-item">
                                <label class="text-muted small mb-1">Account Expires In</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="text-danger fw-medium" id="countdown"></div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info d-flex gap-2" role="alert">
                            <i class="bi bi-info-circle flex-shrink-0"></i>
                            <div>
                                <p class="mb-1 fw-medium">Important Instructions:</p>
                                <ol class="mb-0 ps-3">
                                    <li>Transfer the exact amount shown above</li>
                                    <li>Use the account number provided</li>
                                    <li>Complete transfer before expiry time</li>
                                </ol>
                            </div>
                        </div>
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <small>This account number will be deactivated after the expiry time. Please ensure you complete your transfer before then.</small>
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

                    const countdownElement = document.getElementById("countdown");
                    if (countdownElement) {
                        countdownElement.innerHTML = `${hours}h ${minutes}m ${seconds}s`;

                        // Add warning color when less than 5 minutes
                        if (distance < 300000) { // 5 minutes in milliseconds
                            countdownElement.classList.add('text-warning');
                        }

                        if (distance < 0) {
                            clearInterval(countdownTimer);
                            countdownElement.innerHTML = "EXPIRED";
                            countdownElement.classList.remove('text-warning');
                            countdownElement.classList.add('text-danger');

                            // Show expiry message
                            $('.bank-details').after(`
                                    <div class="alert alert-danger mt-3">
                                        <i class="bi bi-exclamation-circle me-2"></i>
                                        This account has expired. Please generate a new one.
                                    </div>
                                `);
                        }
                    } else {
                        clearInterval(countdownTimer);
                    }
                }, 1000);

                // Update button state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Account Details Generated';

            },
            error: function(error) {
                console.error(error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-lock me-2"></i>Pay Now';
            }
        });
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show a brief success message or tooltip
            alert('Account number copied!');
        });
    }

    function processPayment(button) {
        const amount = parseFloat(button.getAttribute('data-amount').replace(/,/g, ''));
        const transactionId = button.getAttribute('data-id');

        document.getElementById('amountToBePaid').innerHTML = amount.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.querySelector('.real_amount').value = amount;

        let orderIdInput = document.getElementById('order_id');
        if (!orderIdInput) {
            orderIdInput = document.createElement('input');
            orderIdInput.type = 'hidden';
            orderIdInput.id = 'order_id';
            document.getElementById('paymentForm').appendChild(orderIdInput);
        }
        orderIdInput.value = transactionId;

        $('#paymentModal').modal('show');
    }
</script>