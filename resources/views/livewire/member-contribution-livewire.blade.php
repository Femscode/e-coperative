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
                        <div class="row g-4">
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
                                        
                                        <h5 class="contribution-title">{{ $transaction->title }}</h5>
                                        
                                        <div class="contribution-amount">
                                            <span class="amount-label">Amount</span>
                                            <span class="amount-value">₦{{ number_format($transaction->amount, 2) }}</span>
                                        </div>
                                        
                                        <div class="contribution-details">
                                            <div class="detail-item">
                                                <span class="label">Mode</span>
                                                <span class="value">{{ $transaction->mode }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Min</span>
                                                <span class="value">{{ $transaction->min }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="label">Max</span>
                                                <span class="value">{{ $transaction->max }}</span>
                                            </div>
                                        </div>

                                        <div class="members-info">
                                            <a href="{{ route('admin_group_members', $transaction->uuid) }}" class="members-link">
                                                <i class="bi bi-people"></i>
                                                <span>{{ $transaction->members->count() }} members joined</span>
                                            </a>
                                        </div>
                                        
                                        <div class="card-actions">
                                            <button class="btn copy-btn" data-link="{{ $transaction->link }}">
                                                <i class="bi bi-link-45deg"></i> Copy Link
                                            </button>
                                            <a class="btn view-btn" href="{{route('circle-members', $transaction->uuid)}}">
                                                <i class="bi bi-eye"></i> View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" 
                                            trigger="loop" colors="primary:#094168,secondary:#22c55e" 
                                            style="width:80px;height:80px">
                                        </lord-icon>
                                        <h5 class="mt-3">No Contributions Found</h5>
                                        <p class="text-muted">Try adjusting your search or create a new contribution</p>
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
    background: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    position: relative;
    border: 1px solid #e0e0e0;
    transition: all 0.3s ease;
}

.contribution-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
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

.contribution-title {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    padding-right: 6rem;
}

.contribution-amount {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.75rem;
    margin-bottom: 1rem;
}

.amount-label {
    display: block;
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.amount-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: #094168;
}

.contribution-details {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
}

.detail-item {
    text-align: center;
}

.detail-item .label {
    display: block;
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.detail-item .value {
    font-weight: 500;
}

.members-info {
    padding: 0.75rem 0;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    margin-bottom: 1rem;
}

.members-link {
    color: #094168;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-actions {
    display: flex;
    gap: 0.5rem;
}

.card-actions .btn {
    flex: 1;
    padding: 0.75rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
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