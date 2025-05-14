@extends('cooperative.member.master')

@section('header')
<style>
    .sticky-footer {
        position: sticky;
        bottom: 0;
        background: #fff;
        z-index: 1000;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        padding: 1rem 0;
        margin-top: 1rem;
        display: none;
    }

    .sticky-footer.show {
        display: block;
    }

    .payment-summary {
        transition: all 0.3s ease;
    }

    .grand-total-container {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }

    .payment-actions {
        margin-top: 0 !important;
    }

    .submit-btn {
        padding: 0.75rem 2rem !important;
    }
</style>
@endsection

@section('main')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <div class="loan-nav-wrapper mb-4">
            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active2" href="/member/loan">
                        <i class="bi bi-plus-circle me-1"></i>
                        <span>Request For Loan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/member/loan-repayment">
                        <i class="bi bi-hourglass-split me-1"></i>
                        <span>Pending Repayments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/member/loan/ongoing">
                        <i class="bi bi-arrow-repeat me-1"></i>
                        <span>Ongoing Loans</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/member/loan/completed">
                        <i class="bi bi-check-circle me-1"></i>
                        <span>Completed Loans</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Page title -->
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

        <!-- Loan Application Modal -->
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
                                                <label for="loanAmount" class="form-label">Loan Amount</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">₦</span>
                                                    <input type="text" name="total_applied" required
                                                        data-min="{{ auth()->user()->plan()->min_loan_range ?? '' }}"
                                                        data-max="{{ auth()->user()->plan()->max_loan_range ?? '' }}"
                                                        data-refund="{{ auth()->user()->plan()->loan_month_repayment ?? '' }}"
                                                        data-total="{{ auth()->user()->totalSavings() ?? '' }}"
                                                        data-interest="{{ auth()->user()->plan()->interest ?? 0 }}"
                                                        class="form-control loanAmount amount" id="loanAmount"
                                                        placeholder="Enter loan amount">
                                                    <input id="form_fee" value="{{ auth()->user()->plan()->loan_form_amount ?? 0 }}" type="hidden" />
                                                </div>
                                                <div id="passwordHelpBlock" class="form-text text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label">Repayment Duration</label>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ auth()->user()->plan()->loan_month_repayment ?? '' }} Months">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card bg-light border-0 mb-3">
                                                <div class="card-body">
                                                    <h6 class="card-title mb-3">Loan Summary</h6>
                                                    <div class="row g-3">
                                                        <div class="col-sm-6">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted">Interest Rate:</span>
                                                                <span class="fw-medium interest-rate">{{ auth()->user()->plan()->interest ?? 0 }}%</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted">Total Interest:</span>
                                                                <span class="fw-medium interest-amount">₦0.00</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted">Monthly Payment:</span>
                                                                <span class="fw-medium">₦<span class="refund">0.00</span></span>
                                                                <input type="hidden" class="refund_input" name="monthly_return">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="d-flex justify-content-between">
                                                                <span class="text-muted">Total Repayment:</span>
                                                                <span class="fw-medium total-repayment">₦0.00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button"
                                                    class="btn btn-link link-success text-decoration-none fw-medium"
                                                    data-bs-dismiss="modal">
                                                    <i class="ri-close-line me-1 align-middle"></i> Close
                                                </button>
                                                <button type="submit" class="btn btn-primary submitBtn">
                                                    Apply for Loan →
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
$(document).ready(function() {
    // CSRF Token Setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Input formatting for loan amount
    $('.loanAmount').on('keypress', function(e) {
        const charCode = e.which || e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    }).on('keyup', function() {
        const value = $(this).val().replace(/\D/g, '');
        const num = parseInt(value, 10);
        $(this).val(isNaN(num) ? '' : num.toLocaleString());
    });

    // Loan amount validation and calculations
    $('.amount').on('keyup', function() {
        const $this = $(this);
        const min = parseFloat($this.data('min')) || 0;
        const max = parseFloat($this.data('max')) || Infinity;
        const refund = parseInt($this.data('refund')) || 1;
        const totalsaved = parseFloat($this.data('total')) || 0;
        const interestRate = parseFloat($this.data('interest')) || 0; // Interest rate as percentage (e.g., 5 for 5%)

        const minApplication = totalsaved * min;
        const maxApplication = totalsaved * max;
        const value = $this.val().replace(/\D/g, '');
        const loanAmount = parseFloat(value) || 0;

        // Cache selectors
        const $passwordHelpBlock = $('#passwordHelpBlock');
        const $submitBtn = $('.submitBtn');

        // Validation checks
        if (totalsaved < 1) {
            $passwordHelpBlock.html('You have no savings yet!');
            $submitBtn.hide();
            resetCalculations();
            return;
        }

        if (!value) {
            $passwordHelpBlock.html('');
            $submitBtn.hide();
            resetCalculations();
            return;
        }

        if (loanAmount < minApplication) {
            $passwordHelpBlock.html(`Minimum amount to apply for is ₦${minApplication.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`);
            $submitBtn.hide();
            resetCalculations();
            return;
        }

        if (loanAmount > maxApplication) {
            $passwordHelpBlock.html(`Maximum amount to apply for is ₦${maxApplication.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`);
            $submitBtn.hide();
            resetCalculations();
            return;
        }

        // Valid input, perform calculations
        $passwordHelpBlock.html('');
        $submitBtn.show();

        // Calculate simple interest: principal * rate * time / 100
        const totalInterest = (loanAmount * interestRate * refund) / 100; // Adjusted for repayment duration
        const totalRepayment = loanAmount + totalInterest;
        const monthlyPayment = totalRepayment / refund;

        // Update display
        $('.interest-amount').text(`₦${totalInterest.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`);
        $('.interest-rate').text(`${interestRate.toFixed(2)}%`);
        $('.refund').text(monthlyPayment.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        $('.refund_input').val(monthlyPayment.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        $('.total-repayment').text(`₦${totalRepayment.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        })}`);
    });

    // Reset calculations
    function resetCalculations() {
        $('.interest-amount').text('₦0.00');
        $('.interest-rate').text('0.00%');
        $('.refund').text('0.00');
        $('.total-repayment').text('₦0.00');
        $('.refund_input').val('');
    }

    // Form submission
    $('#loanApplication').on('submit', async function(e) {
        e.preventDefault();
        const formFee = parseFloat($('#form_fee').val()) || 0;

        if (formFee > 0) {
            const result = await Swal.fire({
                title: 'Confirm Application',
                text: `You will be charged ₦${formFee.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })} for this loan application.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'No, cancel'
            });

            if (result.isConfirmed) {
                $('#addSeller').modal('hide');
                const serializedData = $(this).serializeArray();
                window.loanFormData = serializedData;
                $('.preloader').show();

                try {
                    const response = await $.ajax({
                        url: '/member/loan/apply',
                        type: 'POST',
                        data: processFormInputs(serializedData),
                        dataType: 'json'
                    });

                    $('.preloader').hide();
                    await Swal.fire({
                        title: 'Success',
                        text: 'Loan application submitted successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    resetCalculations();
                    $('#loanApplication')[0].reset();
                } catch (error) {
                    $('.preloader').hide();
                    const errorMessage = error.responseJSON?.message || 'An error occurred. Please try again.';
                    await Swal.fire('Error', errorMessage, 'error');
                }
            }
        }
    });

    // Process form inputs
    function processFormInputs(formInputs) {
        const data = {};
        formInputs.forEach(input => {
            data[input.name] = input.value;
        });
        return data;
    }
});
</script>
@endsection