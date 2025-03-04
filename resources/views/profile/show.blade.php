{{-- @extends('layouts.master') --}}
@extends('cooperative.admin.master')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h4 class="card-title mb-0">My Profile</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                @if($user->profile_image)
                                    <img src="https://syncosave.com/synco_files/public/{{ $user->profile_image }}"
                                         alt="{{ $user->name }}'s profile"
                                         class="rounded-circle avatar-lg mb-3">
                                @elseif($user->photo)
                                    <img src="https://syncosave.com/synco_files/public/{{ $user->photo }}"
                                         alt="{{ $user->name }}'s profile"
                                         class="rounded-circle avatar-lg mb-3">
                                @else
                                    <img src="{{ url('assets/images/avatar.png') }}"
                                         alt="Default Avatar"
                                         class="rounded-circle avatar-lg mb-3">
                                @endif
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-0">{{ $user->username ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Full Name:</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Username:</th>
                                            <td>{{ $user->username ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Email:</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Phone:</th>
                                            <td>{{ $user->phone ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">User Type:</th>
                                            <td>{{ ucfirst($user->user_type) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address:</th>
                                            <td>{{ $user->address ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">City:</th>
                                            <td>{{ $user->city ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">State:</th>
                    <td>{{ $user->state ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <th scope="row">Country:</th>
                    <td>{{ $user->country ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <th scope="row">Gender:</th>
                    <td>{{ $user->gender ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <th scope="row">Joined:</th>
                    <td>{{ $user->created_at->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <th scope="row">Account Type:</th>
                    <td>
                        @if($user->plan_id)
                            {{ $user->plan()->type == 1 ? 'Cooperative' : 'Ajo' }}
                        @else
                            Not specified
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">Bank Account:</th>
                    <td>
                        {{ $user->account_name ?? 'Not provided' }} 
                        ({{ $user->account_number ?? '' }} / {{ $user->bank_code ?? '' }})
                    </td>
                </tr>
                <tr>
                    <th scope="row">Bio:</th>
                    <td>{{ $user->bio ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <th scope="row">Referred By:</th>
                    <td>{{ $user->referred_by ?? 'Not provided' }}</td>
                </tr>
                <tr>
                    <th scope="row">Two-Factor Auth:</th>
                    <td>{{ $user->tfa == 1 ? 'Enabled' : 'Disabled' }}</td>
                </tr>
                <tr>
                    <th scope="row">Status:</th>
                    <td>{{ $user->active == 1 ? 'Active' : 'Inactive' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="bx bx-edit-alt me-1"></i> Edit Profile
        </a>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add any profile-specific JavaScript here if needed
    });
</script>
@endsection