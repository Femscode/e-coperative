@extends('member_cooperative.admin.master')

@section('header')

@endsection


@section('main')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">
        <div class="row align-items-center">
            <div class="col-12 col-lg mb-4">
                <h3 class="fw-normal mb-0 text-secondary">Hi, {{ $user->name }}.</h3>
                <h2>{{ $user->company->name }} Member {{$user->coop_id}}</h2>

            </div>
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2 mb-4">
                <div class="card adminuiux-card">
                    <div class="card-body">
                        <p class="text-secondary small mb-2">All Transactions</p>
                        <h4 class="mb-3">
                            ₦
                            @if($transactions->sum('amount') >= 1000000)
                            {{ number_format($transactions->sum('amount') / 1000000, 1) }}M
                            @elseif($transactions->sum('amount') >= 1000)
                            {{ number_format($transactions->sum('amount') / 1000, 1) }}K
                            @else
                            {{ number_format($transactions->sum('amount')) }}
                            @endif
                        </h4>


                        <a href='/member/transactions' style='cursor:pointer' class="badge badge-light text-bg-success">View</a>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2 mb-4">
                <div class="card adminuiux-card">
                    <?php $variable = getTotalDues($user->id); ?>
                    <div class="card-body">
                        <p class="text-secondary small mb-2">Pending Due</p>
                        <h4 class="mb-3">₦
                           
                            @if($variable >= 1000000)
                            {{ number_format($variable / 1000000, 1) }}M
                            @elseif($variable >= 1000)
                            {{ number_format($variable / 1000, 1) }}K
                            @else
                            {{ number_format($variable) }}
                            @endif

                        </h4>
                        @if($variable > 0)
                        <a href='/member/manual-payment' style='cursor:pointer' class="badge badge-light text-bg-warning">Pay Now</a>
                        @else
                        <span href='#'  class="badge badge-light text-bg-success">Paid</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-lg-3 col-xl-2 mb-4">
                <div class="card adminuiux-card">
                    <div class="card-body">
                        <p class="text-secondary small mb-2">Applied Loan</p>
                        <h4 class="mb-3">₦
                            @if($member_loan->sum('total_left') >= 1000000)
                            {{ number_format($member_loan->sum('total_left') / 1000000, 1) }}M
                            @elseif($member_loan->sum('total_left') >= 1000)
                            {{ number_format($member_loan->sum('total_left') / 1000, 1) }}K
                            @else
                            {{ number_format($member_loan->sum('total_left')) }}
                            @endif
                        </h4>
                        <a style='cursor:pointer' class="badge badge-light text-bg-danger">Repay Loan</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-xl-4 mb-4">
                <div class="card adminuiux-card position-relative overflow-hidden bg-theme-1 h-100">
                    <div class="position-absolute top-0 start-0 h-100 w-100 z-index-0 coverimg opacity-50"><img src="assets/img/modern-ai-image/flamingo-4.jpg" alt=""></div>
                    <div class="card-body z-index-1">
                        <div class="row align-items-center justify-content-center h-100 py-4">
                            <div class="col-11">
                                <h2 class="fw-normal">Your portfolio value has been grown by</h2>
                                <h1 class="mb-3">₦0.00</h1>
                                <p>In last 1 month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-8 mb-4">
                <div class="card adminuiux-card">
                    <div class="row gx-0">
                        <div class="col-12 col-xl-4">
                            <div class="card-header">
                                <h6>Transactions</h6>
                            </div>
                            <div class="card-body pb-0">
                                <div class="card adminuiux-card bg-theme-1-subtle mb-3">
                                    <div class="card-body">
                                        <p class="text-secondary mb-2">Total Spent</p>
                                        <h4 class="fw-medium">₦{{number_format($transactions->where('payment_type', '!=','disbursed')->sum('amount')) }}
                                            <!-- <span class="text-success fs-14"><i class="bi bi-arrow-up-short me-1"></i> 18.5%</span> -->
                                        </h4>
                                    </div>
                                </div>
                                <div class="card adminuiux-card bg-theme-1-subtle theme-orange mb-3">
                                    <div class="card-body">
                                        <p class="text-secondary mb-2">Total Received</p>
                                        <h4 class="fw-medium">₦{{number_format($transactions->where('payment_type','disbursed')->sum('amount')) }}
                                            <!-- <span class="text-success fs-14"><i class="bi bi-arrow-up-short me-1"></i> 11.5%</span> -->
                                        </h4>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-xl-8">

                            <div class="card-body px-1">
                                <div class="card adminuiux-card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6>Recent Transaction</h6>
                                            </div>
                                            <div class="col-auto px-0"><a class="btn btn-sm btn btn-link">See All</a></div>
                                            <div class="col-auto"><button class="btn btn-sm btn-outline-theme"><i class="bi bi-arrow-up-right me-1"></i> Export </button></div>
                                        </div>
                                    </div>

                                    <ul class="list-group list-group-flush border-top bg-none">
                                        @foreach($transactions as $tranx)
                                        @if($tranx->type !== 'funded')
                                        <li class="list-group-item">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-40 rounded-circle border"><i class="bi bi-arrow-up-right h5"></i></div>
                                                </div>
                                                <div class="col">
                                                    <p class="mb-1 fw-medium">{{$tranx->payment_type}}</p>
                                                    <p class="text-secondary small">{{Date('d-m-y', strtotime($tranx->created_at))}}</p>
                                                </div>
                                                <div class="col-auto">
                                                    <h6>- N{{number_format($tranx->amount)}}</h6>
                                                </div>
                                            </div>
                                        </li>
                                        @else
                                        <li class="list-group-item theme-green">
                                            <div class="row gx-3 align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar avatar-40 rounded-circle border border-theme-1 bg-theme-1-subtle text-theme-1"><i class="bi bi-arrow-down-left h5"></i></div>
                                                </div>
                                                <div class="col">
                                                    <p class="mb-1 fw-medium">{{$tranx->payment_type}}</p>
                                                    <p class="text-secondary small">{{Date('d-m-y', strtotime($tranx->created_at))}}</p>
                                                </div>
                                                <div class="col-auto">
                                                    <h6 class="text-theme-1">+ N{{number_format($tranx->amount)}}</h6>
                                                </div>
                                            </div>
                                        </li>
                                        @endif

                                        @endforeach

                                        <div class='pagination'>
                                            {{ $transactions->links() }}
                                        </div>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</main>
@endsection

@section('script')

@endsection