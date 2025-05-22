@extends('ajo.member.master')

@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<!-- swiper css -->
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

    /* Responsive adjustments */
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
            <div class="col-lg-4 mb-4">
                <div class="card profile-card border-0 shadow-sm">
                    <div class="card-body p-4">
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
                                        {{ $user->email }}
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
                            @if($user->user_type == "Member")
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#myBank">
                                    <i class="bi bi-bank me-1"></i>Bank Details
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword">
                                    <i class="bi bi-shield-lock me-1"></i>Security
                                </a>
                            </li>
                            @if($user->user_type == "Member")
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#experience">
                                    <i class="bi bi-star me-1"></i>My Plan
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#privacy">
                                    <i class="bi bi-shield-check me-1"></i>Privacy
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
                                                    <option value="">Choose Gender</option>
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

                                                <select class="form-select rounded-pill mb-3" name="code" id="bankCodeInput" aria-label="Default select example">

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
                                            </div>
                                        </div><!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="confirmpasswordInput" class="form-label">Account Number*</label>
                                                <input class="form-control rounded-pill mb-3" value="{{ $user->account_number }}" type="text" class="form-control" pattern="^\d{10}$" required name="account_number" placeholder="account number" id="accountNumberInput">
                                            </div>
                                        </div>
                                        <div class="col-lg-4" @if(!$user->account_name) style="display:none" @endif id="accountNumberDiv">
                                            <div>
                                                <label for="newpasswordInput" class="form-label">Account Name*</label>
                                                <input type="text" class="form-control rounded-pill mb-3" value="{{ $user->account_name }}" id="accountName" name="account_name" placeholder="account name">
                                            </div>
                                        </div><!--end col--><!--end col-->
                                        {{-- <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                        </div>
                                    </div><!--end col--> --}}
                                        <div class="col-lg-12" id="accountDiv">
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
                                        <div class="col-lg-12">
                                            <h5 class="mb-3">Update Password</h5>
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
                                                    <input type="password" class="form-control" required name="confirm_password" id="password-fieldz" placeholder="Confirm password">
                                                    <span toggle="#password-fieldz" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success">Change Password</button>
                                                </div>
                                            </div><!--end col-->
                                        </div>
                                    </div>
                                </form>

                                <div class="col-lg-12">
                                    <h5 class="mb-3">Update PIN</h5>
                                    <form method="post" id="pinChange">
                                        @csrf
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="currentPinInput" class="form-label">Current PIN*</label>
                                                    <input type="password" class="form-control" required name="current_pin" id="pin-fielda" maxlength="4" placeholder="Enter current PIN">
                                                    <span toggle="#pin-fielda" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="newPinInput" class="form-label">New PIN*</label>
                                                    <input type="password" class="form-control" required name="new_pin" id="pin-fieldb" maxlength="4" placeholder="Enter new PIN">
                                                    <span toggle="#pin-fieldb" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="confirmPinInput" class="form-label">Confirm PIN*</label>
                                                    <input type="password" class="form-control" required name="confirm_pin" id="pin-fieldz" maxlength="4" placeholder="Confirm new PIN">
                                                    <span toggle="#pin-fieldz" class="fas toggle-password field-icon fa-eye-slash"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary">Update PIN</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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
</main>
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
                success: function(response) {},
                error: function(data) {}
            })
        });

        // Listen for changes in the file input field
        $('.fileInput').change(function() {
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
                    reader.onload = function(e) {
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
                        success: function(response) {},
                        error: function(data) {}
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
            $.get("{{ route('user_details') }}?id=" + id,
                function(data) {
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
                new showCustomAlert("Good Job", postRequest.message, "success");
                $('.preloader').hide();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    new showCustomAlert("Opss", e.message, "error");

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
                new showCustomAlert("Good Job", postRequest.message, "success");
                $('#passwordChange').trigger("reset");
                $('.preloader').hide();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    new showCustomAlert("Opss", e.message, "error");

                }
            }
        })

        $("#pinChange").on('submit', async function(e) {
            e.preventDefault();
            $('.preloader').show();
            const serializedData = $("#pinChange").serializeArray();
            try {
                const postRequest = await request("/change-pin",
                    processFormInputs(
                        serializedData), 'post');
                new showCustomAlert("Good Job", postRequest.message, "success");
                $('#pinChange').trigger("reset");
                $('.preloader').hide();
            } catch (e) {
                $('.preloader').hide();
                if ('message' in e) {
                    new showCustomAlert("Opss", e.message, "error");

                }
            }
        })

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
            formData.append('bank_code', bankCode);
            formData.append('account_number', $("#accountNumberInput").val());

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
                    $("#accountNumberDiv").show()
                    $("#accountName").val(response.data)
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
            const willUpdate = await new showCustomAlert({
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
                new showCustomAlert("User record will not be deleted  :)");
            }
        }

        function performDelete(el, user_id) {
            //alert(user_id);
            try {
                $.get("{{ route('delete_users') }}?id=" + user_id,
                    function(data, status) {
                        if (data.status === "error") {
                            new showCustomAlert("Opss", data.message, "error");
                        } else {
                            if (status === "success") {
                                let alert = new showCustomAlert(" record successfully deleted!.");
                                $(el).closest("tr").remove();
                                window.location.reload();
                                // alert.then(() => {
                                // });
                            }
                        }

                    }
                );
            } catch (e) {
                let alert = new showCustomAlert(e.message);
            }
        }

    })
</script>

@endsection