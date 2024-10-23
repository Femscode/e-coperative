@extends('dashboard.master')
@section('header')

@endsection

@section('content')

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Plans</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                        <li class="breadcrumb-item active">Plans</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="card">
        <div class="card-header border-0 rounded">
            <div class="row g-2">
                <div class="col-xl-3">
                    <div class="search-box">  
                        <input type="text" class="form-control search" placeholder="Search for sellers & owner name or something...">  <i class="ri-search-line search-icon"></i>  
                    </div>
                </div><!--end col-->
                <div class="col-xl-2 ms-auto">
                    <div>
                        <select class="form-control" data-choices data-choices-search-false>
                            <option value="">Select Categories</option>
                            <option value="All">All</option>
                            <option value="Retailer">Retailer</option>
                            <option value="Health & Medicine">Health & Medicine</option>
                            <option value="Manufacturer">Manufacturer</option>
                            <option value="Food Service">Food Service</option>
                            <option value="Computers & Electronics">Computers & Electronics</option>
                        </select>
                    </div>
                </div><!--end col-->
                <div class="col-lg-auto">
                    <div class="hstack gap-2">
                        <button type="button" class="btn btn-danger"><i class="ri-equalizer-fill me-1 align-bottom"></i> Filters</button>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSeller"><i class="ri-add-fill me-1 align-bottom"></i> Add Plan</button>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($plans as $plan)
            <div class="col-xl-3 col-lg-6">
                <div class="card ribbon-box right overflow-hidden">
                    <div class="card-body text-center p-4">
                        <div class="ribbon ribbon-info ribbon-shape trending-ribbon"><i class="ri-flashlight-fill text-white align-bottom"></i> <span class="trending-ribbon-text">Trending</span></div>
                        <img src="{{ asset('assets/images/companies/img-1.png ')}}" alt="" height="45">
                        <h5 class="mb-1 mt-4"><a href="apps-ecommerce-seller-details.html" class="link-primary">{{ $plan->name }}</a></h5>
                        <p class="text-muted mb-4"></p>
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div id="chart-seller1" data-colors='["--vz-danger"]'></div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-6 border-end-dashed border-end">
                                <h5>&#x20A6;{{ $plan->monthly_dues }}</h5>
                                <span class="text-muted">Weekly Dues</span>
                            </div>
                            <div class="col-lg-6">
                                <h5>&#x20A6;{{ $plan->monthly_charge }}</h5>
                                <span class="text-muted">Monthly Charge</span>
                            </div>
                        </div>
                    <div class="mt-4">
                            <a data-bs-toggle="modal" data-id="{{ $plan->id }}" data-bs-target="#editSeller" class="btn btn-light w-100 edit-plan">View Details</a>
                    </div>
                    </div>
                </div>
            </div><!--end col-->
        @endforeach
    </div><!--end row-->

    <!-- Modal -->
    <div class="modal fade zoomIn" id="addSeller" tabindex="-1" aria-labelledby="addSellerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSellerLabel">Add Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-content border-0 mt-3">
                    <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                Specify Plan Details 
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form id="planForm" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Plan Name</label>
                                            <input type="text" name="name" class="form-control" id="" placeholder="Enter plan ame">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">Plan registration Fee</label>
                                            <input type="number" name="reg_fee" class="form-control" id="lastnameInput" placeholder="Enter plan registration fee">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">Repayment Month</label>
                                            <input type="number" name="loan_month_repayment" class="form-control" id="lastnameInput" placeholder="Enter number of month to payback">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="contactnumberInput" class="form-label">Plan Weekly Dues</label>
                                            <input type="number" class="form-control" name="monthly_dues" placeholder="Enter plan weekly dues">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Plan Monthly Charge</label>
                                            <input type="number" class="form-control" name="monthly_charge" placeholder="Enter monthly charge">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Plan Loan Application Referrer</label>
                                            <input type="number" class="form-control" name="referrer_no" placeholder="Enter number of referrer for loan application eligibility">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="contactnumberInput" class="form-label">Min Loan Application</label>
                                            <input type="number" class="form-control" name="min_loan_range" placeholder="Enter plan minimum loan application">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Max Loan Application</label>
                                            <input type="number" class="form-control" name="max_loan_range" placeholder="Enter plan maximum loan application">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Defaulter Loan Charge</label>
                                            <input type="number" class="form-control" name="default_charge" placeholder="Enter amount for defaulters">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Form Loan Amount</label>
                                            <input type="number" class="form-control" name="form_amount" placeholder="Enter amount for loan form">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                            <textarea class="form-control" name="note" rows="3" placeholder="Enter plan description"></textarea>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end modal-->
    <!-- Modal -->
    <div class="modal fade zoomIn" id="editSeller" tabindex="-1" aria-labelledby="addSellerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title planHeader" id="addSellerLabel" >Add Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-content border-0 mt-3">
                    <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                Specify Plan Details 
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form id="planUpdate" method="post">
                                @csrf
                                <input type="hidden" name="id" class="planId">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Plan Name</label>
                                            <input type="text" name="name" class="form-control planName" id="" placeholder="Enter plan ame">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">Plan registration Fee</label>
                                            <input type="number" name="reg_fee" class="form-control regFee" id="lastnameInput" placeholder="Enter plan registration fee">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="lastnameInput" class="form-label">Repayment Month</label>
                                            <input type="number" name="loan_month_repayment" class="form-control repaymentMonth" id="lastnameInput" placeholder="Enter number of month to payback">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="contactnumberInput" class="form-label">Plan Weekly Dues</label>
                                            <input type="number" class="form-control weeklyDues" name="monthly_dues" placeholder="Enter plan weekly dues">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Plan Monthly Charge</label>
                                            <input type="number" class="form-control planCharge" name="monthly_charge" placeholder="Enter monthly charge">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Plan Loan Application Referrer</label>
                                            <input type="number" class="form-control planReferrer" name="referrer_no" placeholder="Enter number of referrer for loan application eligibility">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="contactnumberInput" class="form-label">Min Loan Application</label>
                                            <input type="number" class="form-control planMin" name="min_loan_range" placeholder="Enter plan minimum loan application">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Max Loan Application</label>
                                            <input type="number" class="form-control planMax" name="max_loan_range" placeholder="Enter plan maximum loan application">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Defaulter Loan Charge</label>
                                            <input type="number" class="form-control planDefaulter" name="default_charge" placeholder="Enter amount for defaulters">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="emailidInput" class="form-label">Form Loan Amount</label>
                                            <input type="number" class="form-control planForm" name="form_amount" placeholder="Enter amount for loan form">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                            <textarea class="form-control planNote" name="note" rows="3" placeholder="Enter plan description"></textarea>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end modal-->

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

        $("#planForm").on('submit', async function(e) {
            e.preventDefault();
            $(".preloader").show()
            const serializedData = $("#planForm").serializeArray();
            try {
                    const postRequest = await request("/admin/plan/create",
                    processFormInputs(
                        serializedData), 'post');
                    // console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    $('#planForm').trigger("reset");
                    $("#planForm .close").click();
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

    })
</script>
@endsection