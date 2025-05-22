<div class="member-dashboard">
    <div class="row g-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ $title }}</h4>
                    <!-- <div class="search-box-lg">
                        <i class="ri-search-2-line search-icon"></i>
                        <input type="text" class="form-control form-control-lg" wire:model="search"
                            placeholder="Search groups...">
                    </div> -->
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        @if($loans->count() > 0)
                        @foreach ($loans as $transaction)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="card member-card h-100">
                                <div class="card-body p-4">
                                    <div class="group-header mb-3">
                                        <h5 class="group-title">{{ $transaction->title }}</h5>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="group-badge">
                                                <span class="badge bg-{{ $transaction->status == 0 ? 'warning' : 'info' }}">
                                                    {{ $transaction->status == 0 ? 'Processing' : 'Ongoing' }}
                                                </span>
                                            </div>
                                            @if($transaction->status == 0 && $transaction->company_id == auth()->user()->id)
                                            <button class="btn btn-soft-danger btn-sm deleteButton" data-id="{{ $transaction->id }}">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="group-details">
                                        <div class="detail-row">
                                            <div class="detail-item">
                                                <span class="text-muted">Amount</span>
                                                <h6 class="mb-0">₦{{ number_format($transaction->amount, 2) }}</h6>
                                            </div>
                                            <div class="detail-item">
                                                <span class="text-muted">Mode</span>
                                                <h6 class="mb-0">{{ $transaction->mode }}</h6>
                                            </div>
                                        </div>

                                        <div class="detail-row">
                                            <div class="detail-item">
                                                <span class="text-muted">Min</span>
                                                <h6 class="mb-0">{{ $transaction->min }}</h6>
                                            </div>
                                            <div class="detail-item">
                                                <span class="text-muted">Max</span>
                                                <h6 class="mb-0">{{ $transaction->max }}</h6>
                                            </div>
                                            <div class="detail-item">
                                                <span class="text-muted">Members</span>
                                                <h6 class="mb-0">
                                                    <a href="{{ route('admin_group_members', $transaction->uuid) }}"
                                                        class="text-primary">
                                                        {{ $transaction->members->count() }}
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="group-actions mt-3">
                                        <button class="btn btn-soft-primary btn-sm copy-btn"
                                            data-link="{{ $transaction->link }}">
                                            <i class="ri-file-copy-line me-1"></i> Copy Link
                                        </button>

                                        @if($transaction->status == 0 && $transaction->company_id == auth()->user()->id)
                                        <button class="btn btn-soft-success btn-sm approveButton"
                                            data-id="{{ $transaction->id }}">
                                            <i class="ri-play-circle-line me-1"></i> Start
                                        </button>
                                        @else
                                        <a href="{{ route('contribution-dues', $transaction->uuid) }}"
                                            class="btn btn-soft-info btn-sm">
                                            <i class="ri-eye-line me-1"></i> View Dues
                                        </a>
                                        @endif

                                        <a href="{{route('circle-members', $transaction->uuid)}}"
                                            class="btn btn-soft-secondary btn-sm">
                                            <i class="ri-eye-line me-1"></i> View Turns
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <div class="noresult">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#4318FF,secondary:#1BE7FF" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">No Groups Found</h5>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        {{ $loans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .group-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .group-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3038;
        margin-bottom: 0;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-item {
        text-align: center;
        flex: 1;
    }

    .detail-item span {
        font-size: 0.8rem;
        display: block;
        margin-bottom: 0.3rem;
    }

    .group-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-soft-primary,
    .btn-soft-success,
    .btn-soft-info {
        padding: 0.4rem 1rem;
        font-size: 0.875rem;
    }

    .search-box-lg {
        position: relative;
        min-width: 300px;
    }

    .search-box-lg .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .search-box-lg .form-control {
        padding-left: 2.5rem;
        border-radius: 20px;
        height: 2.8rem;
    }

    .member-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-soft-danger {
        background-color: rgba(255, 74, 74, 0.1);
        color: #FF4A4A;
        border: none;
        padding: 0.25rem 0.5rem;
    }

    .btn-soft-danger:hover {
        background-color: #FF4A4A;
        color: #fff;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete button clicks
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function() {
                const groupId = this.getAttribute('data-id');

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/member-delete-contribution/${groupId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'ok') {
                                    // Refresh the page or update UI as needed
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message,
                                        icon: 'success',
                                        timer: 2000, // 2 seconds
                                        showConfirmButton: false
                                    }).then(() => {
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 500);
                                    });
                                } else {
                                    alert('Failed to delete contribution group');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while deleting the contribution group');
                            });
                    }
                });
            });
        });
    });

    // Listen for success/error events from Livewire
    window.addEventListener('groupDeleted', event => {
        Swal.fire(
            'Deleted!',
            'Contribution group has been deleted.',
            'success'
        );
    });

    window.addEventListener('deletionError', event => {
        Swal.fire(
            'Error!',
            event.detail.message,
            'error'
        );
    });


</script>