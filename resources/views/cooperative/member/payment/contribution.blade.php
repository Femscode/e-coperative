@extends('cooperative.member.master')

@section('header')
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
    .contribution-item {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .contribution-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    }

    .contribution-item .form-check-input:checked~.form-check-label {
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
    }
</style>
@endsection

@section('main')
<!-- Payment Modal (Unchanged) -->
@include('includes.payment-modal', [
    'amount' => $amount ?? null,
    'redirect_url' => $redirect_url ?? null
])
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold">Pending Contribution Dues</h4>
                <p class="text-muted">Select the contributions you want to pay</p>
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
                                            Select All Dues
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
</main>
@endsection

@section('script')
<!-- Existing Scripts (Unchanged) -->
<script src="https://js.paystack.co/v1/inline.js"></script>
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
    })

    function filterCheckedData() {
        var checkedData = [];
        $('.controlledCheckbox:checked').each(function() {
            var $row = $(this).closest('.contribution-item');
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
                $(".real_amount").val(totalAmount);
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
    // Toggle All Checkboxes
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

@endsection