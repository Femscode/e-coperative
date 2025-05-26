@extends('cooperative.member.master')
@section('header')
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
                        <h4 class="mb-1">Manual Payment</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Manual</a></li>
                                <li class="breadcrumb-item active">Payment</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="payment-icon mb-3">
                                <i class="bi bi-wallet2 fs-1 text-primary"></i>
                            </div>
                            <h4 class="card-title mb-2">Fund Your Savings</h4>
                            <p class="text-muted">Enter any amount you'd like to save</p>
                        </div>

                        <form method="POST" id="monthly-dues" class="payment-form">
                            @csrf
                            <div class="mb-4">
                                <label for="total" class="form-label">Amount to Pay</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">₦</span>
                                    <input type="number" name="amount" class="form-control form-control-lg" 
                                        id="total" placeholder="Enter amount" required>
                                </div>
                            </div>

                            <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                            <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">

                            <button class="btn btn-primary btn-lg w-100" type="submit">
                                <i class="bi bi-credit-card me-2"></i>
                                {{ __('Proceed to Payment') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.payment-icon {
    width: 80px;
    height: 80px;
    background: rgba(9, 65, 104, 0.1);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
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

.payment-form .form-control:focus {
    border-color: #094168;
    box-shadow: 0 0 0 0.25rem rgba(9, 65, 104, 0.1);
}

.btn-primary {
    background-color: #094168;
    border-color: #094168;
}

.btn-primary:hover {
    background-color: #073251;
    border-color: #073251;
}
</style>
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
        // $('.preloader').show();
        e.preventDefault();
        // alert("ere")
        var checkedData = $(this).serializeArray(); //filterCheckedData();
        processPayment(checkedData);
    })


    function processPayment(data) {
        data = data;
        var email = $('#userEmail').val();
        var phone = $('#userPhone').val();
        var totalAmount = $('#total').val();
        $('.preloader').show();
        var ajaxUrl = "{{ route('pay-anytime') }}";
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
                $('.preloader').hide();
                $("#amountToBePaid").html(totalAmount)
                $(".real_amount").val(totalAmount)
                $("#order_id").val(e.order_id.transaction_id)
                $('#paymentModal').modal('show');
                // payWithPaystack(e);
            },
            error: function(e) {
                $('.preloader').hide();
                // var errorList = '';
                // Object.keys(e.responseJSON.message).forEach(function(key) {
                // errorList += '<li>' + e.responseJSON.message[key][0] + '</li>';
                // });
                new showCustomAlert("Opss", e.responseJSON.message, "error");
            }
        })

    }



  
</script>
<script>
    // toggle all
    function toggleAllCheckboxes() {
        const masterCheckbox = document.getElementById('masterCheckbox');
        const controlledCheckboxes = document.getElementsByClassName('controlledCheckbox');
        const isChecked = masterCheckbox.checked;
        let totalAmount = 0; // Initialize the total amount variable

        for (let i = 0; i < controlledCheckboxes.length; i++) {
            controlledCheckboxes[i].checked = isChecked;
            if (isChecked) {
                // If the master checkbox is checked, add the data('id') to the totalAmount
                const amount = parseFloat(controlledCheckboxes[i].getAttribute('data-id'));
                totalAmount += amount;
            }
        }
        $("#total").val(totalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        if (totalAmount == 0) {
            $(".submit-btn").hide();
            $(".submit-btn").hide();
        } else {
            $(".submit-btn").show();
            $(".submit-btn").show();
        }
    }
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".submit-btn").hide();
        $(".submit-btn").hide();
        // check or uncheck any data
        $(".controlledCheckbox").on("change", function(e) {
            // console.log("is_checked", $(this).is(":checked"));
            // $(this).data('id');
            const total = $("#total").val().replace(/,/g, '');
            var sign = Number.parseFloat(total);
            // const service = $(this).attr('value');
            const amount = $(this).data('id');
            var signet = Number.parseFloat(amount);
            if ($(this).is(":checked") == true)
                var addSum = sign + signet; //.toFixed(2);
            $("#total").val(addSum);
            // alert("heree")
            if ($(this).is(":checked") == false)
                var addSum = sign - signet; //.toFixed(2);

            $("#total").val(addSum.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

            if (addSum == 0) {
                $(".submit-btn").hide();
                $(".submit-btn").hide();
            } else {
                $(".submit-btn").show();
                $(".submit-btn").show();
            }

        })

    })

</script>
@endsection