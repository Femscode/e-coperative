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
                            <div class="transaction-item" data-type="Loan" data-status="{{ $transaction->approval_status == 0 ? 'pending' : 'processing' }}">
                                <div class="t-icon">
                                    <i class="ri-bank-card-line"></i>
                                </div>
                                <div class="t-info">
                                    <div class="t-user">{{ $transaction->member->name }}</div>
                                    <div class="t-type">Monthly Return: ₦{{ number_format($transaction->monthly_return, 2) }}</div>
                                </div>
                                <div class="t-details">
                                    <div class="t-date">{{ $transaction->applied_date }}</div>
                                </div>
                                <div class="t-amount" data-status="{{ $transaction->approval_status == 0 ? 'pending' : 'processing' }}">
                                    ₦{{ number_format($transaction->total_applied, 2) }}
                                    @if($transaction->member->checkLoanApplicationStatus())
                                    @if($transaction->approval_status == 0)
                                        <button class="btn approveButton rounded-pill btn-sm btn-soft-info ms-2" data-id="{{ $transaction->id }}">Approve</button>
                                    @else
                                        <span class="badge bg-info ms-2">Processing</span>
                                    @endif
                                    @else  
                                    <span class="badge bg-danger ms-2">Awaiting form payment</span>
                                    @endif
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
                                <h5 class="mt-2">No Loan Applications Found</h5>
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