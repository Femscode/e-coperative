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
                        <span>Request For Loan</span>
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
                        <form id="monthly-dues" method="post" onsubmit="return handlePaymentSubmit(event)">
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
                                        <button type="submit" id="submit-btn" class="btn btn-primary btn-lg px-5 submit-btn">
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

<style>
    .nav-tabs-custom {
        border-bottom: 2px solid #e9ecef;
    }

    .nav-tabs-custom .nav-link {
      border: none;
        padding: 1rem 1.5rem;
        color: #6c757d;
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-tabs-custom .nav-link.active {
        color: #094168;
        background: transparent;
    }

    .nav-tabs-custom .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: #094168;
    }

    .nav-tabs-custom .nav-link:hover {
        color: #094168;
    }

    .table td,
    .table th {
        padding: 1rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    .btn-primary {
        background: #094168;
        border-color: #094168;
    }

    .btn-primary:hover {
        background: #073251;
        border-color: #073251;
    }

    .form-check-input:checked {
        background-color: #094168;
        border-color: #094168;
    }

    .payment-summary .form-control {
        background: #fff;
        border: 1px solid #dee2e6;
        font-size: 1.25rem;
        font-weight: 600;
        color: #094168;
    }
</style>
@endsection

@section('script')
<script>
    function handlePaymentSubmit(event) {
        event.preventDefault();
        var checkedData = filterCheckedData();
        processPayment(checkedData);
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

    function processPayment(data) {
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
                checkedData: data,
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
        const amount = parseFloat(document.getElementById('total').value.replace(/,/g, ''));

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
        if (totalAmount == 0) {
            $(".submit-btn").hide();
        } else {
            $(".submit-btn").show();
        }
    }

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

            if (addSum == 0) {
                $(".submit-btn").hide();
            } else {
                $(".submit-btn").show();
            }
        });
    });
</script>
@endsection