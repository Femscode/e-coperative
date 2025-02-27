@extends('cooperative.admin.master')
@section('header')

@endsection

@section('content')

<div class="container-fluid">

    <div class="position-relative">
        <div class="profile-wid-bg profile-setting-img">
            <div class="col">
                <div class="text-end p-3">
                    {{-- <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" type="file" data-id="cover" class="profile-foreground-img-file-input fileInput" >
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                        </label>
                    </div>   --}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">{{ $user->name }} Transactions</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control " wire:model="search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control " wire:model="search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    
                    <div class="table-responsive  mt-3 mb-1">
                        
                        <table class="table align-middle table-nowrap" >
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Member</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            @if($transactions->count() > 0)
                                <tbody class="list form-check-all">
                                    @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="fw-medium">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $transaction->user->name ?? ""}}</td>
                                        <td class="fw-medium">{{ $transaction->payment_type }}</td>
                                        <td class="fw-medium">{{ $transaction->month }}</td>
                                        <td class="fw-medium">{{ number_format($transaction->amount, 2) }}</td>
                                        <td class="text-muted">{{ $transaction->updated_at }}</td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            @endif
                        </table>
                        @if($transactions->count() < 1)
                            <div class="noresult" >
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>

    @livewire('referral' , ['user' => $user])

</div>
@endsection

@section('script')
 <!-- swiper js -->
 <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

 <!-- profile init js -->
 <script src="{{ asset('assets/js/pages/profile.init.js') }}"></script>
 <script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.switchTwo').on('click', function() {
            if ($(this).is(':checked')) {
                // Checkbox is checked
                var type = 1;
            } else {
                // Checkbox is unchecked
                var type = 0;
            }
            const formData = new FormData();
            formData.append('type', type);
            $.ajax({
                    type: 'POST',
                    url: "{{route('enable-2fa')}}",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                success: function(response) {
                },
                error: function(data) {
                }
            })
        });

        // Listen for changes in the file input field
        $('.fileInput').change(function () {
            // Get the selected file
            const file = this.files[0];
            const type = $(this).data('id');
            const dataId = $(this).data('id'); // Get the data-id attribute
            // alert("type")
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', type);
            const img = $('img[data-id="' + dataId + '"]');
            if (file) {
                // Check if the selected file is an image (you can add more file types)
                if (file.type.match(/^image\//)) {
                    // Create a FileReader to read the file
                    const reader = new FileReader();

                    // Define a callback function to execute when the file is loaded
                    reader.onload = function (e) {
                    // Get the image element by its ID
                    img.attr('src', e.target.result);
                };
                $.ajax({
                    type: 'POST',
                    url: "{{route('save-file')}}",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                    },
                    error: function(data) {
                    }
                })
                // Read the file as a data URL (this will trigger the onload function)
                reader.readAsDataURL(file);
                } else {
                    // Display an error message for unsupported file types
                    $('.previews').html('Unsupported file type');
                }
            } else {
                // Clear the previews if no file is selected
                $('.previews').empty();
            }
        });
        $('body').on('click', '.edit-user', function() {
            var id = $(this).data('id');
            $.get('{{ route('user_details') }}?id=' + id, function(data) {
                // alert('hhgf');
                $('#idUser').val(data.id);
                $('#emailDetail').val(data.email);
                $('#nameDetail').val(data.name);
            })
        });

        $("#profileUpdate").on('submit', async function(e) {
            e.preventDefault();
            $('.preloader').show();
            const serializedData = $("#profileUpdate").serializeArray();
            try {
                    const postRequest = await request("/member/update-profile",
                    processFormInputs(
                        serializedData), 'post');
                    new swal("Good Job", postRequest.message, "success");
                    $('.preloader').hide();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    new swal("Opss", e.message, "error");

                }
            }
        })
        $("#passwordChange").on('submit', async function(e) {
            e.preventDefault();
            $('.preloader').show();
            const serializedData = $("#passwordChange").serializeArray();
            try {
                    const postRequest = await request("/change-password",
                    processFormInputs(
                        serializedData), 'post');
                    new swal("Good Job", postRequest.message, "success");
                    $('#passwordChange').trigger("reset");
                    $('.preloader').hide();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    new swal("Opss", e.message, "error");

                }
            }
        })
        $("#verifyAccount").on('submit', async function(e) {
            e.preventDefault();
            $('.preloader').show();
            const serializedData = $("#verifyAccount").serializeArray();
            try {
                    const postRequest = await request("/verify-account",
                    processFormInputs(
                        serializedData), 'post');
                    new swal("Good Job", postRequest.message, "success");
                    $('#accountDiv').show();
                    $('#accountName').val(postRequest.data);
                    $('.preloader').hide();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    new swal("Opss", e.message, "error");

                }
            }
        })

        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

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
