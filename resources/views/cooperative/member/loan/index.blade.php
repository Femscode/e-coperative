@extends('cooperative.member.master')

@section('header')
<script src="https://checkout.flutterwave.com/v3.js"></script>
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

<main class="adminuiux-content has-sidebar" onclick="contentClick()">
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
                                                    data-min="{{ auth()->user()->plan()->min_loan_range ?? '' }}"
                                                    data-max="{{ auth()->user()->plan()->max_loan_range ?? '' }}"
                                                    data-refund="{{ auth()->user()->plan()->loan_month_repayment ?? '' }}"
                                                    min="{{ auth()->user()->plan()->min_loan_range ?? '' }}"
                                                    max="{{ auth()->user()->plan()->max_loan_range ?? '' }}"
                                                    data-total="{{ auth()->user()->totalSavings() ?? '' }}"
                                                    class="form-control loanAmount amount" id=""
                                                    placeholder="Enter amount">
                                                <div id="passwordHelpBlock" class="form-text"></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="lastnameInput" class="form-label">Monthly Refund</label>
                                                <input type="text" required readonly name="monthly_return"
                                                    class="form-control refund" id="" placeholder="monthly refund">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button"
                                                    class="btn btn-link link-success text-decoration-none fw-medium"
                                                    data-bs-dismiss="modal">
                                                    <i class="ri-close-line me-1 align-middle"></i> Close
                                                </button>
                                                <button type="submit" class="btn btn-primary submitBtn">
                                                    <i class="ri-save-3-line align-bottom me-1"></i> Save
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
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".loanAmount").keypress(function(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            $(".loanAmount").on('keyup', function() {
                var n = parseInt($(this).val().replace(/\D/g, ''), 10);
                $(this).val(n.toLocaleString());
                if (isNaN(n)) {
                    $(".loanAmount").val("");
                }
            });
        });

        $('.amount').on('keyup', function() {
            var min = $(this).data('min');
            var max = $(this).data('max');
            var refund = $(this).data('refund');
            var totalsaved = $(this).data('total');
            var minApplication = totalsaved * min;
            var maxApplication = totalsaved * max;
            var value = $(this).val().replace(/\D/g, '');
            var newValue = parseFloat(value);
            if (totalsaved < 1) {
                $('#passwordHelpBlock').html('You have no savings yet!')
                $("#passwordHelpBlock").css("color", "red");
                return $('.submitBtn').hide()
            }
            if (value == "") {
                $('.refund').val('');
            } else {
                if (newValue < minApplication) {
                    $('#passwordHelpBlock').html('Minimum amount to apply for is ' + minApplication
                        .toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }))
                    $("#passwordHelpBlock").css("color", "red");
                    return $('.submitBtn').hide()
                }
                if (newValue > maxApplication) {
                    $('#passwordHelpBlock').html('Maximum amount to apply for is ' + maxApplication
                        .toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }))
                    $("#passwordHelpBlock").css("color", "red");
                    $('.submitBtn').hide()
                } else {
                    var totalRefund = newValue / refund;
                    $('.refund').val(totalRefund.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }))
                    $('.submitBtn').show()
                    $('#passwordHelpBlock').html('')
                }
            }
        });

        $("#loanApplication").on('submit', async function(e) {
            e.preventDefault();
            const serializedData = $("#loanApplication").serializeArray();
            $('.preloader').show();
            try {
                const postRequest = await $.ajax({
                    url: "/member/loan/apply",
                    type: 'POST',
                    data: processFormInputs(serializedData),
                    dataType: 'json'
                });
                $('.preloader').hide();
                $("#amountToBePaid").html(parseFloat(postRequest.amount).toLocaleString());
                $(".real_amount").val(postRequest.amount);
                $("#order_id").val(postRequest.order_id?.transaction_id || '');
                $('#paymentModal').modal('show');
            } catch (e) {
                $('.preloader').hide();
                if (e.responseJSON && 'message' in e.responseJSON) {
                    new swal("Opss", e.responseJSON.message, "error");
                } else {
                    new swal("Opss", "An error occurred. Please try again.", "error");
                }
            }
        });

        function processFormInputs(formInputs) {
            const data = {};
            formInputs.forEach(input => {
                data[input.name] = input.value;
            });
            return data;
        }
    });

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
                alert('Error generating bank details. Please try again.');
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
            alert('Account number copied!');
        });
    }
</script>
@endsection