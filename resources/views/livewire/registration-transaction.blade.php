<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">{{ $title }}</h4>
                <div class="search-box">
                    <input type="text" class="form-control search-input" wire:model="search" placeholder="Search transactions...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>

            <div class="card-body">
                <div id="customerList">
                    @if($transactions->count() > 0)
                        <div class="transaction-list">
                            @foreach ($transactions as $transaction)
                            <div class="transaction-item" data-type="{{ $transaction->payment_type }}" data-status="{{ $transaction->status ?? 'success' }}">
                                <div class="t-icon">
                                    <i class="ri-user-add-line"></i>
                                </div>
                                <div class="t-info">
                                    <div class="t-user">{{ $transaction->user->name ?? "Unknown" }}</div>
                                    <div class="t-type">{{ $transaction->payment_type }}</div>
                                </div>
                                <div class="t-details">
                                    <div class="t-date">{{ $transaction->updated_at->format('M d, Y. h:ia') }}</div>
                                </div>
                                <div class="t-amount" data-status="{{ $transaction->status ?? 'success' }}">
                                    ₦{{ number_format($transaction->amount, 2) }}
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
                                <h5 class="mt-2">No Transactions Found</h5>
                            </div>
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-end mt-3">
                        <div class="pagination-wrap">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>