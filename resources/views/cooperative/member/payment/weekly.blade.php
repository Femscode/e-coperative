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

<!-- Payment Modal -->
@include('includes.payment-modal', [
    'amount' => $amount ?? null,
    'redirect_url' => $redirect_url ?? null
])
<!-- Main Content -->
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="page-header bg-light rounded-4 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-1">Pending Weekly Dues</h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Weekly Dues</a></li>
                                    <li class="breadcrumb-item active">Pending</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="page-actions">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-download me-2"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <form id="monthly-dues" method="post">
                            @csrf
                            <div class="table-responsive">
                                @if(count($months) > 0)
                                <table class="table table-hover align-middle custom-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" width="50">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="masterCheckbox" onchange="toggleAllCheckboxes()"
                                                        value="option1">
                                                </div>
                                            </th>
                                            <th scope="col">Week</th>
                                            <th scope="col" class="text-end">Amount(₦)</th>
                                            <th scope="col" class="text-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($months as $month)
                                        <tr class="dues-row {{ isset($month['paid']) && $month['paid'] ? 'bg-light' : '' }}">
                                            <input type="hidden" @isset($month['amount']) value="Repayment"
                                                @else value="Weekly Dues" @endisset name="payment_type[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['uuid'] ?? ''}}"
                                                @else value="" @endisset name="uuid[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['amount'] }}"
                                                @else value="{{ $plan->dues }}" @endisset name="fee[]">

                                            <td>
                                                <div class="form-check">
                                                    @if(!isset($month['paid']) || !$month['paid'])
                                                    <input class="form-check-input controlledCheckbox"
                                                        @isset($month['amount']) data-id="{{ $month['amount'] }}"
                                                        @else data-id="{{ $plan->dues }}" @endisset
                                                        name="check[]" type="checkbox">
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <input type="hidden" name="week[]" value="{{ $month['week'] }}">
                                                <div class="d-flex align-items-center">
                                                    <!-- <span class="week-icon me-2">
                                                        <i class="bi bi-calendar-week"></i>
                                                    </span> -->
                                                    <span class="fw-medium">{{ $month['week'] }}</span>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <input type="hidden" name="original[]"
                                                    @isset($month['amount']) value="{{ $month['amount'] }}"
                                                    @else value="{{ $plan->dues }}" @endisset>
                                                <span class="amount-badge">
                                                    @isset($month['amount'])
                                                    {{ number_format($month['amount'], 2)}}
                                                    @else
                                                    {{ number_format($plan->dues, 2)}}
                                                    @endisset
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                @if(isset($month['paid']) && $month['paid'])
                                                <span class="badge bg-success">Paid</span>
                                                @else
                                                <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                </table>
                                @else
                                <div class="empty-state text-center py-5">
                                    <div class="empty-state-icon mb-3">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                            trigger="loop" colors="primary:#094168,secondary:#22c55e"
                                            style="width:80px;height:80px">
                                        </lord-icon>
                                    </div>
                                    <h5>No Pending Dues!</h5>
                                    <p class="text-muted">You're all caught up with your payments.</p>
                                </div>
                                @endif
                            </div>

                            @if(count($months) > 0)
                            <div class="payment-summary sticky-footer">
                                <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                                <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">

                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="grand-total-container">
                                                <label for="total" class="form-label text-uppercase fw-bold mb-3">
                                                    Grand Total
                                                </label>
                                                <input type="text" class="form-control form-control-lg grand-total-input"
                                                    name="total_amount" value="0" readonly id="total">
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <button type="submit" id="submit-btn"
                                                class="btn btn-primary btn-lg submit-btn">
                                                <i class="bi bi-credit-card me-2"></i>Make Payment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@section('script')
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
            var $row = $(this).closest('tr');
            var paymentType = $row.find('[name="payment_type[]"]').val();
            var fee = $row.find('[name="fee[]"]').val();
            var week = $row.find('[name="week[]"]').val();
            var original = $row.find('[name="original[]"]').val();
            var uuid = $row.find('[name="uuid[]"]').val();

            checkedData.push({
                payment_type: paymentType,
                fee: fee,
                week: week,
                original: original,
                uuid: uuid
            });
        });
        return checkedData;
    }

    function processPayment(data) {
        var email = $('#userEmail').val();
        var phone = $('#userPhone').val();
        var totalAmount = $('#total').val();
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
        toggleStickyFooter(totalAmount);
    }

    function toggleStickyFooter(totalAmount) {
        if (totalAmount > 0) {
            $('.payment-summary').addClass('show');
        } else {
            $('.payment-summary').removeClass('show');
        }
    }

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".controlledCheckbox").on("change", function() {
            const total = $("#total").val().replace(/,/g, '');
            var sign = Number.parseFloat(total);
            const amount = $(this).data('id');
            var signet = Number.parseFloat(amount);
            let addSum;

            if ($(this).is(":checked")) {
                addSum = sign + signet;
            } else {
                addSum = sign - signet;
            }

            $("#total").val(addSum.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            toggleStickyFooter(addSum);
        });
    });
</script>
@endsection