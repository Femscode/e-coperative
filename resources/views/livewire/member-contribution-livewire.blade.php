<div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div id="customerList">
                        <!-- Search Box -->
                        <div class="position-relative mb-4">
                            <input type="text" class="form-control search-input" wire:model="search" placeholder="Search contributions...">
                            <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>

                        <!-- Cards Grid -->
                        <div class="row g-3">
                            @if($loans->count() > 0)
                            @foreach ($loans as $transaction)
                            <div class="col-md-6 col-lg-4">
                                <div class="contribution-card">
                                    <div class="card-status {{ $transaction->status == 0 ? 'status-processing' : 'status-ongoing' }}">
                                        @if($transaction->status == 0)
                                        <i class="bi bi-clock-history"></i> Processing
                                        @else
                                        <i class="bi bi-play-circle"></i> Ongoing
                                        @endif
                                    </div>

                                    <div class="card-content">
                                        <h5 class="contribution-title mb-2">{{ $transaction->title }}</h5>

                                        <div class="contribution-amount mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="amount-label">Amount</span>
                                                <span class="amount-value">₦{{ number_format($transaction->amount, 2) }}</span>
                                            </div>
                                        </div>


                                        <div class="members-info mb-3">
                                            <a href="{{ route('admin_group_members', $transaction->uuid) }}" class="members-link">
                                                <i class="bi bi-people"></i>
                                                <span>{{ $transaction->members->count() }} members joined</span>
                                            </a>
                                            <a class="members-link">

                                                <i class="bi bi-calendar-check text-primary mb-1"></i>
                                                <span class="label"><b>Mode - </b></span>
                                                <span class="value">{{ $transaction->mode }}</span>
                                            </a>
                                        </div>

                                        <div class="card-actions">
                                            <button class="btn copy-btn" data-link="{{ $transaction->link }}">
                                                <i class="bi bi-link-45deg"></i> Copy Link
                                            </button>


                                            <a class="btn view-btn btn-success" href="{{route('circle-members', $transaction->uuid)}}">
                                                <i class="bi bi-eye"></i> View Turns
                                            </a>
                                        </div>
                                        <div class="card-actions">
                                            @if($transaction->status == 0 && $transaction->company_id == auth()->user()->id)
                                            <button class="btn btn-success btn-sm approveButton"
                                                data-id="{{ $transaction->id }}">
                                                <i class="bi bi-play-circle me-1"></i> Start
                                            </button>
                                            <button class="btn btn-danger btn-sm deleteButton" data-id="{{ $transaction->id }}">
                                                <i class="bi bi-trash me-1"></i> Delete Group
                                            </button>
                                            @else
                                            <a href="{{ route('member-contribution-dues', $transaction->uuid) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="bi bi-eye me-1"></i> View Dues
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="col-12">
                                <div class="text-center py-4">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                        trigger="loop" colors="primary:#094168,secondary:#22c55e"
                                        style="width:60px;height:60px">
                                    </lord-icon>
                                    <h5 class="mt-2">No Contributions Found</h5>
                                    <p class="text-muted small">Try adjusting your search or create a new contribution</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-end mt-4">
                            <div class="pagination-wrap">
                                {{ $loans->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .search-input {
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        padding-right: 3rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #094168;
        box-shadow: 0 0 0 0.2rem rgba(9, 65, 104, 0.1);
    }

    .contribution-card {
        background: linear-gradient(145deg, #f5f7ff, #ffffff);
        border-radius: 0.75rem;
        padding: 1.25rem;
        position: relative;
        border: 1px solid rgba(9, 65, 104, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        box-shadow: 4px 4px 8px rgba(9, 65, 104, 0.05),
            -4px -4px 8px rgba(255, 255, 255, 0.9);
    }

    .card-content {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .contribution-title {
        font-size: 1.1rem;
        font-weight: 600;
        padding-right: 5rem;
        line-height: 1.3;
    }


    .contribution-amount {
        background: rgba(9, 65, 104, 0.05);
        padding: 0.75rem;
        border-radius: 0.5rem;
    }

    .amount-label {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .amount-value {
        font-size: 1.25rem;
        font-weight: 600;
        color: #094168;
    }

    .contribution-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .detail-item {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .detail-item i {
        font-size: 1.1rem;
    }

    .detail-item .label {
        font-size: 0.7rem;
        color: #6c757d;
        margin-bottom: 0.1rem;
    }

    .detail-item .value {
        font-size: 0.85rem;
        font-weight: 500;
    }

    .members-info {
        padding: 0.5rem 0;
        border-top: 1px solid #e0e0e0;
        border-bottom: 1px solid #e0e0e0;
    }

    .card-actions {
        margin-top: auto;
        display: flex;
        gap: 0.5rem;
    }

    .card-actions .btn {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    .contribution-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .card-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-processing {
        background: #fff8e1;
        color: #f59e0b;
    }

    .status-ongoing {
        background: #e8f5e9;
        color: #22c55e;
    }



    .members-link {
        color: #094168;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }


    .copy-btn {
        background: #e8f0fe;
        color: #094168;
        border: none;
    }

    .copy-btn:hover {
        background: #d0e1fd;
    }

    .view-btn {
        background: #094168;
        color: #fff;
        border: none;
    }

    .view-btn:hover {
        background: #073251;
    }

    @media (max-width: 768px) {
        .contribution-card {
            padding: 1rem;
        }

        .contribution-details {
            grid-template-columns: repeat(2, 1fr);
        }
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
                                        timer: 2000,  // 2 seconds
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

    $('body').on('click', '.approveButton', function() {
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert("here")
            startAccount(el, id);
        });
        async function startAccount(el, id) {
            const willUpdate = await new swal({
                title: "Confirm User Action",
                text: `Are you sure you want to start this contribution?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Am In!"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performStart(el, id);
            } 
        }

        function performStart(el, id) {
            $('.approveButton').prop('disabled', true).text('Loading ...');
            try {
                // alert(data);
                $.get("{{ route("member-start-contribution") }}?id=" + id,
                    function(data, status) {
                        // console.log(data, status);
                        //    alert(data.message)
                        if (data.status == "ok") {
                            let alert = new swal("Good Job", data.message, "success");
                            window.location.href = "{{ route('my-contribution') }}";
                        } else {
                            $('.approveButton').prop('disabled', false).text('Start');
                            new swal("Opss", data.message, "error");
                        }

                    }
                );
            } catch (e) {
                $('.approveButton').prop('disabled', false).text('Start');
                // alert("here")
                let alert = new swal("Opss", e.message, "error");
            }
        }

        $(".copy-btn").on('click', function() {
            const link = $(this).data("link");
            navigator.clipboard.writeText(link)
                .then(() => {
                    Swal.fire({
 
                        icon: 'success',
                        title: 'Link Copied',
                        text: 'Link copied: ' + link
                    });
                })
                .catch(err => {
                    console.error("Failed to copy: ", err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to copy link.'
                    });
                });
        });


</script>