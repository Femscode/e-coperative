@extends('cooperative.admin.master')
@section('header')
<style>
.action-panel {
    border: 1px solid rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.action-panel:hover {
    border-color: rgba(0,0,0,0.12);
}

.icon-box {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dropdown-menu {
    min-width: 280px;
}

.dropdown-item {
    transition: all 0.2s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    transform: translateX(4px);
}

.search-box {
    min-width: 300px;
}

.search-box .form-control:focus {
    box-shadow: none;
    border-color: #dee2e6;
}

.btn-lg {
    height: 48px;
}
 </style>

@endsection

@section('content')


<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="nav-tabs-custom">
                <div class="d-flex w-100 overflow-hidden">
                    <a href="/admin/member" class="nav-link flex-fill text-center py-3 active">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-team-line fs-22 me-2"></i>
                            <h5 class="mb-0">Members</h5>
                        </div>
                    </a>
                    <a href="/admin/user" class="nav-link flex-fill text-center py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-shield-user-line fs-22 me-2"></i>
                            <h5 class="mb-0">Admin</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="action-panel p-3 bg-white rounded-3 shadow-sm mb-4">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" id="create-btn" data-bs-target="#addUser">
                    <i class="ri-user-add-line fs-18 me-2"></i>
                    Add Member
                </button>
                
                <div class="dropdown">
                    <button class="btn btn-outline-primary d-flex align-items-center dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="ri-file-transfer-line fs-18 me-2"></i>
                        Import
                    </button>
                    <ul class="dropdown-menu p-2 border-0 shadow-sm">
                        <li>
                            <a class="dropdown-item d-flex align-items-center p-2 rounded-2" href="download_member_template">
                                <div class="icon-box bg-soft-primary rounded-2 me-3 p-2">
                                    <i class="ri-file-download-line fs-18 text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Download Template</h6>
                                    <small class="text-muted">Get the Excel template</small>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center p-2 rounded-2" href="#" data-bs-toggle="modal" data-bs-target="#showModal">
                                <div class="icon-box bg-soft-success rounded-2 me-3 p-2">
                                    <i class="ri-upload-cloud-line fs-18 text-success"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Upload Members</h6>
                                    <small class="text-muted">Import member data</small>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

                
            </div>
        </div>
        <!-- end page title -->
        @livewire('pending-member')
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

        <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>

                    <form method="Post" action="{{ route('create_user') }}">
                        @csrf
                        <div class="modal-body">

                            <div class="mb-3" id="modal-id" style="display: none;">
                                <label for="id-field" class="form-label">ID</label>
                                <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" class="form-control" placeholder="Enter Name"
                                    name="name" required />
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" placeholder="Enter Email"
                                    name="email" required />
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" placeholder="Enter Password"
                                    name="password" required />
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
        {{-- import Member --}}
        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">

                        <h5 class="modal-title" id="exampleModalLabel">Import Member(s)</h5>


                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form method="Post" action="" id="importMemberForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="mb-3" id="modal-id" style="display: none;">
                                <label for="id-field" class="form-label">ID</label>
                                <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                            </div>


                            <div class="mb-3">
                                <label for="name" class="form-label">Plan</label>
                                <select class="form-select " required name="plan_id" id="planId">
                                    <option value="">Choose Plan</option>
                                    @foreach ($plans as $plan)
                                    <option value="{{$plan->id}}">{{$plan->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">File</label>
                                <input type="file" id="file" class="form-control" accept=".xls,.xlsx" placeholder="Enter Name" name="name" required />
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
            // import member file
            $("#importMemberForm").on('submit', async function(e) {
                e.preventDefault();
                preLoader.show();
                var file = $('#file')[0].files;
                var plan = $('#planId').val();
                var fd = new FormData;
                if (file !== undefined) {
                    fd.append('file', file[0]);
                }
                fd.append('plan_id', plan);
                $.ajax({
                    type: 'POST',
                    url: "{{route('import_member_data')}}",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function($data) {
                        new swal("Good Job", "Data Import Succesful!.", "success");
                        preLoader.hide();
                        $('#importMemberForm').trigger("reset");
                        window.location.reload()
                    },
                    error: function(data) {
                        console.log(data)
                        // new swal(data.responseJSON.message);
                        preLoader.hide();
                        new swal("Opss", data.responseJSON.message, "error");
                    }
                })
            });

            $('body').on('click', '.edit-user', function() {
                var id = $(this).data('id');
                $.get("{{ route('user_details') }}?id=" + id,
                    function(data) {
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