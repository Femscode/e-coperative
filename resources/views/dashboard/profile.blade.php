@extends('vendordashboard.master')
@section('header')

@endsection

@section('content')
<div class="container-xxl">

    <div class="row" id='mainpreview'>
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-body">

                    @if($user->cover_image !== null)
                    <div class="bg-primary profile-bg rounded-top position-relative mx-n3 mt-n3"
                        style="  background-size: cover;background-position: center;background-repeat: no-repeat;;background-image: url('{{ config('app.env') === 'local' ? url('coverPic/' . $user->cover_image) : 'https://cttaste.com/cttaste_files/public/coverPic/' . $user->cover_image }}');">
                        @else
                        <div class="bg-primary profile-bg rounded-top position-relative mx-n3 mt-n3">
                            @endif
                            @if($user->image !== null)
                            <img src="{{ config('app.env') === 'local' ? url('profilePic/' . $user->image) : 'https://cttaste.com/cttaste_files/public/profilePic/' . $user->image }}"
                                alt="" class="avatar-xl border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                            @else
                            <img src="https://dnasoundstudio.com/producers/assets/images/music-dashboard/feature-album/05.png"
                                alt="" class="avatar-xl border border-light border-3 rounded-circle position-absolute top-100 start-0 translate-middle ms-5">
                            @endif
                        </div>

                        <div class="mt-5 d-flex flex-wrap align-items-center justify-content-between">
                            <div>
                                <h4 class="mb-1">{{ $user->name }} <i class='bx bxs-badge-check text-success align-middle'></i></h4>
                                <p class="mb-0">{{$user->email}}</p>
                            </div>
                            <div class="d-flex align-items-center gap-2 my-2 my-lg-0">
                                <a id='editbutton' class="btn btn-outline-primary"><i class="bx bx-edit"></i> Edit</a>

                            </div>
                        </div>
                        <div class="row mt-3 gy-2">
                            <div class="col-lg-2 col-6">
                                <div class="d-flex align-items-center gap-2 border-end">
                                    <div class="">
                                        <iconify-icon icon="solar:clock-circle-bold-duotone" class="fs-28 text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{$user->get_school(Auth::user()->school)->name ?? ""}}</h5>
                                        <p class="mb-0">Location</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-6">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="">
                                        <iconify-icon icon="solar:notebook-bold-duotone" class="fs-28 text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{$user->phone ?? ""}}</h5>
                                        <p class="mb-0">Contact</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <ul class="list-inline d-flex gap-1 my-3  align-items-center justify-content-center">
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="btn btn-soft-primary avatar-sm d-flex align-items-center justify-content-center fs-20">
                                <i class="bx bxl-facebook"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="btn btn-soft-danger avatar-sm d-flex align-items-center justify-content-center fs-20">
                                <i class="bx bxl-instagram"></i>
                            </a>
                        </li>

                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="btn btn-soft-info avatar-sm d-flex align-items-center justify-content-center  fs-20">
                                <i class="bx bxl-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="btn btn-soft-success avatar-sm d-flex align-items-center justify-content-center fs-20">
                                <i class="bx bxl-whatsapp"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript: void(0);" class="btn btn-soft-warning avatar-sm d-flex align-items-center justify-content-center fs-20">
                                <i class="bx bx-envelope"></i>
                            </a>
                        </li>
                    </ul> -->
                    <p class="d-flex align-items-center border p-2 rounded-2 border-dashed bg-body text-start mb-0">
    <span id="cttaste-link">https://cttaste.com/{{ $user->slug }}</span>
    <a href="#!" class="ms-auto fs-4 copy-link"><i class="ti ti-copy"></i></a>
