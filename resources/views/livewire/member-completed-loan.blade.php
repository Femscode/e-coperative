<div>
    <div class="container mt-4">
        <!-- Navigation Tabs -->
        <div class="loan-nav-wrapper mb-4">
            <div class="row g-2">
                <div class="col-6">
                    <a href="/member/loan" class="nav-link text-center py-3 h-100 ">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-plus-circle me-1"></i>
                            <span>Request Loan</span>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/member/loan-repayment" class="nav-link text-center py-3 h-100">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-hourglass-split me-1"></i>
                            <span>Repayments</span>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/member/loan/ongoing" class="nav-link text-center py-3 h-100">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-repeat me-1"></i>
                            <span>Ongoing Loans</span>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/member/loan/completed" class="nav-link text-center py-3 h-100 active2 {{ request()->is('member/loan-repayment/completed*') ? 'active' : '' }}">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="bi bi-check-circle me-1"></i>
                            <span>Completed Loans</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle fs-4 me-2 text-success"></i>
                                <h5 class="card-title mb-0">{{ $title }}</h5>
                            </div>
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control rounded-pill" wire:model="search" placeholder="Search loans...">
                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="table-responsive">
                            @if($loans->count() > 0)
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Member</th>
                                        <th class="text-end">Amount</th>
                                        <th class="text-end">Total Refund</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $transaction)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm me-3">
                                                    <div class="avatar-title bg-light text-primary rounded-circle">
                                                        {{ substr($transaction->member->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $transaction->member->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">₦{{ number_format($transaction->total_applied, 2) }}</td>
                                        <td class="text-end">₦{{ number_format($transaction->total_refund, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                        trigger="loop" colors="primary:#094168,secondary:#22c55e"
                                        style="width:80px;height:80px">
                                    </lord-icon>
                                </div>
                                <h5>No Completed Loans</h5>
                                <p class="text-muted">There are no completed loans at the moment.</p>
                            </div>
                            @endif
                        </div>

                        @if($loans->count() > 0)
                        <div class="d-flex justify-content-end mt-4">
                            {{ $loans->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .loan-nav-wrapper {
        background: #fff;
        border-radius: 0.5rem;
        padding: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .nav-tabs-custom {
        border: 0;
        gap: 0.5rem;
    }

    .nav-tabs-custom .nav-link {
        border: 0;
        padding: 0.75rem 1.25rem;
        border-radius: 0.5rem;
        color: #6c757d;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs-custom .nav-link:hover {
        color: #094168;
        background: rgba(9, 65, 104, 0.05);
    }

    .active2 {
        color: #094168 !important;
        background: rgba(9, 65, 104, 0.1) !important;
        border: none;
        box-shadow: 0 1px 2px rgba(9, 65, 104, 0.1);
    }

    .search-box .form-control {
        padding-right: 2.5rem;
    }

    .avatar {
        width: 2.5rem;
        height: 2.5rem;
    }

    .avatar-title {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 500;
    }

    .table th {
        font-weight: 600;
        background: #f8f9fa;
    }

    .table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .pagination {
        margin: 0;
        gap: 0.25rem;
    }

    .page-link {
        border-radius: 0.25rem;
        padding: 0.5rem 0.75rem;
        color: #094168;
        border: none;
    }

    .page-link:hover {
        background: rgba(9, 65, 104, 0.05);
        color: #094168;
    }

    .page-item.active .page-link {
        background: #094168;
        color: #fff;
    }
</style>