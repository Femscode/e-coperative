@extends('ajo.member.master')

@section('main')
<style>
    .turn-type-selection {
        padding: 0.75rem;
    }

    .turn-type-selection .form-check {
        padding: 0.5rem 1rem;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .turn-type-selection .form-check:hover {
        background: #f8f9fa;
    }

    .turn-type-selection .form-check-input:checked + .form-check-label {
        color: #094168;
    }

    .turn-type-selection .form-check-input:checked ~ .form-check {
        border-color: #094168;
        background: rgba(9, 65, 104, 0.05);
    }

    .modal-content {
        border-radius: 1rem;
        overflow: hidden;
    }

    .form-control {
        border-radius: 0.5rem;
        border: 1px solid #e0e0e0;
        padding: 0.75rem 1rem;
    }

    .form-control:focus {
        border-color: #094168;
        box-shadow: 0 0 0 0.2rem rgba(9, 65, 104, 0.1);
    }

    .btn-primary {
        background: #094168;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #073251;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
    }
</style>

<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-primary p-4">
                <h5 class="modal-title text-dark fs-4">Create New Group</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" id="importMemberForm" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter group title" required>
                                <label for="title">Group Title</label>
                                <div class="invalid-feedback">Please enter a group title.</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <select class="form-select form-control changeMode" name="mode" required>
                                    <option value="" disabled selected>Select contribution mode</option>
                                    <option value="Daily">Daily</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Monthly">Monthly</option>
                                </select>
                                <label>Contribution Mode</label>
                                <div class="invalid-feedback">Please select a contribution mode.</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" class="form-control loanAmount amount" name="amount" placeholder="Enter amount" required>
                                <label>Contribution Amount (₦)</label>
                                <div class="invalid-feedback">Please enter a valid amount.</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="min" min="2" placeholder="Enter minimum participants" required>
                                <label>Minimum Participants</label>
                                <div class="invalid-feedback">Please enter a valid number (minimum 2).</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="max" min="2" placeholder="Enter maximum participants" required>
                                <label>Maximum Participants</label>
                                <div class="invalid-feedback">Please enter a valid number (minimum 2).</div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <div class="turn-type-selection">
                                    <label class="form-label mb-2">Group Turn Type</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="linearTurn" name="turn_type" value="linear" checked required>
                                            <label class="form-check-label" for="linearTurn">
                                                <i class="ri-list-ordered me-1"></i>Linear Order
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="randomTurn" name="turn_type" value="random" required>
                                            <label class="form-check-label" for="randomTurn">
                                                <i class="ri-shuffle-line me-1"></i>Random Order
                                            </label>
                                        </div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        Linear: Members get turns in order of joining<br>
                                        Random: Turns are assigned randomly
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light-subtle px-4 py-2 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill" id="update-btn">
                        <i class="ri-save-line me-1"></i>Create Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container-fluid py-4">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div class="mb-3 mb-md-0">
                <h3 class="fw-bold mb-1">My Contribution Circle</h3>
            </div>
            <div>
                <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addUser">
                    <i class="bi bi-plus-circle me-2"></i>New Contribution
                </button>
            </div>
        </div>

        @livewire('member-contribution-livewire')
    </div>
</main>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle Session Messages
        @if(Session::has('message'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get("message") }}'
        });
        @endif
        @if(Session::has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ Session::get("error") }}'
        });
        @endif

        // Define processFormInputs function
        function processFormInputs(serializedData) {
            const formData = {};
            $.each(serializedData, function(index, field) {
                formData[field.name] = field.value;
            });
            return formData;
        }

        // Form Validation and Submission
        $("#importMemberForm").on('submit', function(e) {
            e.preventDefault();

            // Bootstrap form validation
            const form = this;
            if (form.checkValidity() === false) {
                e.stopPropagation();
                form.classList.add('was-validated');
                return;
            }

            $(".preloader").show();

            const serializedData = $(form).serializeArray();
            const formData = processFormInputs(serializedData);

            $.ajax({
                url: '/member/contribution/create',
                type: 'POST',
                data: formData,
                dataType: 'json'
            })
            .done(function(response) {
                $(".preloader").hide();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {
                    $('#importMemberForm').trigger('reset');
                    $('#addUser').modal('hide');
                    window.location.reload();
                });
            })
            .fail(function(xhr) {
                $(".preloader").hide();
                const errorMsg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMsg
                });
            });
        });

        // Format Contribution Amount Input
        $(".loanAmount").on('keypress', function(e) {
            const charCode = e.which ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
        }).on('keyup', function() {
            let value = $(this).val().replace(/\D/g, '');
            const n = parseInt(value, 10);
            if (isNaN(n)) {
                $(this).val('');
            } else {
                $(this).val(n.toLocaleString());
            }
        });

        // Copy Link Functionality
        $(".copy-btn").on('click', function() {
            const link = $(this).data("link");
            navigator.clipboard.writeText(link)
                .then(() => {
                    Swal.fire({
 
                        icon: 'success',
                        title: 'Link Copied',
                        text: 'Link copied: ' + link
                    });
                })
                .catch(err => {
                    console.error("Failed to copy: ", err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to copy link.'
                    });
                });
        });

        // Approve Button Functionality
        $('body').on('click', '.approveButton', function() {
            const id = $(this).data('id');
            const el = this;
            startAccount(el, id);
        });

        async function startAccount(el, id) {
            const willUpdate = await Swal.fire({
                title: "Confirm User Action",
                text: "Are you sure you want to start this contribution?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Am In!",
                cancelButtonText: "Cancel"
            });

            if (willUpdate.isConfirmed) {
                performStart(el, id);
            }
        }

        function performStart(el, id) {
            $(el).prop('disabled', true).text('Loading ...');
            $.get("{{ route('member-start-contribution') }}?id=" + id)
                .done(function(data) {
                    if (data.status === "ok") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        $(el).prop('disabled', false).text('Start');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    }
                })
                .fail(function(xhr) {
                    $(el).prop('disabled', false).text('Start');
                    const errorMsg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg
                    });
                });
        }

        // Delete Record Functionality
        $('body').on('click', '#deleteRecord', function() {
            const user_id = $(this).data('id');
            const el = this;
            resetAccount(el, user_id);
        });

        async function resetAccount(el, user_id) {
            const willUpdate = await Swal.fire({
                title: "Confirm Delete",
                text: "Are you sure you want to delete this record?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete",
                cancelButtonText: "Cancel"
            });

            if (willUpdate.isConfirmed) {
                performDelete(el, user_id);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Cancelled',
                    text: 'User record will not be deleted.'
                });
            }
        }

        function performDelete(el, user_id) {
            $.get("{{ route('delete_users') }}?id=" + user_id)
                .done(function(data, status) {
                    if (data.status === "error") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Record successfully deleted!'
                        }).then(() => {
                            $(el).closest("tr").remove();
                            window.location.reload();
                        });
                    }
                })
                .fail(function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg
                    });
                });
        }
    });
</script>
@endsection