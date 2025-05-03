@extends('ajo.member.master')

@section('main')
<!-- Payment Modal -->

<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 bg-gradient-primary p-4">
                <h5 class="modal-title text-dark fs-4">Create New Group</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="Post" id="importMemberForm" class="needs-validation" novalidate>
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter group title" required>
                                <label for="title">Group Title</label>
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
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="text" class="form-control loanAmount amount" name="amount"
                                    placeholder="Enter amount" required>
                                <label>Contribution Amount (₦)</label>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="min" min="2"
                                    placeholder="Enter minimum participants" required>
                                <label>Minimum Participants</label>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="max" min="2"
                                    placeholder="Enter maximum participants" required>
                                <label>Maximum Participants</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light-subtle px-4 py-2 rounded-pill" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill" id="update-btn">
                        <i class="ri-save-line me-1"></i> Create Group
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div class="mb-3 mb-md-0">
                <h3 class="fw-bold mb-1">My Contribution Circle</h3>
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-house-door small"></i>
                                <span class="ms-2">Contribution</span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Circle</li>
                    </ol>
                </nav> -->
            </div>
            <div>
                <button class="btn btn-primary add-btn"  data-bs-toggle="modal" data-bs-target="#addUser" >
                    <i class="bi bi-plus-circle me-2"></i>
                    New Contribution
                </button>
            </div>
        </div>

        @livewire('member-contribution-livewire')
    </div>
</main>

<style>
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

    .input-group-text {
        background: transparent;
        border-left: 0;
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

    .breadcrumb-item+.breadcrumb-item::before {
        content: "•";
    }

    .breadcrumb-item a {
        color: #6c757d;
    }

    .breadcrumb-item.active {
        color: #094168;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
    }
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if(Session::has('message'))
        showCustomAlert({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get('
            message ') }}'
        });
        @endif
        @if(Session::has('error'))
        showCustomAlert({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get('
            error ') }}'
        });
        @endif
        var preLoader = $(".preloader")
        //copy link
        $(".copy-btn").click(function() {
            // Get the link from the data attribute of the clicked button
            var link = $(this).data("link");

            // Copy the link to the clipboard
            navigator.clipboard.writeText(link).then(() => {
                alert("Link copied: " + link);
            }).catch(err => {
                console.error("Failed to copy: ", err);
            });
        });
        // save contribution group
        $("#importMemberForm").on('submit', async function(e) {
            e.preventDefault();
            $(".preloader").show()
            const serializedData = $("#importMemberForm").serializeArray();
            try {
                const postRequest = await $.ajax({
                    url: "/member/contribution/create",
                    type: 'POST',
                    data: processFormInputs(serializedData),
                    dataType: 'json'
                });
                // console.log('postRequest.message', postRequest.message);
                new swal("Good Job", postRequest.message, "success");
                $('#importMemberForm').trigger("reset");
                $("#importMemberForm .close").click();
                window.location.reload();
            } catch (e) {
                $(".preloader").hide()
                if ('message' in e) {
                    // console.log('e.message', e.message);
                    new swal("Opss", e.message, "error");

                }
            }
        })
        //on input amount
        
      

        $('body').on('click', '.approveButton', function() {
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert("here")
            startAccount(el, id);
        });
        async function startAccount(el, id) {
            const willUpdate = await new swal({
                title: "Confirm User Action",
                text: `Are you sure you want to start this contribution?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Am In!"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performStart(el, id);
            } else {
                new swal("Opss", "Operation Terminated", "error");
            }
        }

        /* When click approve button */
    
        function performStart(el, id) {
            $('.approveButton').prop('disabled', true).text('Loading ...');
            try {
                // alert(data);
                $.get("{{ route('member-start-contribution') }}?id=" + id,
                    function(data, status) {
                        // console.log(data, status);
                        //    alert(data.message)
                        if (data.status == "ok") {
                            let alert = new swal("Good Job", data.message, "success");
                            window.location.reload();
                        } else {
                            $('.approveButton').prop('disabled', false).text('Start');
                            new swal("Opss", data.message, "error");
                        }

                    }
                );
            } catch (e) {
                $('.approveButton').prop('disabled', false).text('Start');
                // alert("here")
                let alert = new swal("Opss", e.message, "error");
            }
        }


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

    })
</script>
@endsection