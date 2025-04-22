<div class="member-dashboard">
    <div class="row g-3">
        <div class="col-lg-12">
            <!-- Search and Filter Section -->
            <div class="search-filter-wrapper mb-4">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="search-box-lg">
                            <i class="ri-search-2-line search-icon"></i>
                            <input type="text" class="form-control form-control-lg" wire:model="search"
                                placeholder="Search members by name, email or Coop ID">
                        </div>
                    </div>
                    <div class="col-lg-6 text-end">
                        <div class="view-options">
                            <button class="btn btn-soft-primary active" data-view="grid">
                                <i class="ri-grid-fill"></i>
                            </button>
                            <button class="btn btn-soft-primary" data-view="list">
                                <i class="ri-list-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Members Grid -->
            <!-- ... existing search section remains the same ... -->

            <!-- Members Grid -->
            <div class="row g-2">
                @foreach ($members as $member)
                <div class="col-xl-4 col-lg-6">
                    <div class="card member-card">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center">
                                <div class="member-avatar-wrapper me-3">
                                    <div class="member-avatar">
                                        <img @if($member->cover_image)
                                        src="https://syncosave.com/synco_files/public/{{ $member->profile_image }}"
                                        @else
                                        src="{{ asset('admindashboard/images/avatar.png') }}"
                                        @endif
                                        alt="{{ $member->name }}"
                                        class="img-fluid rounded-circle">
                                        <div class="member-status {{ $member->refers()->count() > 10 ? 'status-gold' : ($member->refers()->count() > 5 ? 'status-silver' : 'status-bronze') }}">
                                            <i class="ri-verified-badge-fill"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="member-info flex-grow-1">
                                    <h6 class="member-name mb-1">{{ $member->name }}</h6>
                                    <span class="badge bg-soft-primary text-primary mb-2">
                                        <i class="ri-profile-line me-1"></i>{{ $member->coop_id }}
                                    </span>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-item">
                                            <small class="text-muted d-block">Referrals</small>
                                            <span class="fw-medium">{{ $member->refers()->count() }}</span>
                                        </div>
                                       
                                    </div>
                                </div>

                                <div class="member-actions">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin-member-details', $member->id) }}"
                                            class="btn btn-soft-primary">
                                            <i class="ri-user-line"></i>
                                        </a>
                                        <a href="{{ route('admin-member-transactions', $member->id) }}"
                                            class="btn btn-soft-info">
                                            <i class="ri-exchange-dollar-line"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- ... pagination remains the same ... -->

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</div>

<style>
/* ... existing styles remain the same ... */

/* Updated and new styles */
.member-avatar-wrapper {
    width: 60px;
    height: 60px;
}

.member-status {
    width: 20px;
    height: 20px;
}

.member-card {
    margin-bottom: 0.5rem;
}

.member-card .card-body {
    padding: 1rem;
}

.member-name {
    font-size: 0.95rem;
    line-height: 1.2;
}

.stat-item {
    font-size: 0.85rem;
}

.rating-stars {
    font-size: 0.85rem;
}

.member-actions .btn {
    padding: 0.25rem 0.5rem;
}

.btn-group-sm>.btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>