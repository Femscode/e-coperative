@extends('ajo.member.master')

@section('header')
<script src="https://checkout.flutterwave.com/v3.js"></script>
<style>
    /* Global Styles */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f5f6f8;
    }

    .container {
        max-width: 800px;
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

    /* Contribution Items */
    .contribution-items {
        /* max-height: calc(100vh - 400px);
        overflow-y: auto; */
        /* padding-right: 10px; */
    }

    .contribution-item {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .contribution-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }

    .contribution-item .form-check-input:checked ~ .form-check-label {
    opacity: 0.7;
}

    .contribution-item .form-check {
        margin: 0;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .contribution-item .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 1rem;
        cursor: pointer;
        border: 2px solid #094168;
    }

    .contribution-item .form-check-input:checked {
        background-color: #094168;
        border-color: #094168;
    }

    .contribution-item .form-check-label {
        flex: 1;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .contribution-amount {
        font-weight: 600;
        color: #094168;
    }

    /* Sticky Footer */
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
        max-width: 800px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .grand-total-input {
        font-size: 1.25rem;
        font-weight: 600;
        color: #094168;
        background: #f1f5f9;
        border: 2px solid #094168;
        border-radius: 8px;
        padding: 0.5rem;
        width: 150px;
        text-align: center;
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

    /* Modal Styling */
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        padding: 0.75rem;
    }

    .form-control:focus {
        border-color: #094168;
        box-shadow: 0 0 0 0.2rem rgba(9, 65, 104, 0.1);
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

        .page-title-box {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .page-title-right {
            width: 100%;
        }
    }
</style>
@endsection

@section('main')
<!-- Payment Modal (Unchanged) -->
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

                        <button type="button" class="btn btn-primary btn-lg w-100 mt-4" onclick="handlePaymentSubmit()">
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
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="fw-bold">Pending Contribution Dues</h4>
                        <p class="text-muted">Select the contributions you want to pay</p>
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
                <div class="card">
                    <div class="card-body">
                        <form id="monthly-dues" method="post">
                            @csrf
                            <div class="contribution-list">
                                @if(count($months) > 0)
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="masterCheckbox" onchange="toggleAllCheckboxes()">
                                        <label class="form-check-label" for="masterCheckbox">
                                            Select All Contributions
                                        </label>
                                    </div>
                                    <span class="badge bg-primary">{{ count($months) }} Pending</span>
                                </div>

                                <div class="contribution-items">
                                    @foreach ($months as $month)
                                    <div class="contribution-item bg-white rounded-3 shadow-sm mb-3">
                                        <div class="p-3">
                                            <input type="hidden" value="Contribution" name="payment_type[]">
                                            <input type="hidden" value="{{ $month['uuid'] }}" name="uuid[]">
                                            <input type="hidden" value="{{ $month['amount'] }}" name="fee[]">

                                            <div class="form-check d-flex align-items-start">
                                                @if(!$month['paid'])
                                                <input class="form-check-input mt-2 controlledCheckbox"
                                                    data-id="{{ $month['amount'] }}"
                                                    name="check[]" type="checkbox" id="check_{{ $loop->index }}">
                                                @endif
                                                <label class="form-check-label ms-3 w-100" for="check_{{ $loop->index }}">
                                                    <div class="d-flex flex-column">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            @php
                                                            $displayDate = $month['period'] ?? '';
                                                            $displayTitle = $month['title'] ?? 'General Contribution';
                                                            @endphp
                                                            <div>
                                                                <input type="hidden" name="month[]" value="{{ $displayDate }}">
                                                                <h6 class="mb-1 fw-bold">{{ $displayTitle }}</h6>
                                                                <div class="text-muted small">{{ $displayDate }}</div>
                                                            </div>
                                                            <div class="contribution-amount text-end">
                                                                <input type="hidden" name="original[]" value="{{ $month['amount'] }}">
                                                                <div class="h5 mb-0 text-primary">₦{{ number_format($month['amount']) }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if(isset($month['mode']))
                                                            <span class="badge bg-light text-dark">{{ $month['mode'] }}</span>
                                                            @endif
                                                            @if($month['paid'])
                                                            <span class="badge bg-success">Paid</span>
                                                            @else
                                                            <span class="badge bg-warning">Pending</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
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

                            @if(count($months) > 0)
                            <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                            <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Footer -->
    @if(count($months) > 0)
    <div class="sticky-footer">

        <div class="grand-total-container">
            <div>
                <label class="fw-bold">Grand Total</label>
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
</main>
@endsection

@section('script')
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
        $('.controlledCheckbox:checked').each(function() {
            var $item = $(this).closest('.contribution-item');
            var paymentType = $item.find('[name="payment_type[]"]').val();
            var fee = $item.find('[name="fee[]"]').val();
            var month = $item.find('[name="month[]"]').val();
            var original = $item.find('[name="original[]"]').val();
            var uuid = $item.find('[name="uuid[]"]').val();

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
                $("#amountToBePaid").html(totalAmount.toLocaleString());
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
</script>
@endsection