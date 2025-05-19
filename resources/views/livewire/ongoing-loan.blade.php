<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ $title }}</h4>
                    <div class="search-box">
                        <input type="text" class="form-control search-input" wire:model="search" placeholder="Search loans...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>

                <div class="card-body">
                    <div id="customerList">
                        @if($loans->count() > 0)
                        <div class="transaction-list">
    @foreach ($loans as $transaction)
    <div class="transaction-item bg-light rounded-3 p-3 mb-3 border-start border-4 {{ $transaction->status === 'completed' ? 'border-success' : 'border-primary' }}">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="transaction-icon rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="ri-money-dollar-circle-line fs-4 text-primary"></i>
                </div>
                <div class="transaction-details">
                    <h5 class="mb-1">{{ $transaction->member->name }}</h5>
                    <div class="d-flex align-items-center gap-3 text-muted small">
                        <span>Monthly Return: <strong class="text-dark">₦{{ number_format($transaction->monthly_return, 2) }}</strong></span>
                        <span class="vr"></span>
                        <span>Refund: <strong class="text-dark">₦{{ number_format($transaction->total_refund, 2) }}</strong></span>
                    </div>
                </div>
            </div>
            <div class="text-end">
                <div class="transaction-amount mb-1">
                    <span class="fs-5 fw-semibold text-primary">₦{{ number_format($transaction->total_applied, 2) }}</span>
                </div>
                <div class="transaction-meta small text-muted">
                    <span class="me-2">{{ $transaction->applied_date }}</span>
                    <span class="vr"></span>
                    <span class="ms-2">Balance: <strong class="text-dark">₦{{ number_format($transaction->total_left, 2) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
                        @else
                            <div class="noresult">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#4318FF,secondary:#1BE7FF" style="width:75px;height:75px">
                                    </lord-icon>
                                    <h5 class="mt-2">No Ongoing Loans Found</h5>
                                </div>
                            </div>
                        @endif
                        
                        <div class="d-flex justify-content-end mt-3">
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