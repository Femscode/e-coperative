@extends('cooperative.member.master')

@section('header')
<script src="https://checkout.flutterwave.com/v3.js"></script>
@endsection

@section('main')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <!-- Navigation Tabs -->
        <div class="loan-nav-wrapper mb-4">
            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="/member/loan">
                        <i class="bi bi-plus-circle me-1"></i>
                        <span>Requests For Loan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active2" href="/member/loan-repayment">
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
                    <a class="nav-link {{ request()->is('member/loan-repayment/completed*') ? 'active' : '' }}" href="/member/loan/completed">
                        <i class="bi bi-check-circle me-1"></i>
                        <span>Completed Loans</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light py-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-history fs-4 me-2 text-primary"></i>
                            <h5 class="card-title mb-0">Pending Repayments</h5>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form id="monthly-dues" method="post">
                            @csrf
                            <div class="table-responsive">
                                @if(count($months) > 0)
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="masterCheckbox" onchange="toggleAllCheckboxes()" value="option1">
                                                </div>
                                            </th>
                                            <th>Month</th>
                                            <th>Type</th>
                                            <th class="text-end">Amount(₦)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($months as $month)
                                        <tr>
                                            <input type="hidden" @isset($month['amount']) value="Repayment" @else value="Monthly Dues" @endisset name="payment_type[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['uuid'] }}" @else value="" @endisset name="uuid[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['amount'] }}" @else value="{{ $plan->dues }}" @endisset name="fee[]">
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input controlledCheckbox" @isset($month['amount']) data-id="{{ $month['amount'] }}" @else data-id="{{ $plan->dues }}" @endisset name="check[]" type="checkbox" id="inlineCheckbox2">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="hidden" name="month[]" value="{{ $month['month'] }}">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-calendar-month me-2 text-muted"></i>
                                                    {{ $month['month'] }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    @isset($month['amount']) Repayment @else Monthly Dues @endisset
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <input type="hidden" name="original[]" @isset($month['amount']) value="{{ $month['amount'] }}" @else value="{{ $plan->getMondays($month['month']) * $plan->monthly_dues }}" @endisset>
                                                <strong>
                                                    @isset($month['amount'])
                                                    {{ number_format($month['amount'], 2) }}
                                                    @else
                                                    {{ number_format($plan->dues, 2) }}
                                                    @endisset
                                                </strong>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Payment Summary -->
                                <div class="payment-summary mt-4">
                                    <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                                    <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">
                                    <input type="hidden" id="userName" name="name" value="{{Auth::user()->name}}">
                                    <input type="hidden" id="real_amount" name="real_amount">
                                    <input id='public_key' value='{{ env('FLW_PUBLIC_KEY') }}' type='hidden' />
                                    <input id='redirect_url' value='https://vtubiz.com/payment/callback' type='hidden' />

                                    <div class="row justify-content-end">
                                        <div class="col-md-4">
                                            <div class="bg-light rounded-4 p-4">
                                                <label class="form-label text-uppercase fw-bold mb-3">Total Amount</label>
                                                <input type="text" class="form-control form-control-lg text-center" name="total_amount" value="0" readonly id="total">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 text-end">
                                        <button type="button" id="submit-btn" class="btn btn-primary btn-lg px-5 submit-btn" data-bs-toggle="modal" data-bs-target="#paymentMethodModal">
                                            <i class="bi bi-credit-card me-2"></i>Make Payment
                                        </button>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#094168,secondary:#22c55e" style="width:80px;height:80px">
                                        </lord-icon>
                                    </div>
                                    <h5>No Pending Repayments!</h5>
                                    <p class="text-muted">You're all caught up with your loan repayments.</p>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Payment Method Modal -->
<div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header border-0">
                <h5 class="modal-title">Select Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="paymentForm" onsubmit="return handlePaymentSubmit(event)">
                    <div class="mb-4">
                        <div class="payment-methods">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="bankTransfer" value="transfer" checked>
                                <label class="form-check-label d-flex align-items-center" for="bankTransfer">
                                    <i class="bi bi-bank me-2"></i>
                                    Bank Transfer
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="type" id="cardPayment" value="card">
                                <label class="form-check-label d-flex align-items-center" for="cardPayment">
                                    <i class="bi bi-credit-card me-2"></i>
                                    Pay with Card
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3">
                        <i class="bi bi-lock me-2"></i>Proceed to Pay
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bank Details Modal -->
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
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".submit-btn").hide();

        $(".controlledCheckbox").on("change", function(e) {
            const total = $("#total").val().replace(/,/g, '');
            var sign = Number.parseFloat(total);
            const amount = $(this).data('id');
            var signet = Number.parseFloat(amount);
            if ($(this).is(":checked")) {
                var addSum = sign + signet;
            } else {
                var addSum = sign - signet;
            }

            $("#total").val(addSum.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $("#real_amount").val(addSum.toFixed(2));

            if (addSum == 0) {
                $(".submit-btn").hide();
            } else {
                $(".submit-btn").show();
            }
        });
    });

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
        $("#real_amount").val(totalAmount.toFixed(2));

        if (totalAmount == 0) {
            $(".submit-btn").hide();
        } else {
            $(".submit-btn").show();
        }
    }

    function handlePaymentSubmit(event) {
        event.preventDefault();
        const paymentType = document.querySelector('input[name="type"]:checked').value;
        $('#paymentMethodModal').modal('hide');

        if (paymentType === 'card') {
            processCardPayment();
        } else {
            generateBankDetails();
        }
        return false;
    }

    function filterCheckedData() {
        var checkedData = [];
        $('.controlledCheckbox:checked').each(function() {
            var $row = $(this).closest('tr');
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

    function processCardPayment() {
        var checkedData = filterCheckedData();
        var email = $('#userEmail').val();
        var phone = $('#userPhone').val();
        var name = $('#userName').val();
        var totalAmount = $('#total').val().replace(/,/g, '');
        $('.preloader').show();

        $.ajax({
            type: 'POST',
            url: "{{ route('pay-dues') }}",
            dataType: 'json',
            data: {
                checkedData: checkedData,
                email: email,
                phone: phone,
                total_amount: totalAmount,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                $('.preloader').hide();
                makePayment(response);
            },
            error: function(e) {
                $('.preloader').hide();
                new swal("Opss", e.responseJSON.message, "error");
            }
        });
    }

    function makePayment(data) {
        const public_key = document.getElementById('public_key').value;
        const redirect_url = document.getElementById('redirect_url').value;
        const email = document.getElementById('userEmail').value;
        const phone = document.getElementById('userPhone').value;
        const name = document.getElementById('userName').value;
        const amount = parseFloat(document.getElementById('real_amount').value);

        FlutterwaveCheckout({
            public_key: public_key,
            tx_ref: data.transaction_id || "titanic-48981487343MDI0NzJD",
            amount: amount,
            currency: "NGN",
            payment_options: "card, mobilemoneyghana, ussd",
            redirect_url: redirect_url,
            meta: {
                consumer_id: 13,
                consumer_mac: "92a3-983jd-1192a",
                order_id: data.order_id
            },
            customer: {
                email: email,
                phone_number: phone,
                name: name,
            },
            customizations: {
                title: "Syncosave Loan Repayment",
                description: "Loan Repayment Payment",
                logo: "https://syncosave.com/admindashboard/images/logo/syncologo2.png",
            },
        });
    }

    function generateBankDetails() {
        const amount = parseFloat(document.getElementById('real_amount').value);
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
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                $('#paymentModal').modal('show');

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
                submitBtn.innerHTML = '<i class="bi bi-lock me-2"></i>Proceed to Pay';
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Error generating bank details. Please try again.');
                
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bi bi-lock me-2"></i>Proceed to Pay';
            }
        });
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Account number copied!');
        });
    }
</script>
@endsection