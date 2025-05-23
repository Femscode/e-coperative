@extends('cooperative.admin.master')
@section('header')

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
    .bg-gradient-primary {
        background: linear-gradient(45deg, #094168, black);
    }

    .modal-content {
        border-radius: 15px;
    }

    .form-floating {
        position: relative;
    }

    .form-floating>.form-control,
    .form-floating>.form-select {
        height: 60px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1.25rem 1rem;
    }

    .form-floating>label {
        padding: 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #094168;
        box-shadow: 0 0 0 0.25rem rgba(9, 65, 104, 0.1);
    }

    .btn-light-subtle {
        background-color: #f8f9fa;
        border: 2px solid #e9ecef;
    }

    .btn-light-subtle:hover {
        background-color: #e9ecef;
    }

    .btn-primary {
        background: linear-gradient(45deg, #094168, black);
        border: none;

    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #073553, black);
    }
</style>

@endsection

@section('content')


<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Groups</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active">Groups</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-sm-4">
                    <div>
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                            data-bs-target="#addUser"><i class="ri-add-line align-bottom me-1"></i> Add Group</button>
                    </div>
                </div><!--end col-->
                {{-- <div class="col-sm-auto ms-auto">
                        <div class="list-grid-nav hstack gap-1">
                            <a class='btn btn-secondary' href='download_member_template'>Download Template</a>
    
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#showModal"><i
                                    class="ri-add-fill me-1 align-bottom"></i> Upload Members</button>
                        </div>
                    </div><!--end col--> --}}
            </div><!--end row-->
        </div>
    </div>
    <!-- end page title -->
    @livewire('list-groups')
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form method="Post" id="frm_main">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="idUser">
                        <div class="mb-3" id="modal-id" style="display: none;">
                            <label for="id-field" class="form-label">ID</label>
                            <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="nameDetail" class="form-control" placeholder="Enter Name" name="name" required />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="emailDetail" class="form-control" placeholder="Enter Email" name="email" required />
                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="edit-btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- add contribution group --}}
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-gradient-primary p-4">
                    <h5 class="modal-title text-white fs-4">Create New Group</h5>
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
                            <div class="col-lg-6">
                                <div class="form-floating">
                                    <div class="turn-type-selection">
                                        <label class="form-label mb-2">Group Turn Type</label>
                                        <div class="d-flex gap-4">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="linearTurn" 
                                                    name="turn_type" value="linear" checked required>
                                                <label class="form-check-label" for="linearTurn">
                                                    <i class="ri-list-ordered me-1"></i>Linear Order
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="randomTurn" 
                                                    name="turn_type" value="random" required>
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

    {{-- Add New Member  --}}
    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form method="Post" action="{{route('create_user')}}">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3" id="modal-id" style="display: none;">
                            <label for="id-field" class="form-label">ID</label>
                            <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter Name" name="name" required />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="Enter Email" name="email" required />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Enter Password" name="password" required />
                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="update-btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">

</div> --}}
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
            var link = $(this).data("link");
            navigator.clipboard.writeText(link).then(() => {
                showCustomAlert({
                    toast: true,
                    position: 'top',
                    icon: 'success',
                    title: 'Link copied!',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'colored-toast'
                    }
                });

            }).catch(err => {
                console.error("Failed to copy: ", err);
            });
        });

        function processFormInputs(formInputs) {
            const data = {};
            formInputs.forEach(input => {
                data[input.name] = input.value;
            });
            return data;
        }
        // save contribution group
        $("#importMemberForm").on('submit', async function(e) {

            e.preventDefault();
            $(".preloader").show()
            const serializedData = $("#importMemberForm").serializeArray();
            try {
              

                const postRequest = await $.ajax({
                    url: "/admin/group/create",
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
        $('body').on('click', '.edit-user', function() {
            var id = $(this).data('id');
            $.get("{{ route('user_details') }}?id=" + id, function(data) {
                // alert('hhgf');
                $('#idUser').val(data.id);
                $('#emailDetail').val(data.email);
                $('#nameDetail').val(data.name);
            })
        });

        $("#frm_main").on('submit', async function(e) {
            e.preventDefault();
            const serializedData = $("#frm_main").serializeArray();

            try {

                const willUpdate = await new swal({
                    title: "Confirm Action",
                    text: `Are you sure you want to submit?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Submit"]
                });
                // console.log(willUpdate);
                if (willUpdate) {
                    //performReset()
                    const postRequest = await request("/admin/user/update",
                        processFormInputs(
                            serializedData), 'post');
                    console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    $('#frm_main').trigger("reset");
                    $("#frm_main .close").click();
                    window.location.reload();
                } else {
                    new swal("Process aborted  :)");
                }

            } catch (e) {
                if ('message' in e) {
                    console.log('e.message', e.message);
                    new swal("Opss", e.message, "error");

                }
            }
        })


        /* When click approve button */
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
            } 
        }

        function performStart(el, id) {
            $('.approveButton').prop('disabled', true).text('Loading ...');
            try {
                // alert(data);
                $.get("{{ route("start-contribution") }}?id=" + id,
                    function(data, status) {
                        // console.log(data, status);
                        //    alert(data.message)
                        if (data.status == "ok") {
                            let alert = new swal("Good Job", data.message, "success");
                            window.location.href = "{{ route('admin_group_home') }}";
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