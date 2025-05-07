<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header d-flex align-items-center bg-light">
                    <h4 class="card-title mb-0 text-primary">{{ $title }}</h4>
                    <span class="ms-auto badge bg-info-subtle text-info fw-bold">Total {{ $members->count() }} Members</span>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customerList">
                        @if($members->count() > 0)
                        <div class="d-flex flex-column flex-md-row flex-wrap gap-3">
                           
                            @foreach ($members->sortBy('turn') as $index => $transaction)
                            <div class="card flex-fill shadow-sm {{ $transaction->user->id == auth()->user()->id ? 'border-primary border-2 active-turn' : 'border-light' }}" style="min-width: 250px; border-radius: 10px;">
                                <div class="card-body d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <span class="badge bg-primary-subtle text-primary rounded-circle p-3 fs-5">{{ $transaction->turn }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="card-title mb-1 text-dark">
                                            <i class="ri-user-3-fill me-2"></i>{{ $transaction->user->name }}
                                            @if($transaction->user->id == auth()->user()->id)
                                                <span class="badge bg-success-subtle text-success ms-2">You</span>
                                            @endif
                                        </h6>
                                        <p class="card-text mb-1 text-muted">Turn {{ $transaction->turn }}</p>
                                        <span class="badge {{ $transaction->user->id == auth()->user()->id ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ $transaction->user->id == auth()->user()->id ? 'Your Turn' : 'Waiting' }}
                                        </span>
                                    </div>
                                    @if($transaction->user->id == auth()->user()->id)
                                        <div class="ms-2">
                                            <lord-icon src="https://cdn.lordicon.com/xsdtfyne.json" trigger="loop"
                                                colors="primary:#0ab39c,secondary:#405189" style="width:40px;height:40px">
                                            </lord-icon>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="noresult">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                            </div>
                        </div>
                        @endif

                        <!-- Progress Bar for Turn Visualization -->
                        @if($members->count() > 0)
                        <div class="mt-4">
                            <h6 class="mb-3 text-dark">Contribution Circle Progress</h6>
                            <div class="progress bg-light" style="height: 25px; border-radius: 12px;">
                                @php
                                    $currentTurn = $members->where('user.id', auth()->user()->id)->first()->turn ?? 1;
                                    $totalTurns = $members->count();
                                    $progressPercentage = ($currentTurn / $totalTurns) * 100;
                                @endphp
                                <div class="progress-bar progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ $progressPercentage }}%; background: linear-gradient(45deg, #0ab39c, #405189);"
                                     aria-valuenow="{{ $progressPercentage }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    Turn {{ $currentTurn }} of {{ $totalTurns }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $members->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>

<!-- Custom CSS for Enhanced Styling -->
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #ffffff;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    .active-turn {
        box-shadow: 0 0 15px rgba(11, 179, 156, 0.3);
        background: linear-gradient(145deg, #f8f9fa, #ffffff);
    }
    .badge.rounded-circle {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        font-weight: 600;
    }
    .progress-bar-animated {
        animation: progressAnimation 2s ease-in-out infinite;
    }
    @keyframes progressAnimation {
        0%, 100% { background-position: 0 0; }
        50% { background-position: 400% 0; }
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
    }
    .text-primary {
        color: #405189 !important;
    }
    @media (max-width: 576px) {
        .card {
            min-width: 100%;
        }
        .badge.rounded-circle {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>