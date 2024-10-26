@extends('member.layout.master')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Pending Monthly Dues</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Monthly Dues</a></li>
                        <li class="breadcrumb-item active">Pending</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Available Monthly Dues</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <form id="monthly-dues" method="post">
                        @csrf
                        <div class="live-preview">
                            <div class="row">
                                <div class="table-responsive">
                                    @if(count($months) > 0)
                                        <table class="table table-hover align-middle table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 25px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input"  type="checkbox" id="masterCheckbox" onchange="toggleAllCheckboxes()" value="option1">
                                                        </div>
                                                    </th>
                                                    <th scope="col">Month</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Amount(&#x20A6;)</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($months as $month)
                                                    <tr>
                                                        <input type="hidden" @isset($month['amount']) value="Repayment" @else value="Monthly Dues" @endisset  name="payment_type[]">
                                                        <input type="hidden" @isset($month['amount']) value="{{ $month['uuid'] }}" @else value="" @endisset  name="uuid[]">
                                                        <input type="hidden" @isset($month['amount']) value="{{ $month['amount'] }}" @else value="{{ $plan->dues }}" @endisset name="fee[]">
                                                        <th scope="row">
                                                            <div class="form-check">
                                                                <input class="form-check-input controlledCheckbox" @isset($month['amount']) data-id="{{ $month['amount'] }}" @else data-id="{{ $plan->dues }}" @endisset name="check[]" type="checkbox" id="inlineCheckbox2"  >
                                                            </div>
                                                        </th>
                                                        <td> <input type="hidden" name="month[]" value="{{ $month['month'] }}"> {{ $month['month'] }}</td>
                                                        <td> @isset($month['amount']) Repayment @else Monthly Dues @endisset</td>
                                                        <td> <input type="hidden" name="original[]"  @isset($month['amount']) value="{{ $month['amount'] }}" @else value="{{ $plan->getMondays($month['month']) * $plan->monthly_dues  }}" @endisset> @isset($month['amount']) {{ number_format($month['amount'] , 2)}} @else {{ number_format($plan->dues, 2)}} @endisset </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                    @if(count($months) < 1)
                                        <div class="noresult" >
                                            <div class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                                </lord-icon>
                                                <h5 class="mt-2"> No Pending Dues!</h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div><!--end row-->
                        </div>
                        @if(count($months) > 0)
                        <div class="live-preview submit-btn">
                            <input type="hidden" id="userEmail" name="email" value="{{Auth::user()->email}}">
                            <input type="hidden" id="userPhone" name="phone" value="{{Auth::user()->phone}}">
                            <div class="row gy-4">
                                <div class="col-xxl-3 col-md-3">
                                    <div>
                                        <input type="text" class="form-control mt-2" name="total_amount" value="0" readonly id="total">
                                    </div>
                                </div><!--end col-->
                            </div>
                        </div>
                        <hr>
                        <div class="hstack gap-2 ">
                            <button type="submit" id="submit-btn" class="btn btn-success submit-btn">Make Payment</button>
                        </div>
                        @endif
                    </form>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div><!--end row-->
</div>
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
        var checkedData = filterCheckedData();
        processPayment(checkedData);
    })

    function filterCheckedData() {
        var checkedData = [];

        // Iterate through the checked checkboxes and collect data from the same row
        $('.controlledCheckbox:checked').each(function () {
            var $row = $(this).closest('tr'); // Find the closest row
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
        data = data;
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
                checkedData: data ,
                email : email,
                phone : phone,
                total_amount: totalAmount,
            },
            success: function(e) {
                $('.preloader').hide();
                $('.preloader').hide();
                payWithPaystack(e);
            },
            error: function(e) {
                $('.preloader').hide();
                // var errorList = '';
                // Object.keys(e.responseJSON.message).forEach(function(key) {
                // errorList += '<li>' + e.responseJSON.message[key][0] + '</li>';
                // });
                new swal("Opss",e.responseJSON.message,"error");
            }
        })

    }

    function handlePaystackPopup(event) {
    const paystackPopup = PaystackPop.setup(config);
    paystackPopup.openIframe();
    }
    const paystackSecretKey = @json(env('PAYSTACK_PUBLIC_KEY'));
    function payWithPaystack(data) {
        // console.log(data)
        var orderObj = {
            email: $('[name=email]').val(),
            amount: data.amount_paid * 100,
            order_id: data.order_id,
            phone: $('[name=phone]').val(),
            process_transaction: "1",
            card: data.card,
        };

        var data = data;
        var handler = PaystackPop.setup({
            // key: 'pk_live_af922c7f707c7ad3dc1a03433a3768007f6a0401',
            key: paystackSecretKey,//'pk_test_031c3ba6cf25565da961c7bceea2f75887d08e22',
            // key: 'pk_test_a36f058d84321e7d8f7f2d27655ddddd6a700b3f',
            // key: 'pk_live_e139b3ad8d001c8219ed6ea7fb1cb756d2ce66f1',
            email: orderObj.email,
            amount: orderObj.amount,
            ref: data.transaction_id,
            metadata: {
                custom_fields: [{
                    display_name: "Order ID",
                    variable_name: "order_id",
                    value: orderObj.order_id
                }]
            },
            callback: function(response) {
                $('.preloader').show();

                location.href = "/paystack/transaction-successful?order_id=" + orderObj.order_id +
                    '&reference=' + response.reference;

            },
            onClose: function() {
                $('.preloader').hide();
                alert('Click "Pay online now" to retry payment.');
            }
        });
        handler.openIframe();
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
        if(totalAmount == 0){
            $(".submit-btn").hide();
            $(".submit-btn").hide();
        }else{
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
        $(".controlledCheckbox").on("change",function(e){
            // console.log("is_checked", $(this).is(":checked"));
            // $(this).data('id');
            const total = $("#total").val().replace(/,/g, '');
            var sign =  Number.parseFloat(total);
            // const service = $(this).attr('value');
            const amount =  $(this).data('id');
            var signet = Number.parseFloat(amount);
            if($(this).is(":checked") == true)
            var addSum = sign + signet ;//.toFixed(2);
            $("#total").val(addSum);
            // alert("heree")
            if($(this).is(":checked") == false)
            var addSum = sign - signet ;//.toFixed(2);

            $("#total").val(addSum.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

            if(addSum == 0){
                $(".submit-btn").hide();
                $(".submit-btn").hide();
            }else{
                $(".submit-btn").show();
                $(".submit-btn").show();
            }

        })

    })
</script>
@endsection
