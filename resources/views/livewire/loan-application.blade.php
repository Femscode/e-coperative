<!-- end page title -->
<div class="row gx-3 align-items-center">
    <div class="col col-sm">
        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item bi"><a href="investment-cooperative.admin.html"><i class="bi bi-house-door me-1 fs-14"></i> Dashboard</a></li>
                <li class="breadcrumb-item active bi" aria-current="page">My Loans</li>
            </ol>
        </nav>

    </div>
    @if($company->month == NULL || $difference >= $company->month)
    <div class="col-auto col-sm-auto"><a data-bs-toggle="modal" data-bs-target="#addSeller" class="btn btn-theme">Loan Request <i class="bi bi-arrow-right"></i></a></div>
    @else
    <span href='#'  class="badge badge-light text-bg-success">You need to have joined the cooperation for {{$company->month  }} month(s) to apply loan</span>
    @endif
</div>

<!-- <div class="alert alert-info alert-dismissible fade show" role="alert"><strong>Complete pending form!</strong> Please <a href="investment-loan-request.html">complete</a> your loan request form and submit for proceeding. <button type=" button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> -->
<div class="row mt-4">
    @foreach($loans as $transaction)
    <div class="col-md-6">
        <div class="card border-theme-1 theme-yellow mb-4">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-auto"><i class="bi bi-arrow-clockwise h4 bg-warning-opacity rounded"></i></div>
                    <div class="col">
                        <h5 class="mb-0 fw-medium">Processing</h5>
                        <p class="fw-medium">{{$user->company->name}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto mb-3">
                        <h4 class="mb-1">5%</h4>
                        <p class="small opacity-75">Interest Rate</p>
                    </div>
                    <div class="col text-end mb-3">
                        <p class="my-1">{{ $transaction->applied_date }}</p>
                        <p class="small opacity-75"><i class="bi bi-calendar-event me-1"></i> Applied Date</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <p class="opacity-75 small mb-2">Loan amount (NGN):</p>
                        <h3>N{{ number_format($transaction->total_applied, 2) }}</h3>
                    </div>
                    <div class="col-5 mb-3">
                        <p class="opacity-75 small mb-2">Tenure (Yrs):</p>
                        <h3>{{ $company->loan_month_repayment }} Month</h3>
                    </div>
                </div>
                <div class="text-center">
                    <h6 class="fw-normal">Your repayment</h6>
                    <h1 class="mb-0">N {{ number_format($transaction->monthly_return, 2) }} <small class="fw-normal fs-14">/month</small></h1>
                    <p class="opacity-75 small mb-3">in Nigerian Naira</p>

                    @if($transaction->approval_status == 1 && $transaction->status == "Awaiting" && $transaction->payment_status == 0)
                    <button class="btn rounded-pill btn-sm btn-info" onclick="processPayment(this)" data-amount="{{$transaction->monthly_return  }}" data-id="{{ $transaction->uuid }}">Pay</button>
                    <!-- <button class="btn rounded-pill btn-sm btn-info" onclick="processPayment(this)" data-amount="{{auth()->user()->plan()->form_amount  }}" data-id="{{ $transaction->uuid }}">Pay</button> -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @foreach($ongoing_loans as $transaction)
    <div class="col-md-6">
        <div class="card border-theme-1 theme-green mb-4">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-auto"><i class="bi bi-house h4 bg-warning-opacity rounded"></i></div>
                    <div class="col">
                        <h5 class="mb-0 fw-medium">Ongoing</h5>
                        <p class="fw-medium">{{$user->company->name}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto mb-3">
                        <h4 class="mb-1">5%</h4>
                        <p class="small opacity-75">Interest Rate</p>
                    </div>
                    <div class="col text-end mb-3">
                        <p class="my-1">{{ $transaction->applied_date }}</p>
                        <p class="small opacity-75"><i class="bi bi-calendar-event me-1"></i> Applied Date</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <p class="opacity-75 small mb-2">Loan amount (NGN):</p>
                        <h3>N{{ number_format($transaction->total_applied, 2) }}</h3>
                    </div>
                    <div class="col-5 mb-3">
                        <p class="opacity-75 small mb-2">Tenure (Yrs):</p>
                        <h3>2 Month</h3>
                    </div>
                </div>
                <div class="text-center">
                    <h6 class="fw-normal">Your repayment</h6>
                    <h1 class="mb-0">N {{ number_format($transaction->monthly_return, 2) }} <small class="fw-normal fs-14">/month</small></h1>
                    <p class="opacity-75 small mb-3">in Nigerian Naira</p>

                    @if($transaction->approval_status == 1 && $transaction->status == "Awaiting" && $transaction->payment_status == 0)
                    <button class="btn rounded-pill btn-sm btn-info" onclick="processPayment(this)" data-amount="{{$transaction->monthly_return  }}" data-id="{{ $transaction->uuid }}">Pay</button>
                    <!-- <button class="btn rounded-pill btn-sm btn-info" onclick="processPayment(this)" data-amount="{{auth()->user()->plan()->form_amount  }}" data-id="{{ $transaction->uuid }}">Pay</button> -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach


    <div class="col-md-6 mb-4">
        <div class="card adminuiux-card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6>Loan re-payment flow</h6>
                    </div>
                    <div class="col-auto px-0"><select class="form-select form-select-sm">
                            <option>NGN</option>
                           
                        </select></div>
                    <div class="col-auto"><button class="btn btn-sm btn-square btn-link"><i class="bi bi-arrow-clockwise"></i></button></div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="height-210 mb-3"><canvas id="areachartblue1" width="716" height="420" style="display: block; box-sizing: border-box; height: 210px; width: 358px;"></canvas></div>
                <div class="row align-items-center">
                   
                    <div class="col-md-6 mb-3">
                        <div class="card adminuiux-card bg-theme-1-subtle">
                            <div class="card-body z-index-1">
                                <h4 class="fw-medium text">N0.00</h4>
                                <p class="opacity-75">Total Loan Borrowed </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card adminuiux-card bg-theme-1-subtle theme-orange">
                            <div class="card-body z-index-1">
                                <h4 class="fw-medium">N0.00</h4>
                                <p class="text-secondary">Total Repayment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</div>

<!-- end row -->
</div>