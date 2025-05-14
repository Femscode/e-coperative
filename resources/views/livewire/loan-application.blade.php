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
                                            <input id='phone' value='{{ auth()->user()->phone }}' type='hidden' />
                                            <input id='name' value='{{ auth()->user()->name }}' type='hidden' />
                                            <input id='email' value='{{ auth()->user()->email }}' type='hidden' />
                                            <input class='real_amount' value='' type='hidden' />
                                            <input id='redirect_url' value='https://vtubiz.com/payment/callback' type='hidden' />
                                            <input id='public_key' value='{{ env('FLW_PUBLIC_KEY') }}' type='hidden' />
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
<div class="loan-dashboard">
    <!-- Header Section -->
    <div class="page-header bg-light rounded-4 p-4 mb-4">
        <div class="row align-items-center">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="investment-cooperative.admin.html">
                                <i class="bi bi-house-door me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">My Loans</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                @if($company->month == NULL || $difference >= $company->month)
                <a data-bs-toggle="modal" data-bs-target="#addSeller"
                    class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>New Loan Request
                </a>
                @else
                <div class="alert alert-info d-flex align-items-center m-0 px-3 py-2">
                    <i class="bi bi-info-circle me-2"></i>
                    <small>You must have join for {{$company->month}} month(s) to apply for a loan</small>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Loan Cards Section -->
    <div class="row g-4">
        @foreach($loans as $transaction)
        <div class="col-md-6">
            <div data-id="{{ $transaction->id }}" data-type="application-fee" class="card loan-card processing h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="loan-status mb-4">
                        <span class="status-badge processing">
                            <i class="bi bi-arrow-clockwise me-2"></i>Processing
                        </span>
                    </div>

                    <div class="loan-details">
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="label">Loan Amount</span>
                                    <h3 class="amount">₦{{ number_format($transaction->total_applied, 2) }}</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item text-end">
                                    <span class="label">Interest Rate</span>
                                    <h3 class="rate">5%</h3>
                                </div>
                            </div>
                        </div>

                        <div class="loan-meta mt-4">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="meta-item">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>{{ $transaction->applied_date }}</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="meta-item">
                                        <i class="bi bi-clock-history"></i>
                                        <span>{{ $company->loan_month_repayment }} Months</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="repayment-info mt-4 text-center p-4 bg-light rounded-4">
                            @if($user->checkLoanApplicationStatus())
                            <button type="button" class="btn btn-success payApplicationFee"
                                data-bs-toggle="modal" data-bs-target="#paymentModal">
                                Pay Application Fee 
                            </button>
                           
                            @else 
                            

                            <div class="alert alert-success d-flex align-items-center m-0 px-3 py-2">
                                <i class="bi bi-check-circle me-2"></i>
                                <small>Application fee has been paid, awaiting admin approval</small>
                            </div>

                            @endif

                            <span class="label d-block mb-2">Monthly Repayment {{ $user->checkLoanApplicationStatus() }}</span>
                            <h2 class="mb-0">₦{{ number_format($transaction->monthly_return, 2) }}</h2>

                            @if($transaction->approval_status == 1 && $transaction->status == "Awaiting" && $transaction->payment_status == 0)
                            <button class="btn btn-primary mt-3" onclick="processPayment(this)"
                                data-amount="{{$transaction->monthly_return}}"
                                data-id="{{ $transaction->uuid }}">
                                <i class="bi bi-credit-card me-2"></i>Pay Now
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($ongoing_loans as $transaction)
        <div class="col-md-6">
            <div  data-id="{{ $transaction->id }}" data-type="repayment" class="card loan-card ongoing h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="loan-status mb-4">
                        <span class="status-badge ongoing">
                            <i class="bi bi-check-circle me-2"></i>Ongoing
                        </span>
                    </div>

                    <div class="loan-details">
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="detail-item">
                                    <span class="label">Loan Amount</span>
                                    <h3 class="amount">₦{{ number_format($transaction->total_applied, 2) }}</h3>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item text-end">
                                    <span class="label">Interest Rate</span>
                                    <h3 class="rate">5%</h3>
                                </div>
                            </div>
                        </div>

                        <div class="loan-meta mt-4">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="meta-item">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>{{ $transaction->applied_date }}</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="meta-item">
                                        <i class="bi bi-clock-history"></i>
                                        <span>{{ $company->loan_month_repayment }} Months</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="repayment-info mt-4 text-center p-4 bg-light rounded-4">
                            <span class="label d-block mb-2">Monthly Repayment</span>
                            <h2 class="mb-0">₦{{ number_format($transaction->monthly_return, 2) }}</h2>

                            @if($transaction->approval_status == 1 && $transaction->status == "Awaiting" && $transaction->payment_status == 0)
                            <button class="btn btn-primary mt-3" onclick="processPayment(this)"
                                data-amount="{{$transaction->monthly_return}}"
                                data-id="{{ $transaction->uuid }}">
                                <i class="bi bi-credit-card me-2"></i>Pay Now
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Loan Summary Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Loan Summary</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container mb-4">
                        <canvas id="areachartblue1" height="200"></canvas>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="summary-card bg-primary bg-opacity-10 p-4 rounded-4">
                                <h3 class="mb-2">₦{{ number_format($loans->sum('total_applied'), 2) }}</h3>
                                <p class="mb-0 text-muted">Total Borrowed</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="summary-card bg-success bg-opacity-10 p-4 rounded-4">
                                <h3 class="mb-2">₦{{ number_format($loans->sum('monthly_return'), 2) }}</h3>
                                <p class="mb-0 text-muted">Total Repaid</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .loan-dashboard {
        padding: 1.5rem 0;
    }

    .loan-card {
        transition: transform 0.2s ease;
    }

    .loan-card:hover {
        transform: translateY(-5px);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .status-badge.processing {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .status-badge.ongoing {
        background: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .loan-details .label {
        display: block;
        color: #6c757d;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .loan-details .amount,
    .loan-details .rate {
        margin: 0;
        font-weight: 600;
        color: #094168;
    }

    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.875rem;
    }

    .repayment-info {
        background: rgba(9, 65, 104, 0.05);
    }

    .repayment-info .label {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .repayment-info h2 {
        color: #094168;
        font-weight: 600;
    }

    .summary-card {
        height: 100%;
    }

    .summary-card h3 {
        color: #094168;
        font-weight: 600;
    }

    .btn-primary {
        background: #094168;
        border-color: #094168;
    }

    .btn-primary:hover {
        background: #073251;
        border-color: #073251;
    }
</style>

<script>
    function processPayment(button) {
        // Extract amount and transaction ID from button data attributes
        const amount = parseFloat(button.getAttribute('data-amount').replace(/,/g, ''));
        const transactionId = button.getAttribute('data-id');

        // Update the payment modal with the amount
        document.getElementById('amountToBePaid').innerHTML = amount.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.querySelector('.real_amount').value = amount;

        // Optionally store transaction ID in a hidden input for backend processing
        let orderIdInput = document.getElementById('order_id');
        if (!orderIdInput) {
            orderIdInput = document.createElement('input');
            orderIdInput.type = 'hidden';
            orderIdInput.id = 'order_id';
            document.getElementById('paymentForm').appendChild(orderIdInput);
        }
        orderIdInput.value = transactionId;

        // Show the payment modal
        $('#paymentModal').modal('show');
    }
</script>

<script>
    // Payment modal trigger
    $('.payApplicationFee').on('click', function() {
        const formFee = parseFloat($('#form_fee').val()) || 0;
        if (formFee > 0) {
            $('#amountToBePaid').html(formFee.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $('.real_amount').val(formFee);
            $('#paymentModal').modal('show');
        } else {
            Swal.fire({
                title: 'Error',
                text: 'No application fee specified.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    // Payment handling
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
            url: "{{ route('generateBankDetails') }}",
            type: "POST",
            data: {
                amount: amount,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
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

                $('.modal-body').html(modalContent);

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

                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-lock me-2"></i>Pay Now';
            },
            error: function(xhr) {
                console.error(xhr);
                Swal.fire({
                    title: 'Error',
                    text: 'Error generating bank details. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-lock me-2"></i>Pay Now';
            }
        });
    }

    function handlePaymentSubmit(event) {
        event.preventDefault();
        const paymentType = document.querySelector('input[name="type"]:checked').value;


        const loanCard = document.querySelector('.loan-card');
    const loanId = loanCard.getAttribute('data-id');
    const loanType = loanCard.getAttribute('data-type');
        const userId = '{{ auth()->user()->uuid }}';

        // Save payment tracking record
        $.ajax({
            url: '/member/loan/loan-payment/track',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                loan_id: loanId,
                type: loanType,
                status: 0 // Initial status
            },
            success: function(response) {
                if (response.success) {
                    // Continue with payment processing
                    if (paymentType === 'card') {
                        makePayment();
                    } else {
                        generateBankDetails();
                    }
                }
            },
            error: function(xhr) {
                console.error('Payment tracking failed:', xhr.responseText);
            }
        });
        return false;
    }
</script>