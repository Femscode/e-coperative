@extends('member.layout.master')

@section('content')
    <div class="container-fluid">

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
                                                    data-min="{{ auth()->user()->plan()->min_loan_range ?? ""}}"
                                                    data-max="{{ auth()->user()->plan()->max_loan_range ?? "" }}"
                                                    data-refund="{{ auth()->user()->plan()->month ?? ""}}"
                                                    min="{{ auth()->user()->plan()->min_loan_range ?? "" }}"
                                                    max="{{ auth()->user()->plan()->max_loan_range ?? "" }}"
                                                    class="form-control loanAmount amount" id=""
                                                    placeholder="Enter amount">
                                                <div id="passwordHelpBlock" class="form-text">
                                                </div>
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="lastnameInput" class="form-label">Monthly Refund</label>
                                                <input type="text" required readonly name="monthly_return"
                                                    class="form-control refund" id="" placeholder="monthly refund">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> --}}
                                                <button type="button"
                                                    class="btn btn-link link-success text-decoration-none fw-medium"
                                                    data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                                    Close</button>
                                                <button type="submit" class="btn btn-primary submitBtn"><i
                                                        class="ri-save-3-line align-bottom me-1"></i> Save</button>
                                            </div>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end modal-->

    </div>
    <!-- container-fluid -->
@endsection

@section('script')
<script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        // function myFunction(event) {
        //  console.log("here")
        $(".loanAmount").keypress(function(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            $(".loanAmount").on('keyup', function() {
                // event.preventDefault();
                var n = parseInt($(this).val().replace(/\D/g, ''), 10);
                $(this).val(n.toLocaleString());
                if (isNaN(n)) {
                    $(".loanAmount").val("");
                    // $(this).val();
                }

            });
        });
        // }
    </script>
    <script>
            function processPayment(element) {
                var uuid = $(element).data('id');
                // alert(uuid)
                var totalAmount = $(element).data('amount');
                $('.preloader').show();
                var ajaxUrl = "{{ route('pay-form') }}";
                $.ajax({
                    type: 'POST',
                    url: ajaxUrl,
                    dataType: 'json',
                    data: {
                        uuid: uuid,
                        total_amount: totalAmount,
                    },
                    success: function(e) {
                        $('.preloader').hide();
                        payWithPaystack(e);
                    },
                    error: function(e) {
                        $('.preloader').hide();
                        // var errorList = '';
                        // Object.keys(e.responseJSON.message).forEach(function(key) {
                        // errorList += '<li>' + e.responseJSON.message[key][0] + '</li>';
                        // });
                        new swal("Opss", e.responseJSON.message, "error");
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
                    email: data.email,
                    amount: data.amount_paid * 100,
                    order_id: data.order_id,
                    phone: data.phone,
                    process_transaction: "1",
                    card: data.card,
                };

                var data = data;
                var handler = PaystackPop.setup({
                    // key: 'pk_live_af922c7f707c7ad3dc1a03433a3768007f6a0401',
                    key: paystackSecretKey, //'pk_test_031c3ba6cf25565da961c7bceea2f75887d08e22',
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

                        location.href = "/paystack/transaction-successful?order_id=" + orderObj
                            .order_id +
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });



            $("#loanApplication").on('submit', async function(e) {
                e.preventDefault();
                const serializedData = $("#loanApplication").serializeArray();
                $('.preloader').show();
                try {
                    const postRequest = await request("/member/loan/apply",
                        processFormInputs(
                            serializedData), 'post');
                    console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    $('#loanApplication').trigger("reset");
                    $("#loanApplication .close").click();
                    window.location.reload();
                } catch (e) {
                    $('.preloader').hide();
                    if ('message' in e) {
                        // console.log('e.message', e.message);
                        new swal("Opss", e.message, "error");

                    }
                }
            })

            $('.amount').on('keyup', function() {
                var min = $(this).data('min');
                var max = $(this).data('max');
                var refund = $(this).data('refund');
                var value = $(this).val().replace(/\D/g, '');
                var newValue = parseFloat(value);
                var newMax = parseFloat(max);
                if (value == "") {
                    $('.refund').val('');
                } else {
                    if (newValue > max) {
                        $('#passwordHelpBlock').html('Maximum amount to apply for is ' + newMax
                            .toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }))
                        $("#passwordHelpBlock").css("color", "red");
                        $('.submitBtn').hide()
                        // new swal("Opss", 'Maximum amount to apply for is ' + max, "error");
                    } else {
                        var refund = newValue / refund;
                        if (Number.isInteger(refund)) {
                            $('.refund').val(refund.toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }))
                        } else {
                            var roundedValue = Math.round(refund / 100) * 100 + 100;
                            $('.refund').val(roundedValue.toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }))
                        }
                        $('.submitBtn').show()
                        // var refundRound = Math.round(refund/100) * 100 + 100;
                        $('#passwordHelpBlock').html('')

                    }
                }


            });

        })
    </script>
@endsection
