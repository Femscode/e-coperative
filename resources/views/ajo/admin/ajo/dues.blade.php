@extends('cooperative.admin.master')

@section('header')
<script src="https://checkout.flutterwave.com/v3.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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

    .custom-table {
        border-collapse: separate;
        border-spacing: 0 0.5rem;
    }

    .custom-table thead th {
        border: none;
        font-weight: 600;
        color: #6c757d;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dues-row {
        background: #fff;
        transition: transform 0.2s ease;
    }

    .dues-row:hover {
        transform: translateX(5px);
    }

    .week-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(9, 65, 104, 0.1);
        color: #094168;
        border-radius: 8px;
    }

    .amount-badge {
        font-weight: 600;
        color: #094168;
        background: rgba(9, 65, 104, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 2rem;
    }

    .grand-total-input {
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        background: #fff;
        border: 2px solid #094168;
        color: #094168;
        border-radius: 0.75rem;
    }

    .form-check-input:checked {
        background-color: #094168;
        border-color: #094168;
    }

    .btn-primary {
        background-color: #094168;
        border-color: #094168;
    }

    .btn-primary:hover {
        background-color: #073251;
        border-color: #073251;
    }

    .empty-state-icon {
        background: rgba(9, 65, 104, 0.1);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
</style>
<style>
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

<style>
    /* Global Styles */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f5f6f8;
    }

    .container-fluid {
        max-width: 1200px;
        margin: auto;
        padding: 1rem;
    }

    /* Card Styling */
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        background: #fff;
        padding: 1.5rem;
    }

    /* Due Card Styling */
    .due-card {
        background: #fff;
        border-radius: 8px;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        transition: background 0.2s ease;
        position: relative;
    }

    .due-card:hover {
        background: #f9fafb;
    }

    .due-card .form-check {
        margin: 0;
        position: absolute;
        top: 1rem;
        left: 1rem;
    }

    .due-card .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #094168;
        cursor: pointer;
    }

    .due-card .form-check-input:checked {
        background-color: #094168;
        border-color: #094168;
    }

    .due-card-body {
        text-align: center;
        padding-top: 2rem;
    }

    .due-month {
        font-size: 1.1rem;
        font-weight: 600;
        color: #094168;
        margin-bottom: 0.5rem;
    }

    .due-type {
        margin-bottom: 1rem;
    }

    .due-amount {
        font-weight: 600;
        color: #FF821A;
    }

    /* Page Title */
    .page-title-box {
        background: #fff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    /* Search Box */
    .search-box .form-control {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 0.75rem 2.5rem;
        background: #fff;
    }

    .search-box .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #094168;
    }

    /* Sticky Footer */
    .grand-total-input {
        font-size: 1.25rem;
        font-weight: 600;
        color: #094168;
        background: #f1f5f9;
        border: 2px solid #094168;
        border-radius: 8px;
        padding: 0.5rem;
        width: 200px;
        text-align: center;
    }

    .sticky-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        border-top: 1px solid #e5e7eb;
        padding: 1rem;
        box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.05);
        z-index: 1000;
    }

    .sticky-footer .grand-total-container {
        max-width: 1200px;
        margin: auto;
        padding: 0 1rem;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 1rem;
    }

    .grand-total-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .sticky-footer .grand-total-container {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .grand-total-wrapper {
            flex-direction: column;
            width: 100%;
        }

        .grand-total-input {
            width: 100%;
            margin-top: 0.5rem;
        }
    }

    .btn-primary {
        background: #094168;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: background 0.2s ease;
    }

    .btn-primary:hover {
        background: #073251;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .sticky-footer .grand-total-container {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .btn-primary {
            width: 100%;
        }

        .page-title-box .d-flex {
            flex-direction: column;
            gap: 1rem;
        }

        .search-box {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Payment Modal (Copied from Previous Page for Consistency) -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <img src='{{url("admindashboard/images/logo/syncologo2.png")}}' alt='payaza' class="payment-logo" />
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">



                    <div class="amount-display text-center mb-4">
                        <span class="text-muted">Amount To Be Paid </span>
                        <h2 class="amount-text mb-0">₦<span id="amountToBePaid">0</span></h2>
                    </div>

                    <div class="card-details">
                        <form id="paymentForm" method="POST" accept-charset="UTF-8">
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

                            <button type="button" class="paynow_btn btn btn-primary btn-lg w-100 mt-4" onclick="handlePaymentSubmit()">
                                <i class="bi bi-lock me-2"></i>Pay Now
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-12 mb-4">
            <div class="page-title-box">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1">My Dues</h4>
                        <p class="text-muted">Select the contributions you want to pay</p>
                    </div>
                    <div class="search-box">
                        <div class="position-relative">
                            <input type="text" class="form-control" wire:model="search"
                                placeholder="Search dues...">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="monthly-dues" method="post">
                        @csrf
                        @if(count($months) > 0)
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    id="masterCheckbox" onchange="toggleAllCheckboxes()">
                                <label class="form-check-label" for="masterCheckbox">
                                    Select All Dues
                                </label>
                            </div>
                            <span class="badge bg-primary">{{ count($months) }} Pending</span>
                        </div>

                        <div class="row g-4">
                            @foreach ($months as $month)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="due-card">
                                    <div class="form-check">
                                        <input class="form-check-input controlledCheckbox"
                                            data-id="{{ $month['amount'] }}"
                                            name="check[]" type="checkbox" id="check_{{ $loop->index }}">
                                    </div>

                                    <input type="hidden" value="Contribution" name="payment_type[]">
                                    <input type="hidden" value="{{ $month['uuid'] }}" name="uuid[]">
                                    <input type="hidden" value="{{ $month['amount'] }}" name="fee[]">
                                    <input type="hidden" name="month[]"
                                        value="{{ $month['week'] ?? $month['month'] ?? $month['period'] ?? 'N/A' }}">

                                    <div class="due-card-body">
                                        <div class="due-month">
                                            @if(isset($month['week']))
                                            {{ $month['week'] }}
                                            @elseif(isset($month['month']))
                                            {{ $month['month'] }}
                                            @else
                                            {{ $month['day'] ?? 'N/A' }}
                                            @endif
                                        </div>
                                        <div class="due-type">
                                            <span class="badge bg-light text-dark rounded-pill px-3">
                                                {{ $month['title'] ?? 'General Contribution' }}
                                            </span>
                                        </div>
                                        <div class="due-amount">
                                            <span class="amount-label">Amount Due</span>
                                            <h5>₦{{ number_format($month['amount'], 2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                        <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">
                        @else
                        <div class="text-center py-5">
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-light text-primary fs-1 rounded-circle">
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

    <!-- Sticky Footer -->
    @if(count($months) > 0)
    <div class="sticky-footer">
        <div class="grand-total-container">
            <div class="grand-total-wrapper">
                <label for="total" class="fw-bold mb-0">Grand Total:</label>
                <input type="text" class="grand-total-input"
                    name="total_amount" value="0" readonly id="total">
            </div>
            <button type="submit" id="submit-btn"
                class="btn btn-primary submit-btn">
                <i class="bi bi-credit-card me-2"></i>
                Make Payment
            </button>
        </div>
    </div>
    @endif
    </form>
</div>
@endsection

@section('script')
<script>
    $('#monthly-dues').submit(function(e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var checkedData = filterCheckedData();
        processPayment(checkedData);
    });

    function filterCheckedData() {
        var checkedData = [];
        $('.controlledCheckbox:checked').each(function() {
            var $card = $(this).closest('.due-card');
            var paymentType = $card.find('[name="payment_type[]"]').val();
            var fee = $card.find('[name="fee[]"]').val();
            var month = $card.find('[name="month[]"]').val();
            var uuid = $card.find('[name="uuid[]"]').val();

            checkedData.push({
                payment_type: paymentType,
                fee: fee,
                month: month,
                uuid: uuid
            });
        });
        return checkedData;
    }

    function processPayment(data) {
        var email = $('#userEmail').val();
        var phone = $('#userPhone').val();
        var totalAmount = $('#total').val().replace(/,/g, '');
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
                $("#amountToBePaid").html(new Intl.NumberFormat('en-NG', { 
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(totalAmount));
                $(".real_amount").val(totalAmount)
                $("#order_id").val(e.order_id.transaction_id);
                $('#paymentModal').modal('show');
            },
            error: function(e) {
                $('.preloader').hide();
                new swal("Opss", e.responseJSON.message, "error");
            }
        });
    }
</script>

<script>
    function toggleAllCheckboxes() {
        const masterCheckbox = document.getElementById('masterCheckbox');
        const controlledCheckboxes = document.getElementsByClassName('controlledCheckbox');
        const isChecked = masterCheckbox.checked;
        let totalAmount = 0;

        for (let i = 0; i < controlledCheckboxes.length; i++) {
            controlledCheckboxes[i].checked = isChecked;
            if (isChecked) {
                const amount = parseFloat(controlledCheckboxes[i].getAttribute('data-id'));
                totalAmount += amount;
            }
        }
        $("#total").val(totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $("#submit-btn").toggle(totalAmount > 0);
    }
</script>

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#submit-btn").hide();

        $(".controlledCheckbox").on("change", function() {
            let total = parseFloat($("#total").val().replace(/,/g, '')) || 0;
            const amount = parseFloat($(this).data('id'));

            if ($(this).is(":checked")) {
                total += amount;
            } else {
                total -= amount;
            }

            $("#total").val(total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $("#submit-btn").toggle(total > 0);
        });
    });
</script>
<script>
    function handlePaymentSubmit() {
        const paymentType = document.querySelector('input[name="type"]:checked');

        if (!paymentType) {
            alert('Please select a payment method');
            return;
        }

        if (paymentType.value === 'card') {
            makePayment();
        } else {
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
        const submitBtn = document.querySelector('.paynow_btn');

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
</script>
@endsection