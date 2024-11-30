@extends('member.layout.master')

@section('links')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
 <!-- swiper css -->
 <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">

    <div class="position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg profile-setting-img">
            <img  @if($user->cover_image) src="{{ asset("$user->cover_image") }}" @else src="{{ asset('assets/images/profile-bg.jpg') }}" @endif data-id="cover" class="profile-wid-img" alt="">
            <div class="overlay-content">
                <div class="text-end p-3">
                    <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                        <input id="profile-foreground-img-file-input" accept=".jpg, .png, image/jpeg, image/png" type="file" data-id="cover" class="profile-foreground-img-file-input fileInput" >
                        <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card mt-n5">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                            <img @if($user->profile_image) src="https://e-coop.cthostel.com/ecoop_files/public/{{ $user->cover_image }}" @else src="{{ asset('assets/images/avatar.png') }}" @endif data-id="profile" id="userProfileImage" class="rounded-circle avatar-xl img-thumbnail user-profile-image previews" alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" accept=".jpg, .png, image/jpeg, image/png" type="file" data-id="profile" class="profile-img-file-input fileInput">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-0">Referral ID : {{ $user->coop_id }} </p>
                    </div>
                </div>
            </div><!--end card-->
         
        </div><!--end col-->
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-user"></i>
                                Personal Details
                            </a>
                        </li>
                        @if($user->user_type == "Member")
                        <li class="nav-item">
                            <a class="nav-link " data-bs-toggle="tab" href="#myBank" role="tab">
                                <i class="fas fa-bank"></i>
                                Bank
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>
                                Change Password
                            </a>
                        </li>
                        @if($user->user_type == "Member")
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#experience" role="tab">
                                <i class="far fa-envelope"></i>
                                My Plan
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="mdi mdi-cog-outline"></i>
                                Privacy Policy
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form id="profileUpdate" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="firstnameInput" class="form-label"> Name</label>
                                            <input type="text" class="form-control" id="firstnameInput" name="name" placeholder="Enter your name" value="{{ $user->name }}">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="phonenumberInput" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" readonly id="phonenumberInput" placeholder="Enter your phone number" value="{{ $user->phone }}">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" readonly id="emailInput" placeholder="Enter your email" value="{{ $user->email }}">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="emailInput" name="address" placeholder="Enter your address" value="{{ $user->address }}">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="JoiningdatInput" class="form-label">Joining Date</label>
                                            <input type="text" class="form-control" readonly value="{{ $user->created_at }}" data-provider="flatpickr" id="JoiningdatInput" data-date-format="d M, Y" placeholder="Select date" />
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="designationInput" class="form-label">Designation / Occupation</label>
                                            <input type="text" class="form-control" id="designationInput" placeholder="Designation" name="designation" value="{{ $user->designation }}">
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="cityInput" class="form-label">Gender</label>
                                            <select class="form-select rounded-pill mb-3" name="gender" aria-label="Default select example">
                                                <option value="" >Choose Gender</option>
                                                <option value="Male" {{ $user->gender == "Male" ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ $user->gender == "Female" ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="cityInput" class="form-label">State</label>
                                            <input type="text" class="form-control rounded-pill mb-3" id="cityInput" placeholder="State" name="state" value="{{ $user->state }}" />
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label ">City</label>
                                            <input type="text" class="form-control rounded-pill mb-3" id="countryInput" placeholder="City" name="city" value="{{ $user->city }}" />
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="mb-3 pb-2">
                                            <label for="exampleFormControlTextarea" class="form-label">Bio</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea" name="bio" placeholder="Enter your bio" rows="3">{{ $user->bio }}</textarea>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                            {{-- <button type="button" class="btn btn-soft-success">Cancel</button> --}}
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                        </div><!--end tab-pane-->
                        <div class="tab-pane" id="myBank" role="tabpanel">
                            <form method="post" id="verifyAccount">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Select Bank*</label>
                                            <select class="form-select rounded-pill mb-3" name="code" aria-label="Default select example">
                                                <option value="">Choose Bank</option>
                                                @foreach ($banks as $bank)
                                                <option value="{{ $bank->code }}" {{ $user->bank_code == $bank->code ? 'selected' : '' }}>{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Account Number*</label>
                                            <input  class="form-control rounded-pill mb-3" value="{{ $user->account_number }}" type="text" class="form-control" pattern="^\d{10}$" required  name="account_number"  placeholder="account number">
                                        </div>
                                    </div>
                                    <div class="col-lg-4" @if(!$user->account_name) style="display:none" @endif id="accountDiv">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">Account Name*</label>
                                            <input type="text" class="form-control rounded-pill mb-3" value="{{ $user->account_name }}" id="accountName" name="account_name"  placeholder="account name">
                                        </div>
                                    </div><!--end col--><!--end col-->
                                    {{-- <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                        </div>
                                    </div><!--end col--> --}}
                                    <div class="col-lg-12" @if($user->account_name) style="display:none" @endif id="accountDiv">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">verify</button>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                        </div><!--end tab-pane-->
                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form method="post" id="passwordChange">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                            <input type="password" class="form-control" required name="password" id="password-fielda" placeholder="Enter current password">
                                            <span toggle="#password-fielda" class="fas toggle-password field-icon fa-eye-slash"></span>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New Password*</label>
                                            <input type="password" class="form-control" required name="new_password" id="password-fieldb" placeholder="Enter new password">
                                            <span toggle="#password-fieldb" class="fas toggle-password field-icon fa-eye-slash"></span>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm Password*</label>
                                            <input type="password" class="form-control" required  name="confirm_password" id="password-fieldz" placeholder="Confirm password">
                                            <span toggle="#password-fieldz"  class="fas toggle-password field-icon fa-eye-slash"></span>
                                        </div>
                                    </div><!--end col-->
                                    {{-- <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                        </div>
                                    </div><!--end col--> --}}
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-success">Change Password</button>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>
                        </div><!--end tab-pane-->
                        @if($user->user_type == "Member")
                        <div class="tab-pane" id="experience" role="tabpanel">
                            <div id="newlink">
                                <div id="1">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Plan Name</label>
                                                <input type="text" name="name" class="form-control" value="{{ $plan->name }}" placeholder="Enter plan ame">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="lastnameInput" class="form-label">Plan registration Fee</label>
                                                <input type="number" name="reg_fee" class="form-control" value="{{ $plan->reg_fee }}" placeholder="Enter plan registration fee">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="contactnumberInput" class="form-label">Plan Weekly Dues</label>
                                                <input type="number" class="form-control" name="monthly_dues" value="{{ $plan->monthly_dues }}" placeholder="Enter plan weekly dues">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="phonenumberInput" class="form-label">Plan Monthly Charge</label>
                                                <input type="number" class="form-control" value="{{ $plan->monthly_charge }}" name="monthly_charge" placeholder="Enter monthly charge">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="emailidInput" class="form-label">Plan Loan Application Referrer</label>
                                                <input type="number" class="form-control" name="referrer_no" value="{{ $plan->referrer_no }}" placeholder="Enter number of referrer for loan application eligibility">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="contactnumberInput" class="form-label">Min Loan Application</label>
                                                <input type="number" class="form-control" name="min_loan_range" value="{{ $plan->min_loan_range }}" placeholder="Enter plan minimum loan application">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="phonenumberInput" class="form-label">Max Loan Application</label>
                                                <input type="number" class="form-control" name="max_loan_range" value="{{ $plan->max_loan_range }}" placeholder="Enter plan maximum loan application">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="emailidInput" class="form-label">Defaulter Loan Charge</label>
                                                <input type="number" class="form-control" name="default_charge" value="{{ $plan->default_charge }}" placeholder="Enter amount for defaulters">
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">Note</label>
                                                <textarea class="form-control" name="note" rows="3" placeholder="Enter plan description">{{ $plan->note }}</textarea>
                                            </div>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                    <!--end row-->
                                </div>
                            </div>
                            <div id="newForm" style="display: none;">

                            </div>
                        </div><!--end tab-pane-->
                        @endif
                        <div class="tab-pane" id="privacy" role="tabpanel">
                            <div class="mb-4 pb-2">
                                <h5 class="card-title text-decoration-underline mb-3">Security:</h5>
                                <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                    <div class="flex-grow-1">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-primary">Enable Two-facor Authentication</a>
                                        <p class="text-muted">Two-factor authentication is an enhanced security measure. Once enabled, you will be required to enter a one-time password (OTP) sent to your email address whenever you want to access your account..</p>
                                    </div>
                                    <div class="flex-shrink-0 ms-sm-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switchTwo" type="checkbox" role="switch" id="directMessage" {{ $user->tfa == "1" ? 'checked' : '' }} />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div>
                                <h5 class="card-title text-decoration-underline mb-3">Delete This Account:</h5>
                                <p class="text-muted">Go to the Data & Privacy section of your profile Account. Scroll to "Your data & privacy options." Delete your Profile Account. Follow the instructions to delete your account :</p>
                                <div>
                                    <input type="password" class="form-control" id="passwordInput" placeholder="Enter your password" value="make@321654987" style="max-width: 265px;">
                                </div>
                                <div class="hstack gap-2 mt-3">
                                    <a href="javascript:void(0);" class="btn btn-soft-danger">Close & Delete This Account</a>
                                    <a href="javascript:void(0);" class="btn btn-light">Cancel</a>
                                </div>
                            </div> --}}
                        </div><!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->
    @if($user->user_type == "Member")
    @livewire('referral', ['user' => $user])
    @endif

</div>
<!-- container-fluid -->
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
                    const postRequest = await request("/update-profile",
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
