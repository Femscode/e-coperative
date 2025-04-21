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
            <div class="card loan-card processing h-100 border-0 shadow-sm">
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

        @foreach($ongoing_loans as $transaction)
        <div class="col-md-6">
            <div class="card loan-card ongoing h-100 border-0 shadow-sm">
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
