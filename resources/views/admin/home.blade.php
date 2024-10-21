@extends('admin.layout.master')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Welcome! {{ auth()->user()->name }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Analytics</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-animate">
                <a href="{{ route('admin_member_home') }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Members</p>
                                <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="{{ $users->where('user_type','Member')->count() }}"></span></h2>
                                {{-- <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                    <i class="ri-arrow-up-line align-middle"></i> 16.24 %
                                </span> vs. previous month</p> --}}
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                        <i data-feather="users" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </a>
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-md-4">
            <a href="{{ route('admin.all.transactions') }}">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Total Revenue</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">&#x20A6;<span class="counter-value" data-target="{{ $transactions->sum('balance') }}">0</span></h2>
                                {{-- <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">
                                    <i class="ri-arrow-down-line align-middle"></i> 3.96 %
                                </span> vs. previous month</p> --}}
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                        <i data-feather="map" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-4">
            <a href="{{ route('admin.registration.transactions') }}">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Registration</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">&#x20A6;<span class="counter-value" data-target="{{ $transactions->where('payment_type', 'Registration')->sum('balance') }}">0</span></h2>
                                {{-- <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">
                                    <i class="ri-arrow-down-line align-middle"></i> 3.96 %
                                </span> vs. previous month</p> --}}
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                        <i data-feather="layout" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </a>
        </div> <!-- end col-->
    </div> <!-- end row-->

    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('admin.dues.transactions') }}">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Total Monthly Dues</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">&#x20A6;<span class="counter-value" data-target="{{ $transactions->where('payment_type', 'Monthly Dues')->sum('balance') }}">0</span></h2>
                                {{-- <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">
                                    <i class="ri-arrow-down-line align-middle"></i> 3.96 %
                                </span> vs. previous month</p> --}}
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                        <i data-feather="activity" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </a>
        </div> <!-- end col-->
        <div class="col-md-4">
            <a href="{{ route('admin.form.transactions') }}">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Form </p>
                                <h2 class="mt-4 ff-secondary fw-semibold"> &#x20A6;<span class="counter-value" data-target="{{ $transactions->where('payment_type', 'Form')->sum('balance') }}">0</span></h2>
                                {{-- <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0">
                                    <i class="ri-arrow-down-line align-middle"></i> 0.24 %
                                </span> vs. previous month</p> --}}
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                        <i data-feather="clock" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </a>
        </div> <!-- end col-->

        <div class="col-md-4">
            <a href="{{ route('admin.repayment.transactions') }}">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="fw-medium text-muted mb-0">Repayment</p>
                                <h2 class="mt-4 ff-secondary fw-semibold">&#x20A6;<span class="counter-value" data-target="{{ $transactions->where('payment_type', 'Repayment')->sum('balance') }}">0</span></h2>
                                {{-- <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">
                                    <i class="ri-arrow-up-line align-middle"></i> 7.05 %
                                </span> vs. previous month</p> --}}
                            </div>
                            <div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                        <i data-feather="external-link" class="text-info"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div> <!-- end card-->
            </a>
        </div> <!-- end col-->
    </div> <!-- end row-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title flex-grow-1 mb-0">Recent Transactions</h4>
                    <div class="flex-shrink-0">
                        <a href="javascript:void(0);" class="btn btn-soft-info btn-sm">Export Report</a>
                    </div>
                </div><!-- end cardheader -->
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap table-centered align-middle">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Member</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                </tr><!-- end tr -->
                            </thead><!-- thead -->

                            <tbody>
                                @foreach ($monthly as $transaction)
                                <tr>
                                    <td class="fw-medium">{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $transaction->user->name ?? ""}}</td>
                                    <td class="fw-medium">{{ $transaction->payment_type }}</td>
                                    <td class="fw-medium">{{ $transaction->month }}</td>
                                    <td class="fw-medium">{{ number_format($transaction->original, 2) }}</td>
                                    <td class="text-muted">{{ \Carbon\Carbon::parse($transaction->updated_at)->format('jS M, Y - h:iA') }}</td>
                                </tr>
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            {{ $monthly->links() }}
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-5">
        </div><!-- end col -->
    </div><!-- end row -->


</div>
@endsection
