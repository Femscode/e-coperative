@extends('cooperative.admin.master')
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

@section('content')
<div class="container-fluid">
    <div class="container mt-4" id="main-content">
        <h2>My Profile</h2>
        <div class="row">
            <div class="col-lg-4">
                <div class="card profile-card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form id="profileUpdate" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="profile-header text-center">
                                <div class="profile-image-wrapper position-relative d-inline-block mb-4">
                                    <div class="profile-image">
                                        <img 
                                        @if($user->photo)
                                        src="https://syncosave.com/public/{{ $user->photo }}"
                                       
                                        @else
                                        src="{{ asset('/admindashboard/images/avatar.png') }}"
                                        @endif
                                        data-id="profile"
                                        id="userProfileImage"
                                        class="rounded-circle img-thumbnail user-profile-image previews"
                                        alt="{{ $user->name }}'s profile photo">
                                    </div>
                                    <div class="profile-image-edit">
                                        <input name='image' id="profile-img-file-input"
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
                                            {{ $user->username ?? 'Username Not provided' }}
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
                                        <label for="bankCodeInput" class="form-label">Select Bank</label>

                                        <select class="form-control" id="bankCodeInput" name="bank_code">
                                           
                                                <option value="{{ $user->bank_code ?? '' }}" data-name="">{{ $user->bank_name ?? '--Select a Bank--' }}</option>
                                                <option value="090134" data-name="Accion Microfinance Bank">Accion Microfinance Bank</option>
                                                <option value="044" data-name="Access Bank">Access Bank</option>
                                                <option value="014" data-name="Afribank">Afribank</option>
                                                <option value="090133" data-name="AL-Barakah Microfinance Bank">AL-Barakah Microfinance Bank</option>
                                                <option value="090136" data-name="Baobab Microfinance Bank">Baobab Microfinance Bank</option>
                                                <option value="090127" data-name="BC Kash Microfinance Bank">BC Kash Microfinance Bank</option>
                                                <option value="090117" data-name="Boctrust Microfinance Bank">Boctrust Microfinance Bank</option>
                                                <option value="023" data-name="Citibank">Citibank</option>
                                                <option value="090130" data-name="Consumer Microfinance Bank">Consumer Microfinance Bank</option>
                                                <option value="063" data-name="Diamond Bank">Diamond Bank</option>
                                                <option value="090608" data-name="Dot Microfinance Bank">Dot Microfinance Bank</option>
                                                <option value="050" data-name="Ecobank">Ecobank</option>
                                                <option value="040" data-name="Equitorial Trust Bank">Equitorial Trust Bank</option>
                                                <option value="070" data-name="Fidelity Bank">Fidelity Bank</option>
                                                <option value="090126" data-name="Fidfund Microfinance Bank">Fidfund Microfinance Bank</option>
                                                <option value="085" data-name="Finbank">Finbank</option>
                                                <option value="011" data-name="First Bank">First Bank</option>
                                                <option value="214" data-name="First City Monument Bank (FCMB)">First City Monument Bank (FCMB)</option>
                                                <option value="090122" data-name="Gowans Microfinance Bank">Gowans Microfinance Bank</option>
                                                <option value="058" data-name="Guaranty Trust Bank (GTBank)">Guaranty Trust Bank (GTBank)</option>
                                                <option value="090121" data-name="Hasal Microfinance Bank">Hasal Microfinance Bank</option>
                                                <option value="090118" data-name="IBILE Microfinance Bank">IBILE Microfinance Bank</option>
                                                <option value="069" data-name="Intercontinental Bank">Intercontinental Bank</option>
                                                <option value="323" data-name="Jaiz Bank">Jaiz Bank</option>
                                                <option value="50968" data-name="Kuda Bank">Kuda Bank</option>
                                                <option value="51322" data-name="Mkobo Microfinance Bank">Mkobo Microfinance Bank</option>
                                                <option value="51318" data-name="Mint Finex Microfinance Bank">Mint Finex Microfinance Bank</option>
                                                <option value="50515" data-name="Moniepoint Microfinance Bank">Moniepoint Microfinance Bank</option>
                                                <option value="090128" data-name="Ndiorah Microfinance Bank">Ndiorah Microfinance Bank</option>
                                                <option value="056" data-name="Oceanic Bank">Oceanic Bank</option>
                                                <option value="090119" data-name="Ohafia Microfinance Bank">Ohafia Microfinance Bank</option>
                                                <option value="999992" data-name="OPay Digital Services Limited (OPay)">OPay Digital Services Limited (OPay)</option>
                                                <option value="100033" data-name="PalmPay Limited">PalmPay Limited</option>
                                                <option value="090135" data-name="Personal Trust Microfinance Bank">Personal Trust Microfinance Bank</option>
                                                <option value="317" data-name="Providus Bank">Providus Bank</option>
                                                <option value="51297" data-name="Raven Microfinance Bank">Raven Microfinance Bank</option>
                                                <option value="090125" data-name="Regent Microfinance Bank">Regent Microfinance Bank</option>
                                                <option value="090132" data-name="Richway Microfinance Bank">Richway Microfinance Bank</option>
                                                <option value="090138" data-name="Royal Exchange Microfinance Bank">Royal Exchange Microfinance Bank</option>
                                                <option value="50870" data-name="Rubies Microfinance Bank">Rubies Microfinance Bank</option>
                                                <option value="090140" data-name="Sagamu Microfinance Bank">Sagamu Microfinance Bank</option>
                                                <option value="076" data-name="Skye Bank">Skye Bank</option>
                                                <option value="221" data-name="Stanbic IBTC">Stanbic IBTC</option>
                                                <option value="068" data-name="Standard Chartered Bank">Standard Chartered Bank</option>
                                                <option value="232" data-name="Sterling Bank">Sterling Bank</option>
                                                <option value="084" data-name="SpringBank">SpringBank</option>
                                                <option value="304" data-name="Suntrust Bank">Suntrust Bank</option>
                                                <option value="033" data-name="United Bank for Africa (UBA)">United Bank for Africa (UBA)</option>
                                                <option value="032" data-name="Union Bank">Union Bank</option>
                                                <option value="215" data-name="Unity Bank">Unity Bank</option>
                                                <option value="090123" data-name="Verite Microfinance Bank">Verite Microfinance Bank</option>
                                                <option value="50754" data-name="VFD Microfinance Bank">VFD Microfinance Bank</option>
                                                <option value="090139" data-name="Visa Microfinance Bank">Visa Microfinance Bank</option>
                                                <option value="035" data-name="Wema Bank">Wema Bank</option>
                                                <option value="090120" data-name="Wetland Microfinance Bank">Wetland Microfinance Bank</option>
                                                <option value="090124" data-name="Xslnce Microfinance Bank">Xslnce Microfinance Bank</option>
                                                <option value="057" data-name="Zenith Bank">Zenith Bank</option>
                                            </select>

                                            <script>
                                                document.getElementById('bank').addEventListener('change', function() {
                                                    const bankCode = this.value;
                                                    const bankName = this.options[this.selectedIndex].dataset.name;
                                                    if (bankCode && bankName) {
                                                        console.log('Bank Code:', bankCode, 'Bank Name:', bankName);
                                                    }
                                                });
                                            </script>
                                            <!-- <input type="text" class="form-control" id="bankCodeInput" name="bank_code"
                                            value="{{ $user->bank_code ?? '' }}" placeholder="Enter bank code"> -->
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
                                        {{ $user->tfa == 1 ? 'Enabled' : 'Disabled' }}
                                    </p>
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
</div>
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
                data: {
                    type: type
                },
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

            // Create FormData object to handle file uploads
            const formData = new FormData(this);

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
                data: formData,
                dataType: 'json',
                contentType: false, // Required for file upload
                processData: false, // Required for file upload
                cache: false, // Prevent caching
                beforeSend: function() {
                    $('.preloader').show();
                },
                success: function(response) {
                    $('.preloader').hide();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    $('.preloader').hide();
                    let errorMessage = 'An error occurred while updating the profile';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        console.log(errors);
                    }
                }
            });
        });

        $("#verifyAccount").on('submit', async function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Verifying Bank Details',
                text: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            $('.preloader').show();

            const bankCode = $('#bankCodeInput').val();
            const bankName = $('#bankCodeInput option:selected').data('name');

            const formData = new FormData(this);
            formData.append('bank_name', bankName);

            try {
                const response = await $.ajax({
                    url: "/verify-account",
                    type: 'POST',
                    data: Object.fromEntries(formData),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if (response.status === 'ok') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });
                } else {
                    throw new Error(response.message);
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Unable to verify bank details. Try a different bank!'
                });
            } finally {
                $('.preloader').hide();
            }
        });
    });
</script>

@endsection