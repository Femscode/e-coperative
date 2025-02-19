@extends('dashboard.master')
@section('header')

@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="col-12 mb-4">
        <div class="nav-tabs-custom">
            <div class="d-flex w-100 overflow-hidden">
                <a href="/admin/application" class="nav-link flex-fill text-center py-3 active">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="ri-time-line fs-22 me-2"></i>
                        <h5 class="mb-0">Pending</h5>
                    </div>
                </a>
                <a href="/admin/application/awaiting-disbursement" class="nav-link flex-fill text-center py-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="ri-timer-line fs-22 me-2"></i>
                        <h5 class="mb-0">Awaiting</h5>
                    </div>
                </a>
                <a href="/admin/application/ongoing" class="nav-link flex-fill text-center py-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="ri-loader-2-line fs-22 me-2"></i>
                        <h5 class="mb-0">Ongoing</h5>
                    </div>
                </a>
                <a href="/admin/application/completed" class="nav-link flex-fill text-center py-3 ">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="ri-checkbox-circle-line fs-22 me-2"></i>
                        <h5 class="mb-0">Completed</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    @livewire('loan')


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
                                                data-min="{{ auth()->user()->plan()->min_loan_range ?? '' }}"
                                                data-max="{{ auth()->user()->plan()->max_loan_range ?? '' }}"
                                                data-refund="{{ auth()->user()->plan()->loan_month_repayment ?? '' }}"
                                                min="{{ auth()->user()->plan()->min_loan_range ?? '' }}"
                                                max="{{ auth()->user()->plan()->max_loan_range ?? '' }}"
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
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* When click approve button */
        $('body').on('click', '.approveButton', function() {
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert("here")
            resetAccount(el, id);
        });
        async function resetAccount(el, id) {
            const willUpdate = await new swal({
                title: "Confirm User Action",
                text: `Are you sure you want to approve this Application?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Approve"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performDelete(el, id);
            } else {
                new swal("Opss", "Application will not be approved", "error");
            }
        }

        function performDelete(el, id) {
            $('.preloader').show();
            try {
                $.get("{{ route('admin.approve.loan.application') }}?id=" + id,
                    function(data, status) {
                        if (status === "success") {
                            let alert = new swal("Good Job", data.message, "success");
                            window.location.reload()
                        }
                    }
                );
            } catch (e) {
                $('.preloader').hide();
                let alert = new swal("Opss", e.message, "error");
            }
        }
        /* When click disburse button */
        $('body').on('click', '.disburseButton', function() {
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert("here")
            notifyUser(el, id);
        });
        async function notifyUser(el, id) {
            const willUpdate = await new swal({
                title: "Confirm User Action",
                text: `Are you sure you want to disburse to this Application?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Disburse"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performDisburse(el, id);
            } else {
                new swal("Opss", "Disbursement Cancelled", "error");
            }
        }

        function performDisburse(el, id) {
            $('.preloader').show();
            try {
                $.get("{{ route('admin.disburse.loan.application') }}?id=" + id,
                    function(data, status) {
                        // console.log(data)
                        if (data.status == "error") {
                            return new swal("Oops", data.message, "error");
                        }
                        if (status === "success") {
                            let alert = new swal("Good Job", "Disbursement Successfully!", "success");
                            window.location.reload()
                        }
                    }
                );
            } catch (e) {
                $('.preloader').hide();
                let alert = new swal("Opss", e.message, "error");
            }
        }
    })
</script>

@endsection