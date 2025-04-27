@extends('cooperative.member.master')

@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">

<style>
    .profile-card {
        border-radius: 15px;
        overflow: hidden;
    }

    .profile-image-wrapper {
        width: 150px;
        height: 150px;
    }

    .profile-image {
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 0 20px rgba(9, 65, 104, 0.1);
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-image-edit {
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .profile-image-edit input {
        display: none;
    }

    .edit-button {
        width: 35px;
        height: 35px;
        background: #094168;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .edit-button:hover {
        background: #073251;
        transform: scale(1.1);
    }

    .nav-tabs-custom .nav-link {
        color: #6c757d;
        padding: 0.8rem 1.2rem;
        transition: all 0.3s ease;
    }

    .nav-tabs-custom .nav-link.active {
        color: #094168;
        background: transparent;
        border-bottom: 2px solid #094168;
    }

    .form-floating>.form-control:focus {
        border-color: #094168;
        box-shadow: 0 0 0 0.25rem rgba(9, 65, 104, 0.1);
    }

    .user-id {
        margin-top: 0.5rem;
    }

    .badge {
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .profile-image-wrapper {
            width: 120px;
            height: 120px;
        }

        .nav-tabs-custom .nav-link {
            padding: 0.5rem 0.8rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('main')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <h2>My Profile</h2>
        <div class="row">
            <div class="col-lg-4">
                <div class="card profile-card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="profile-header text-center">
                            <div class="profile-image-wrapper position-relative d-inline-block mb-4">
                                <div class="profile-image">
                                    <img @if($user->profile_image)
                                        src="https://syncosave.com/synco_files/public/{{ $user->profile_image }}"
                                        @elseif($user->photo)
                                        src="https://syncosave.com/synco_files/public/{{ $user->photo }}"
                                        @else
                                        src="{{ asset('assets/images/avatar.png') }}"
                                        @endif
                                        data-id="profile"
                                        id="userProfileImage"
                                        class="rounded-circle img-thumbnail user-profile-image previews"
                                        alt="{{ $user->name }}'s profile photo">
                                </div>
                                <div class="profile-image-edit">
                                    <input id="profile-img-file-input"
                                        accept=".jpg, .png, image/jpeg, image/png"
                                        type="file"
                                        data-id="profile"
                                        class="profile-img-file-input fileInput">
                                    <label for="profile-img-file-input" class="edit-button">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="profile-info">
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <div class="user-id">
                                    <span class="badge bg-light text-dark">
                                        <i class="bi bi-person-badge me-1"></i>
                                        {{ $user->username ?? 'Not provided' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails">
                                    <i class="bi bi-person me-1"></i>Personal Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#myBank">
                                    <i class="bi bi-bank me-1"></i>Bank Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#security">
                                    <i class="bi bi-shield-lock me-1"></i>Security
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
                                                <label for="nameInput" class="form-label">Full Name</label>
                                                <input type="text" class="form-control" id="nameInput" name="name" 
                                                       value="{{ $user->name }}" placeholder="Enter your full name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usernameInput" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="usernameInput" name="username" 
                                                       value="{{ $user->username ?? '' }}" placeholder="Enter your username">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="emailInput" readonly
                                                       value="{{ $user->email }}" placeholder="Enter your email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phoneInput" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="phoneInput" name="phone"
                                                       value="{{ $user->phone ?? '' }}" placeholder="Enter your phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="addressInput" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="addressInput" name="address"
                                                       value="{{ $user->address ?? '' }}" placeholder="Enter your address">
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="joinDateInput" class="form-label">Joined Date</label>
                                                <input type="text" class="form-control" id="joinDateInput" readonly
                                                       value="{{ $user->created_at->format('F d, Y') }}">
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="cityInput" class="form-label">City</label>
                                                <input type="text" class="form-control" id="cityInput" name="city"
                                                       value="{{ $user->city ?? '' }}" placeholder="Enter your city">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="stateInput" class="form-label">State</label>
                                                <input type="text" class="form-control" id="stateInput" name="state"
                                                       value="{{ $user->state ?? '' }}" placeholder="Enter your state">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="countryInput" class="form-label">Country</label>
                                                <input type="text" class="form-control" id="countryInput" name="country"
                                                       value="{{ $user->country ?? '' }}" placeholder="Enter your country">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="bioInput" class="form-label">Bio</label>
                                                <textarea class="form-control" id="bioInput" name="bio" rows="3"
                                                          placeholder="Enter your bio">{{ $user->bio ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Update Profile</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="myBank" role="tabpanel">
                                <form method="post" id="verifyAccount">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="accountNameInput" class="form-label">Account Name</label>
                                                <input type="text" class="form-control" id="accountNameInput" name="account_name"
                                                       value="{{ $user->account_name ?? '' }}" placeholder="Enter account name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="accountNumberInput" class="form-label">Account Number</label>
                                                <input type="text" class="form-control" id="accountNumberInput" name="account_number"
                                                       value="{{ $user->account_number ?? '' }}" placeholder="Enter account number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="bankCodeInput" class="form-label">Bank Code</label>
                                                <input type="text" class="form-control" id="bankCodeInput" name="bank_code"
                                                       value="{{ $user->bank_code ?? '' }}" placeholder="Enter bank code">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Verify</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="security" role="tabpanel">
                                <div class="mb-4 pb-2">
                                    <h5 class="card-title text-decoration-underline mb-3">Security:</h5>
                                    <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
                                        <div class="flex-grow-1">
                                            <p class="text-muted">Two-factor authentication: 
                                                {{ $user->tfa == 1 ? 'Enabled' : 'Disabled' }}</p>
                                            <!-- <p class="text-muted">Account Status: 
                                                {{ $user->active == 1 ? 'Active' : 'Inactive' }}</p> -->
                                        </div>
                                        <div class="flex-shrink-0 ms-sm-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input switchTwo" type="checkbox" role="switch" 
                                                       id="twoFactorAuth" {{ $user->tfa == 1 ? 'checked' : '' }} />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/profile.init.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.switchTwo').on('click', function() {
            const type = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                type: 'POST',
                url: "{{ route('enable-2fa') }}",
                data: { type: type },
                dataType: 'json',
                success: function(response) {
                    // Handle success
                },
                error: function(data) {
                    // Handle error
                }
            });
        });

        $('.fileInput').change(function() {
            const file = this.files[0];
            const dataId = $(this).data('id');
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', dataId);
            const img = $('img[data-id="' + dataId + '"]');
            
            if (file && file.type.match(/^image\//)) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.attr('src', e.target.result);
                };
                $.ajax({
                    type: 'POST',
                    url: "{{ route('save-file') }}",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {},
                    error: function(data) {}
                });
                reader.readAsDataURL(file);
            }
        });

        // $("#profileUpdate").on('submit', async function(e) {
        //     e.preventDefault();
        //     $('.preloader').show();
        //     const serializedData = $(this).serializeArray();
        //     try {
        //         const postRequest = await request("/update-profile",
        //             processFormInputs(serializedData), 'post');
        //         new showCustomAlert("Good Job", postRequest.message, "success");
        //         $('.preloader').hide();
        //     } catch (e) {
        //         $('.preloader').hide();
        //         if ('message' in e) {
        //             new showCustomAlert("Opss", e.message, "error");
        //         }
        //     }
        // });
        
        $("#profileUpdate").on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Updating profile',
                text: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $.ajax({
                url: "{{ route('profile.update') }}",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.preloader').show(); // Show loading indicator if you have one
                },
                success: function(response) {
                    $('.preloader').hide();
                    if (response.success) {
                        // Show success message (you might want to use your custom alert)
                        Swal.fire(response.message); // Or use: new showCustomAlert("Success", response.message, "success");
                        
                        // Optionally update the UI with new values
                        // location.reload(); // Refresh page if needed
                    }
                },
                error: function(xhr) {
                    $('.preloader').hide();
                    let errorMessage = 'An error occurred while updating the profile';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    // Show error message
                    Swal.fire(errorMessage); // Or use: new showCustomAlert("Error", errorMessage, "error");
                    
                    // If you have validation errors
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors); // Handle validation errors if needed
                    }
                }
            });
        });

        $("#verifyAccount").on('submit', async function(e) {
            e.preventDefault();
            $('.preloader').show();
            const serializedData = $(this).serializeArray();
            try {
                const postRequest = await request("/verify-account",
                    processFormInputs(serializedData), 'post');
                new showCustomAlert("Good Job", postRequest.message, "success");
                $('.preloader').hide();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    new showCustomAlert("Opss", e.message, "error");
                }
            }
        });
    });
</script>
@endsection