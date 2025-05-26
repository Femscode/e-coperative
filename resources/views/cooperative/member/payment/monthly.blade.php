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

    .grand-total-container {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }

    .submit-btn {
        padding: 0.75rem 2rem !important;
    }
</style>
@endsection

@section('main')
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
                <div class="page-header d-flex align-items-center justify-content-between bg-light rounded-4 p-4">
                    <div>
                        <h4 class="mb-1">Pending Monthly Dues</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Monthly Dues</a></li>
                                <li class="breadcrumb-item active">Pending</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
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
                                                    <input class="form-check-input" type="checkbox"
                                                        id="masterCheckbox" onchange="toggleAllCheckboxes()"
                                                        value="option1">
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
                                            <input type="hidden" @isset($month['amount']) value="Repayment"
                                                @else value="Monthly Dues" @endisset name="payment_type[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['uuid'] ?? '' }}"
                                                @else value="" @endisset name="uuid[]">
                                            <input type="hidden" @isset($month['amount']) value="{{ $month['amount'] }}"
                                                @else value="{{ $plan->dues }}" @endisset name="fee[]">

                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input controlledCheckbox"
                                                        @isset($month['amount']) data-id="{{ $month['amount'] }}"
                                                        @else data-id="{{ $plan->dues }}" @endisset
                                                        name="check[]" type="checkbox" id="inlineCheckbox2">
                                                </div>
                                            </td>
                                            <td>
                                                <input type="hidden" name="month[]" value="{{ $month['month'] }}">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-calendar-month me-2"></i>
                                                    <span>{{ $month['month'] }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    @isset($month['amount']) Repayment @else Monthly Dues @endisset
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <input type="hidden" name="original[]"
                                                    @isset($month['amount']) value="{{ $month['amount'] }}"
                                                    @else value="{{ $plan->getMondays($month['month']) * $plan->monthly_dues }}"
                                                    @endisset>
                                                @isset($month['amount'])
                                                {{ number_format($month['amount'], 2) }}
                                                @else
                                                {{ number_format($plan->dues, 2) }}
                                                @endisset
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <div class="text-center py-5">
                                    <div class="mb-3">
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
                            <div class="sticky-footer">
                                <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                                <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">

                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div class="grand-total-container">
                                                <label for="total" class="form-label text-uppercase fw-bold mb-3">
                                                    Grand Total
                                                </label>
                                                <input type="text" class="form-control form-control-lg text-center"
                                                    name="total_amount" value="0" readonly id="total">
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <button type="submit" id="submit-btn" class="btn btn-primary btn-lg submit-btn">
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
@endsection

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
            $('.sticky-footer').addClass('show');
        } else {
            $('.sticky-footer').removeClass('show');
        }
    }

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.controlledCheckbox').on('change', function() {
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