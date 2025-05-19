@extends('cooperative.admin.master')
@section('header')
<style>
    .visibility-option {
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .visibility-option:hover {
        background-color: #f8f9fa;
        border-color: #094168 !important;
    }

    .visibility-option .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0.5em;
    }

    .visibility-option .form-check-input:checked {
        background-color: #094168;
        border-color: #094168;
    }

    .visibility-option:has(.form-check-input:checked) {
        border-color: #094168 !important;
        background-color: rgba(9, 65, 104, 0.05);
    }

    .visibility-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(9, 65, 104, 0.1);
    }
</style>
<style>
    .settings-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0.2rem;
    }

    .settings-header {
        padding: 2rem 0;
    }

    .settings-header .header-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto;
        background: linear-gradient(45deg, #094168, #1e6491);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .settings-header .header-icon i {
        font-size: 32px;
        color: white;
    }

    .settings-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(9, 65, 104, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .settings-card:hover {
        box-shadow: 0 4px 20px rgba(9, 65, 104, 0.12);
    }

    .settings-card-header {
        padding: 1.5rem;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-bottom: 1px solid rgba(9, 65, 104, 0.08);
    }

    .settings-card-header i {
        font-size: 24px;
    }

    .settings-card-header h5 {
        margin: 0;
        font-weight: 600;
        color: #094168;
    }

    .settings-card-body {
        padding: 1.5rem;
    }

    .form-floating {
        margin-bottom: 0;
    }

    .form-control,
    .form-select {
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        height: auto;
        font-size: 1rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #094168;
        box-shadow: 0 0 0 4px rgba(9, 65, 104, 0.1);
    }

    .form-floating>label {
        padding: 0.75rem 1rem;
        color: #526579;
    }

    .btn-lg {
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        border-radius: 8px;
    }

    .btn-primary {
        background: #094168;
        border-color: #094168;
    }

    .btn-primary:hover {
        background: #073553;
        border-color: #073553;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">


    <!-- end page title -->
    <div class="settings-container">
        <div class="settings-header text-center mb-4">
            <div class="header-icon mb-3">
                <i class="ri-settings-4-line"></i>
            </div>
            <h2 class="mb-1">Cooperative Settings</h2>
            <p class="text-muted">Configure your cooperative's operational parameters</p>
        </div>

        <form id="specifyCoop" method="post">
            @csrf
            <!-- Basic Settings Section -->
            <div class="settings-card mb-4">
                <div class="settings-card-header">
                    <i class="ri-money-dollar-circle-line text-primary"></i>
                    <h5>Basic Fee Structure</h5>
                </div>
                <div class="settings-card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" required name="reg_fee" value="{{ $plan->reg_fee }}" class="form-control" id="regFeeInput" placeholder="Enter registration fee">
                                <label for="regFeeInput">Registration Fee</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select changeMode" required name="mode" id="operationMode">
                                    <option value="">Select Mode</option>
                                    <option value="Anytime" {{ $plan->mode == "Anytime" ? 'selected' : '' }}>Anytime</option>
                                    <option value="Weekly" {{ $plan->mode == "Weekly" ? 'selected' : '' }}>Weekly</option>
                                    <option value="Monthly" {{ $plan->mode == "Monthly" ? 'selected' : '' }}>Monthly</option>
                                </select>
                                <label for="operationMode">Operation Mode</label>
                            </div>
                        </div>
                        <div class="col-md-6 duesDiv" style="display: none">
                            <div class="form-floating">
                                <input type="number" class="form-control dueInput" value="{{ $plan->dues }}" name="dues" id="duesInput" placeholder="Enter dues">
                                <label for="duesInput" class="duesLabel">Dues Amount</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Configuration Section -->
            <div class="settings-card mb-4">
                <div class="settings-card-header">
                    <i class="ri-bank-card-line text-success"></i>
                    <h5>Loan Configuration</h5>
                </div>
                <div class="settings-card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" value="{{ $plan->month }}" required name="month" id="minMonthInput" placeholder="Enter minimum months">
                                <label for="minMonthInput">Minimum Months Before Loan</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" value="{{ $plan->loan_form_amount }}" required name="loan_form_amount" id="formAmountInput" placeholder="Enter form amount">
                                <label for="formAmountInput">Application Form Fee</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" value="{{ $plan->min_loan_range }}" required name="min_loan_range" id="minLoanInput" placeholder="Enter minimum loan">
                                <label for="minLoanInput">Minimum Loan Multiplier</label>
                                <small class="text-muted mt-1 d-block">
                                    <i class="ri-information-line me-1"></i>
                                    This is a multiplier of member's savings. E.g., if set to 2 and member has ₦5,000 savings, they can request up to ₦10,000 (2×)
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" value="{{ $plan->max_loan_range }}" required name="max_loan_range" id="maxLoanInput" placeholder="Enter maximum loan">
                                <label for="maxLoanInput">Maximum Loan Multiplier</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Repayment Settings Section -->
            <div class="settings-card mb-4">
                <div class="settings-card-header">
                    <i class="ri-calendar-check-line text-warning"></i>
                    <h5>Repayment Settings</h5>
                </div>
                <div class="settings-card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" name="loan_month_repayment" required value="{{ $plan->loan_month_repayment }}" class="form-control" id="repaymentDurationInput" placeholder="Enter duration">
                                <label for="repaymentDurationInput">Repayment Duration (Months)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" class="form-control" value="{{ $plan->interest }}" required name="interest" id="interest" placeholder="Enter interest in percentage">
                                <label for="defaultChargeInput">Interest(%)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" class="form-control" value="{{ $plan->default_charge }}" required name="default_charge" id="defaultChargeInput" placeholder="Enter charge amount">
                                <label for="defaultChargeInput">Default Penalty Charge</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="settings-card mb-4">
                <div class="settings-card-header">
                    <i class="ri-file-text-line text-info"></i>
                    <h5>Additional Information</h5>
                </div>
                <div class="settings-card-body">


                    <div class="form-floating">
                        <textarea class="form-control" name="description" required rows="3" id="noteInput" style="height: 100px" placeholder="Enter description">{{ $plan->description }}</textarea>
                        <label for="noteInput">Plan Description</label>
                    </div>

                    <div class="form-floating mb-4">
                        <div class="visibility-options p-3">
                            <label class="form-label fw-bold mb-3">Cooperative Visibility</label>
                            <div class="d-flex flex-column gap-3">
                                <div class="form-check visibility-option p-3 border rounded-3">
                                    <input class="form-check-input" type="radio" name="visibility" id="publicVisibility" value="public" {{ $plan->visibility == 'public' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center gap-3" for="publicVisibility">
                                        <!-- <span class="visibility-icon">
                                            <i class="ri-global-line text-success fs-3"></i>
                                        </span> -->
                                        <div>
                                            <span class="d-block fw-semibold fs-5 mb-1">Open Membership</span>
                                            <small class="text-muted">Allow instant registration for all new members. No approval required.</small>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-check visibility-option p-3 border rounded-3">
                                    <input class="form-check-input" type="radio" name="visibility" id="privateVisibility" value="private" {{ $plan->visibility == 'private' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center gap-3" for="privateVisibility">
                                        <!-- <span class="visibility-icon">
                                            <i class="ri-shield-check-line text-danger fs-3"></i>
                                        </span> -->
                                        <div>
                                            <span class="d-block fw-semibold fs-5 mb-1">Restricted Access</span>
                                            <small class="text-muted">Members can only join through invitation links. Admin approval required.</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-light btn-lg px-4" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary btn-lg px-4">
                    <i class="ri-save-3-line me-1"></i> Save Changes
                </button>
            </div>
        </form>
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
            $.get("{{ route('admin.plan.details') }}?id=" + id,
                function(data) {
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

        function processFormInputs(formInputs) {
            const data = {};
            formInputs.forEach(input => {
                data[input.name] = input.value;
            });
            return data;
        }

        $("#specifyCoop").on('submit', async function(e) {
            e.preventDefault();
            $(".preloader").show()
            const serializedData = $("#specifyCoop").serializeArray();
            try {
                const postRequest = await $.ajax({
                    url: "/admin/plan/create",
                    type: 'POST',
                    data: processFormInputs(serializedData),
                    dataType: 'json'
                });
                // const postRequest = await request("/admin/plan/create",
                //     processFormInputs(
                //         serializedData), 'post');
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
                $.get("{{ route('delete_users') }}?id=" + user_id,
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