</p>   
                    </div>
                </div>
            </div>

        </div>
        <div class="row" id='mainedit' style='display:none'>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Profile Details</h4>
                    </div>


                    <form id="update_profile" class="form fv-plugins-bootstrap5 fv-plugins-framework" enctype='multipart/form-data' novalidate="novalidate">@csrf
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <div class="col-12 mb-2">
                                    <!--begin::Image input-->
                                    <div class="dropzone dz-clickable" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                        <div class="dz-message needsclick">
                                            <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                                            <h3 class="mt-4">Drop your images here, or <span class="text-primary">click to browse</span></h3>
                                            <span class="text-muted fs-13">
                                                Please provide two images: one display image and one cover image. The cover image must be one of your foods.
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Hidden file input to hold the image -->
                                    <input type="file" id="image" name="avatar" class="d-none" />
                                    <!-- <div class="image-input image-input-outline" data-kt-image-input="true">
                                    <label class="w-25px h-25px mb-2">Change Display Image</label>
                                    <input type="file" id='image' name="avatar" class='form-control' accept=".png, .jpg, .jpeg">
                                </div> -->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-12 mb-2">
                                    <!--begin::Row-->
                                    <div class="row">
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                            <label class='mb-1' text-bolder text-dark>First Name</label>
                                            <input required type="text" id='firstname' name="fname"
                                                value='{{Auth::user()->firstname ?? ""}}'
                                                class="form-control  form-control-solid mb-3 mb-lg-0"
                                                placeholder="First name">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-lg-6 fv-row fv-plugins-icon-container">
                                            <label class='mb-1' text-bolder text-dark>Last Name</label>
                                            <input required type="text" id='lastname' name="lname"
                                                value='{{Auth::user()->lastname ?? ""}}'
                                                class="form-control  form-control-solid"
                                                placeholder="Last name">
                                            <div class="fv-plugins-message-container invalid-feedback"></div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">

                                <div class="col-lg-6 mb-2 fv-row fv-plugins-icon-container">
                                    <label class='mb-1' text-bolder text-dark>Company Name</label>
                                    <input type="text" id='name' name="company"
                                        class="form-control  form-control-solid" placeholder="Company name"
                                        value="{{Auth::user()->name}}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>

                                <div class="col-lg-6 mb-2 fv-row fv-plugins-icon-container">
                                    <label class='mb-1' text-bolder text-dark>Phone</label>
                                    <input type="tel" name="phone" id='phone' value='{{Auth::user()->phone ?? ""}}'
                                        class="form-control  form-control-solid" placeholder="Phone number"
                                        value="{{Auth::user()->phone}}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Col-->
                            </div>
                            <div class="row mb-6">
                                <!--begin::Label-->

                                <div class="col-lg-12 mb-2 fv-row fv-plugins-icon-container">
                                    <label class='mb-1' text-bolder text-dark>Description</label>
                                    <textarea maxlength="30" type="text" id='description' name="description"
                                        class="form-control  form-control-solid"
                                        placeholder="Short description of restaurant">{{$user->description}}</textarea>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Col-->
                            </div>


                            <div class="row mb-6">

                                <div class="col-lg-6 mb-2 fv-row fv-plugins-icon-container">
                                    <label class='mb-1' text-bolder text-dark>Email Address</label>
                                    <input type="tel" name="phone" id='email'
                                        class="form-control  form-control-solid" readonly
                                        placeholder="Email Address" value="{{Auth::user()->email}}">
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                                <!--end::Col-->

                                <div class="col-lg-6 mb-2 fv-row fv-plugins-icon-container">
                                    <label class='mb-1' text-bolder text-dark>School</label>
                                    <select name="school" id='school' aria-label="Select a school" data-control="select2"
                                        data-placeholder="Select a school..."
                                        class="form-select form-select-solid form-select-lg fw-bold select2-hidden-accessible"
                                        data-select2-id="select2-data-7-llbv" tabindex="-1" aria-hidden="true">
                                        <option value="{{$user->get_school(Auth::user()->school)->id ?? ''}}"
                                            data-select2-id="select2-data-9-1hiw">
                                            {{$user->get_school(Auth::user()->school)->name ?? 'Select School'}}
                                        </option>
                                        @foreach($schools as $school)

                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                        <!--end::Card body-->
                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                            <button type="submit" class="btn btn-primary"
                                id="kt_account_profile_details_submit">Update</button>
                        </div>
                        <!--end::Actions-->
                        <input type="hidden">
                        <div></div>
                    </form>
                </div>
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
            $('.copy-link').click(function() {
        // Get the text of the link
        var linkText = $('#cttaste-link').text();
        
        // Create a temporary input element to copy the text
        var tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(linkText).select();
        document.execCommand('copy');
        tempInput.remove();
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        // Optionally show a notification or alert
        Toast.fire('Link Copied')
    });

            $("#editbutton").on('click', function() {
                $("#mainedit").show();
                $("#mainpreview").hide()
            })
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            $("#update_profile").on("submit", async function(e) {
                e.preventDefault();
                Swal.fire('Updating profile, please wait...')
                var image = $('#image')[0].files;
                var fd = new FormData;
                fd.append('name', $("#name").val());
                fd.append('firstname', $("#firstname").val());
                fd.append('lastname', $("#lastname").val());
                fd.append('phone', $("#phone").val());
                fd.append('email', $("#email").val());
                fd.append('school', $("#school").val());
                fd.append('description', $("#description").val());

                var files = $('#image')[0].files;

                if (files.length > 0) {
                    fd.append('image', files[0]); // Append the first image
                }
                if (files.length > 1) {
                    fd.append('cover_image', files[1]); // Append the second image
                }
                console.log(fd)
                $.ajax({
                    type: 'POST',
                    url: "{{route('updateprofile')}}",
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function($data) {
                        console.log('the data', $data)
                        Swal.close()
                        Toast.fire({
                            icon: 'success',
                            title: 'Profile Updated Successfully'
                        })

                        window.location.reload()

                    },
                    error: function(data) {
                        console.log(data)
                        Swal.close()
                        Swal.fire('Opps!', 'Profile not updated, contact the administrator', 'error')
                    }
                })

            })


        })
    </script>


    <script>
        Dropzone.autoDiscover = false;

        // Initialize Dropzone
        var myDropzone = new Dropzone("#myAwesomeDropzone", {
            url: "/your-upload-url", // Set to the URL where files are uploaded if necessary
            autoProcessQueue: false, // Prevent Dropzone from auto-uploading
            acceptedFiles: ".png,.jpg,.jpeg,.gif",
            maxFiles: 2, // Allow up to two files
            init: function() {
                var dropzoneInstance = this;

                // Handle file added event
                this.on("addedfile", function(file) {
                    // If more than two files are added, remove the extra files
                    if (this.files.length > 2) {
                        this.removeFile(this.files[0]); // Remove the first file
                    }

                    // Create a new FileReader object to read the image file
                    var reader = new FileReader();

                    // Once the file is read, set it as the value of the hidden input with id="image"
                    reader.onload = function(e) {
                        var files = $('#image')[0].files;
                        var dataTransfer = new DataTransfer();

                        // Add existing files
                        for (var i = 0; i < files.length; i++) {
                            dataTransfer.items.add(files[i]);
                        }

                        // Add the new file
                        dataTransfer.items.add(file);

                        // Assign the selected files to the hidden input
                        $('#image')[0].files = dataTransfer.files;
                    };

                    reader.readAsDataURL(file); // Read the file as a data URL
                });

                // Handle file removed event if needed
                this.on("removedfile", function(file) {
                    var files = $('#image')[0].files;
                    var dataTransfer = new DataTransfer();

                    // Add remaining files
                    for (var i = 0; i < files.length; i++) {
                        if (files[i] !== file) {
                            dataTransfer.items.add(files[i]);
                        }
                    }

                    // Assign the remaining files to the hidden input
                    $('#image')[0].files = dataTransfer.files;
                });
            }
        });
    </script>
    @endsection