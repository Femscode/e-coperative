<style>
        .withdrawal-steps {
        transition: all 0.3s ease;
    }
    
    .step-indicator {
        min-width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .step-status {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .step-status.completed {
        background-color: #e6f7e9;
    }
    
    .step-status.pending {
        background-color: #f8f9fa;
    }
    
    .step-line {
        position: absolute;
        left: 50%;
        top: 100%;
        height: 24px;
        width: 2px;
        background: #dee2e6;
        transform: translateX(-50%);
    }
    
    .step:last-child .step-line {
        display: none;
    }
    
    .step.active .step-line {
        background: #405189;
    }
    
    .step.active small {
        font-size: 0.9rem;
    }
    
    .spinner-grow {
        width: 1.2rem;
        height: 1.2rem;
    }
</style>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header d-flex align-items-center justify-content-between bg-light p-3">
                    <h4 class="card-title mb-0 text-primary">{{ $title }}</h4>


                    <span class="badge bg-success-subtle text-success fw-bold d-flex align-items-center p-2">
                        <i class="ri-money-dollar-circle-line me-1"></i>
                        Amount: ₦{{ number_format($group->amount * $members->count(), 2) }}
                        <input type="hidden" id="real_amount" value="{{ number_format($group->amount * $members->count(), 2, '.', '') }}">
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
                                                $isCurrentTurn = $currentDate->format('Y-m-d') === $transaction->created_at->format('Y-m-d');
                                            } elseif ($group->mode === 'weekly') {
                                                $isCurrentTurn = $currentDate->weekOfYear === Carbon\Carbon::parse($transaction->turn_date)->weekOfYear;
                                            } elseif ($group->mode === 'monthly') {
                                                $isCurrentTurn = $currentDate->format('Y-m') === Carbon\Carbon::parse($transaction->turn_date)->format('Y-m');
                                            }
                                            @endphp

                                            @if($transaction->user->id == auth()->user()->id)
                                            <div class="mt-1">
                                                @php
                                                $withdraw_status = $transaction->user->checkWithdrawalStatus($group->uuid);
                                                @endphp
                                                
                                                @if($withdraw_status)
                                                    @if($withdraw_status->status == 1)
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-checkbox-circle-fill text-success me-1"></i>
                                                            <span class="text-success">Payment Completed</span>
                                                        </div>
                                                    @elseif($withdraw_status->status == 0)
                                                        <button onclick="initiateWithdrawal('{{ $group->uuid }}')" 
                                                                class="btn btn-primary d-inline-flex align-items-center"
                                                                {{ !$isCurrentTurn ? 'disabled' : '' }}
                                                                style="cursor: {{ !$isCurrentTurn ? 'not-allowed' : 'pointer' }};">
                                                            <i class="ri-bank-card-line me-1"></i>
                                                            Withdraw Funds
                                                        </button>
                                                    @else
                                                        @php
                                                        $created = \Carbon\Carbon::parse($withdraw_status->created_at);
                                                        $now = \Carbon\Carbon::now();
                                                        $minutesPassed = $created->diffInMinutes($now);
                                                        @endphp
                                                        <div class="withdrawal-steps mt-3 p-3 bg-light rounded-3 border">
                                                            <div class="step d-flex align-items-center mb-3 {{ $minutesPassed < 30 ? 'active' : '' }}">
                                                                <div class="step-indicator position-relative me-3">
                                                                    @if($minutesPassed >= 30)
                                                                        <div class="step-status completed">
                                                                            <i class="ri-check-line text-success"></i>
                                                                        </div>
                                                                    @elseif($minutesPassed < 30)
                                                                        <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                                                            <span class="visually-hidden">Loading...</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="step-status pending">
                                                                            <i class="ri-time-line text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                    <div class="step-line"></div>
                                                                </div>
                                                                <small class="{{ $minutesPassed >= 30 ? 'text-success' : ($minutesPassed < 30 ? 'text-primary fw-medium' : 'text-muted') }}">Running background check...</small>
                                                            </div>
                                                            
                                                            <div class="step d-flex align-items-center mb-3 {{ $minutesPassed >= 30 && $minutesPassed < 60 ? 'active' : '' }}">
                                                                <div class="step-indicator position-relative me-3">
                                                                    @if($minutesPassed >= 60)
                                                                        <div class="step-status completed">
                                                                            <i class="ri-check-line text-success"></i>
                                                                        </div>
                                                                    @elseif($minutesPassed >= 30 && $minutesPassed < 60)
                                                                        <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                                                            <span class="visually-hidden">Loading...</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="step-status pending">
                                                                            <i class="ri-time-line text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                    <div class="step-line"></div>
                                                                </div>
                                                                <small class="{{ $minutesPassed >= 60 ? 'text-success' : ($minutesPassed >= 30 && $minutesPassed < 60 ? 'text-primary fw-medium' : 'text-muted') }}">Verifying account details...</small>
                                                            </div>
                                                            
                                                            <div class="step d-flex align-items-center {{ $minutesPassed >= 60 ? 'active' : '' }}">
                                                                <div class="step-indicator position-relative me-3">
                                                                    @if($minutesPassed >= 60)
                                                                        <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                                                            <span class="visually-hidden">Loading...</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="step-status pending">
                                                                            <i class="ri-time-line text-muted"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <small class="{{ $minutesPassed >= 60 ? 'text-primary fw-medium' : 'text-muted' }}">Initiating secure payout...</small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <button onclick="initiateWithdrawal('{{ $group->uuid }}')" 
                                                            class="btn btn-primary d-inline-flex align-items-center"
                                                            {{ !$isCurrentTurn ? 'disabled' : '' }}
                                                            style="cursor: {{ !$isCurrentTurn ? 'not-allowed' : 'pointer' }};">
                                                        <i class="ri-bank-card-line me-1"></i>
                                                        Withdraw Funds
                                                    </button>
                                                @endif

                                                @if(!$isCurrentTurn)
                                                    <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">
                                                        <i class="ri-information-line me-1"></i>
                                                        Not your turn
                                                    </small>
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

<script>
    function initiateWithdrawal(transactionId) {
        console.log(transactionId)
        // First fetch user profile with bank details
        fetch(`/fetch-profile`)
            .then(response => response.json())
            .then(profile => {
                // Show confirmation modal with bank details
                Swal.fire({
                    title: 'Withdrawal Details',
                    html: `
                        <div class="text-left">
                                                <p class="mb-2"><strong>Amount:</strong> ₦${parseFloat(document.getElementById('real_amount').value).toLocaleString('en-NG', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
                                                <p class="mb-2"><strong>Account Number:</strong> ${profile.account_number}</p>
                                                <p class="mb-2"><strong>Account Name:</strong> ${profile.account_name}</p>
                        <p class="mb-2"><strong>Bank Name:</strong> ${profile.bank_name}</p>
                        </div>
                    `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Proceed',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show PIN input modal
                        Swal.fire({
                            title: 'Enter Your PIN',
                            html: `
                                <div class="pin-input-container d-flex justify-content-center gap-2">
                                    <input type="text" class="form-control pin-input text-center" maxlength="1" inputmode="numeric" pattern="[0-9]*" style="width: 50px; height: 50px; font-size: 24px;">
                                    <input type="text" class="form-control pin-input text-center" maxlength="1" inputmode="numeric" pattern="[0-9]*" style="width: 50px; height: 50px; font-size: 24px;">
                                    <input type="text" class="form-control pin-input text-center" maxlength="1" inputmode="numeric" pattern="[0-9]*" style="width: 50px; height: 50px; font-size: 24px;">
                                    <input type="text" class="form-control pin-input text-center" maxlength="1" inputmode="numeric" pattern="[0-9]*" style="width: 50px; height: 50px; font-size: 24px;">
                                </div>
                                <input type="hidden" id="complete-pin">
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Confirm Withdrawal',
                            showLoaderOnConfirm: true,
                            didOpen: () => {
                                const inputs = document.querySelectorAll('.pin-input');
                                const completePin = document.querySelector('#complete-pin');

                                inputs.forEach((input, index) => {
                                    // Only allow numbers
                                    input.addEventListener('input', (e) => {
                                        e.target.value = e.target.value.replace(/[^0-9]/g, '');

                                        if (e.target.value) {
                                            // Move to next input
                                            if (index < inputs.length - 1) {
                                                inputs[index + 1].focus();
                                            }
                                        }

                                        // Update complete pin
                                        const pin = Array.from(inputs).map(input => input.value).join('');
                                        completePin.value = pin;
                                    });

                                    // Handle backspace
                                    input.addEventListener('keydown', (e) => {
                                        if (e.key === 'Backspace' && !e.target.value && index > 0) {
                                            inputs[index - 1].focus();
                                        }
                                    });

                                    // Handle paste
                                    input.addEventListener('paste', (e) => {
                                        e.preventDefault();
                                        const pastedData = e.clipboardData.getData('text');
                                        const numbers = pastedData.match(/\d/g);

                                        if (numbers) {
                                            numbers.slice(0, inputs.length).forEach((num, i) => {
                                                inputs[i].value = num;
                                                if (i < inputs.length - 1) {
                                                    inputs[i + 1].focus();
                                                }
                                            });
                                        }
                                    });
                                });

                                // Focus first input
                                inputs[0].focus();
                            },
                            preConfirm: () => {
                                const pin = document.querySelector('#complete-pin').value;
                                if (!pin) {
                                    return Swal.showValidationMessage('Please enter your PIN');
                                }
                                if (pin.length !== 4) {
                                    return Swal.showValidationMessage('PIN must be 4 digits');
                                }
                                if (!/^\d+$/.test(pin)) {
                                    return Swal.showValidationMessage('PIN must contain only numbers');
                                }

                                // Submit withdrawal request
                                console.log(transactionId, pin)
                                return fetch('/withdraw-request', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        },
                                        body: JSON.stringify({
                                            transaction_id: transactionId,
                                            pin: pin
                                        })
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(response.statusText);
                                        }
                                        return response.json();
                                    })
                                    .catch(error => {
                                        Swal.showValidationMessage(`Request failed: ${error}`);
                                    });
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Withdrawal Request Submitted!',
                                    text: 'Kindly note that it takes between 1 - 2hrs to get credited.',
                                    icon: 'success'
                                }).then(() => {
                                    // Reload the page or update the UI
                                    window.location.reload();
                                });
                            }
                        });
                    }
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to fetch user profile. Please try again.',
                    icon: 'error'
                });
            });
    }
</script>