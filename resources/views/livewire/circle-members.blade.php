<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header d-flex align-items-center justify-content-between bg-light p-3">
                    <h4 class="card-title mb-0 text-primary">{{ $title }}</h4>
                    
                       
                        <span class="badge bg-success-subtle text-success fw-bold d-flex align-items-center p-2">
                            <i class="ri-money-dollar-circle-line me-1"></i>
                            Amount: ₦{{ number_format($group->amount * $members->count(), 2) }}
                        </span>
                    
                </div><!-- end card head end card header -->

                <div class="card-body">
                    <div id="customerList">
                        @if($members->count() > 0)
                        <div class="d-flex flex-column flex-md-row flex-wrap gap-3">

                            @foreach ($members->sortBy('turn') as $index => $transaction)
                            <div class="card flex-fill shadow-sm {{ $transaction->user->id == auth()->user()->id ? 'border-primary border-2 active-turn' : 'border-light' }}" style="min-width: 200px; border-radius: 8px;">
                                <div class="card-body p-1">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary-subtle text-primary rounded-circle p-2 fs-6 me-2">{{ $transaction->turn }}</span>
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-0 text-dark d-flex align-items-center">
                                                <i class="ri-user-3-fill me-1"></i>
                                                <span class="text-truncate">{{ $transaction->user->name }}</span>
                                                @if($transaction->user->id == auth()->user()->id)
                                                <span class="badge bg-success-subtle text-success ms-1">You</span>
                                                @endif
                                            </h6>
                                            @php
                                            $isCurrentTurn = false;
                                            $currentDate = now();
                                            if ($group->mode === 'daily') {
                                            $isCurrentTurn = $currentDate->format('Y-m-d') === $transaction->turn_date;
                                            } elseif ($group->mode === 'weekly') {
                                            $isCurrentTurn = $currentDate->weekOfYear === Carbon\Carbon::parse($transaction->turn_date)->weekOfYear;
                                            } elseif ($group->mode === 'monthly') {
                                            $isCurrentTurn = $currentDate->format('Y-m') === Carbon\Carbon::parse($transaction->turn_date)->format('Y-m');
                                            }

                                            @endphp

                                            @if($transaction->user->id == auth()->user()->id)
                                            <div class="mt-1">
                                                <button class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1 py-0"
                                                    {{ !$isCurrentTurn ? 'disabled' : '' }}
                                                    style="cursor: {{ $isCurrentTurn ? 'pointer' : 'not-allowed' }};">
                                                    Withdraw Funds

                                                </button>
                                                @if(!$isCurrentTurn)
                                                <small class="text-muted d-block" style="font-size: 0.7rem;">Not your turn yet</small>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                        @if($transaction->user->id == auth()->user()->id)
                                        <lord-icon src="https://cdn.lordicon.com/xsdtfyne.json"
                                            trigger="loop"
                                            colors="primary:#0ab39c,secondary:#405189"
                                            style="width:30px;height:30px">
                                        </lord-icon>
                                        @endif
                                    </div>
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

        0%,
        100% {
            background-position: 0 0;
        }

        50% {
            background-position: 400% 0;
        }
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