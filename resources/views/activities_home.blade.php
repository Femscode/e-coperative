@extends('layout.master')

@section('links')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Add, Edit & Remove</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add Activity</button>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th>S/N</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Global</th>
                                    <th>User</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($activities as $activity)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $activity->title }}</td>                                   
                                    <td>{{ $activity->description }}</td>                                    
                                    <td>{{ $activity->date }}</td>                                    
                                    <td>
                                        @if($activity->is_global == 1 )
                                            Yes
                                        @else
                                            No
                                        @endif
                                    </td>                                    
                                    <td>
                                        @if($activity->is_global == 1 )
                                            All
                                        @else
                                            {{$activity->user->name}}
                                        @endif
                                    </td>                                   
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light rounded p-1 me-2">
                                                <img src="{{asset("file/$activity->image")}}" alt="" class="img-fluid d-block">
                                            </div>
                                        </div>
                                    </td>                                    
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="edit">
                                                <button class="btn btn-sm btn-success edit-item-btn edit-user" id=""
                                                data-id="{{ $activity->id }}" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                            </div>
                                            <div class="remove">
                                                <button class="btn btn-sm btn-danger remove-item-btn" data-id="{{ $activity->id }}" id="deleteRecord">Remove</button>
                                            </div>
                                        </div>
                                    </td>
                            
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                    orders for you search.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="#">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="#">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title modalTitle" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form method="Post" id="frm_main" enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" id="idUser">
                    <div class="mb-3" id="modal-id" style="display: none;">
                        <label for="id-field" class="form-label">ID</label>
                        <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" class="form-control" placeholder="Enter Title" name="title" required />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" cols="" rows="" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Date</label>
                        <input type="date" name="date" id="date" min="{{$now}}" class="form-control" required >
                    </div>
                
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="edit-btn">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Create Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form method="Post" action="{{route('create_activities')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3" id="modal-id" style="display: none;">
                        <label for="id-field" class="form-label">ID</label>
                        <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" class="form-control" placeholder="Enter Title" name="title" required />
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" cols="" rows="" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Date</label>
                        <input type="date" name="date" id="" min="{{$now}}" class="form-control" required >
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="is_global" class="form-label">Global</label>
                        <input type="checkbox" name="is_global" id="" class="isGlobal">
                    </div>
                    <div class="mb-3" id="userDiv">
                        <label for="is_global" class="form-label">Choose User</label>
                        <select class="form-select mb-3" aria-label="Default select example" id="userId" name="user_id" required>
                            <option selected="" value="">Select User </option>
                            @foreach ($users as $user)                             
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
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

        $(".isGlobal").on("click",function(e){
            if($(this).is(':checked') == true){
                $("#userId").val("");
                $('#userId').prop('required', false);
                $("#userDiv").hide()
            }else{
                $("#userDiv").show()
                $("#userId").val("");
                $('#userId').prop('required', true);
            }

        })
        $('body').on('click', '.edit-user', function() {
            var id = $(this).data('id');
            $.get('{{ route('activity_details') }}?id=' + id, function(data) {
                // alert('hhgf');
                $('#idUser').val(data.id);
                $('#title').val(data.title);
                $('#description').val(data.description);
                $('#date').val(data.date);
                $('.modalTitle').html(data.title);
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
                    const postRequest = await request("/admin/activity/update",
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
                new swal("Activity record will not be deleted  :)");
            }
        }

        function performDelete(el, user_id) {
            //alert(user_id);
            try {
                $.get('{{ route('delete_activities') }}?id=' + user_id,
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