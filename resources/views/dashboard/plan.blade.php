@extends('dashboard.master')
@section('header')

@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Rules / Plans</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="card">
        <div class="card-header border-0 rounded text-center">
           <h1>Rules For Members</h1>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <form id="specifyCoop" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="lastnameInput" class="form-label">Registration Fee</label>
                                <input type="number" required name="reg_fee" value="{{ $plan->reg_fee }}" class="form-control rounded-pill mb-3" id="lastnameInput" placeholder="Enter registration fee ">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Operation Mode (Payment)</label>
                                <select class="form-select rounded-pill mb-3 changeMode" required name="mode" aria-label="Default select example">
                                    <option value="" >Choose Mode</option>
                                    <option value="Anytime"  {{ $plan->mode == "Anytime" ? 'selected' : '' }}>Anytime</option>
                                    <option value="Weekly"  {{ $plan->mode == "Weekly" ? 'selected' : '' }}>Weekly</option>
                                    <option value="Monthly"  {{ $plan->mode == "Monthly" ? 'selected' : '' }}>Monthly</option>
                                </select>
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6 duesDiv" style="display: none">
                            <div class="mb-3">
                                <label for="contactnumberInput" class="form-label duesLabel">Dues</label>
                                <input type="number" class="form-control dueInput rounded-pill mb-3" value="{{ $plan->dues }}" name="dues" placeholder="Enter dues">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="phonenumberInput" class="form-label">Minimum Month For Loan Request</label>
                                <input type="number" class="form-control rounded-pill mb-3" value="{{ $plan->month }}" required name="month" placeholder="Enter number of month(s) a member must have joined before loan application">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="emailidInput" class="form-label">Loan Application Form Amount</label>
                                <input type="number" class="form-control rounded-pill mb-3" value="{{ $plan->loan_form_amount }}" required name="loan_form_amount" placeholder="Enter amount for loan form">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="contactnumberInput" class="form-label">Min Loan Request</label>
                                <input type="number"  class="form-control rounded-pill mb-3" value="{{ $plan->min_loan_range }}" required name="min_loan_range" placeholder="member savings times inputed value">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="phonenumberInput" class="form-label">Max Loan Request</label>
                                <input type="number" class="form-control rounded-pill mb-3" value="{{ $plan->max_loan_range }}" required name="max_loan_range" placeholder="member savings times inputed value">
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="lastnameInput" class="form-label">Loan Repayment Duration (Months)</label>
                                <input type="number" name="loan_month_repayment" required value="{{ $plan->loan_month_repayment }}" class="form-control rounded-pill mb-3" id="lastnameInput" placeholder="Enter number of month(s) for repayment">
                            </div>
                        </div><!--end col-->            
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="emailidInput" class="form-label">Loan Defaulter Charge</label>
                                <input type="number" class="form-control rounded-pill mb-3" value="{{ $plan->default_charge }}" required name="default_charge" placeholder="Enter amount for defaulters">
                            </div>
                        </div><!--end col-->
                        
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                <textarea class="form-control" name="note" required rows="3" placeholder="Enter plan description">{{ $plan->note }}</textarea>
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button"
                                        class="btn btn-link link-success text-decoration-none fw-medium"
                                        data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i>
                                        Close</button>
                                <button type="submit" class="btn btn-primary"><i class="ri-save-3-line align-bottom me-1"></i> Save</button>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </form>
            </div><!--end row-->
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
        $('body').on('click', '.edit-plan', function() {
            var id = $(this).data('id');
            $.get('{{ route('admin.plan.details') }}?id=' + id, function(data) {
                // alert('hhgf');
                $('.planId').val(id);
                $('.planName').val(data.name);
                $('.regFee').val(data.reg_fee);
                $('.planHeader').html(data.name);
                $('.repaymentMonth').val(data.loan_month_repayment);
                $('.weeklyDues').val(data.monthly_dues);
                $('.planCharge').val(data.monthly_charge);
                $('.planDefaulter').val(data.default_charge);
                $('.planReferrer').val(data.referrer_no);
                $('.planMin').val(data.min_loan_range);
                $('.planMax').val(data.max_loan_range);
                $('.planForm').val(data.form_amount);
                $('.planNote').html(data.note);
            })
        });

        $("#specifyCoop").on('submit', async function(e) {
            e.preventDefault();
            $(".preloader").show()
            const serializedData = $("#specifyCoop").serializeArray();
            try {
                    const postRequest = await request("/admin/plan/create",
                    processFormInputs(
                        serializedData), 'post');
                    // console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    $('#specifyCoop').trigger("reset");
                    $("#specifyCoop .close").click();
                    window.location.reload();
            } catch (e) {
                $(".preloader").hide()
                if ('message' in e) {
                    // console.log('e.message', e.message);
                    new swal("Opss", e.message, "error");
                    
                }
            }
        })
        $("#planUpdate").on('submit', async function(e) {
            e.preventDefault();
            $(".preloader").show()
            const serializedData = $("#planUpdate").serializeArray();
            try {
                    const postRequest = await request("/admin/plan/create",
                    processFormInputs(
                        serializedData), 'post');
                    // console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    $('#planUpdate').trigger("reset");
                    $("#planUpdate .close").click();
                    window.location.reload();
            } catch (e) {
                $(".preloader").hide()
                if ('message' in e) {
                    // console.log('e.message', e.message);
                    new swal("Opss", e.message, "error");
                    
                }
            }
        })

       

        /* When click delete button */
        $('body').on('click', '#deleteRecord', function() {
            var user_id = $(this).data('id');
            // alert(user_id)
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert(user_id);
            resetAccount(el, user_id);
        });

        async function resetAccount(el, user_id) {
            const willUpdate = await new swal({
                title: "Confirm Delete",
                text: `Are you sure you want to delete this record?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Delete"]
            });
            // console.log(willUpdate);
            if (willUpdate) {
                //performReset()
                performDelete(el, user_id);
            } else {
                new swal("User record will not be deleted  :)");
            }
        }

        function performDelete(el, user_id) {
            //alert(user_id);
            try {
                $.get('{{ route('delete_users') }}?id=' + user_id,
                    function(data, status) {
                        if (data.status === "error") {
                            new swal("Opss", data.message, "error");
                        } else {
                            if (status === "success") {
                                let alert = new swal(" record successfully deleted!.");
                                $(el).closest("tr").remove();
                                window.location.reload();
                                // alert.then(() => {
                                // });
                            }
                        }

                    }
                );
            } catch (e) {
                let alert = new swal(e.message);
            }
        }
        //onchange of coop mode
        $('.changeMode').on('change', function() {
            var mode = $(this).val();
            if (mode == "" || mode == "Anytime") {
                // Checkbox is checked
                $('.duesDiv').hide();
                $('.dueInput').removeAttr('required');
            } else {
                $('.dueInput').attr('required', true);
                $('.duesDiv').show();
                $('.duesLabel').html(mode + " Payment");
                // Checkbox is unchecked
            }
        });

    })
</script>
@endsection