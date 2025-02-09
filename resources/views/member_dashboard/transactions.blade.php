@extends('member_dashboard.master')

@section('header')

@endsection


@section('main')
<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">

        <div class="row">
            <h2>All Transactions</h2>

            <div class="col-md-12 mb-4">
                <div class="card adminuiux-card">
                    <div class="row gx-0">
                        <div class="col-12 col-xl-4">

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
                                        <h4 class="fw-medium">₦{{number_format($transactions->where('payment_type'  ,'disbursed')->sum('amount')) }}
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