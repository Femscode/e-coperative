@extends('member.layout.master')

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                        <li class="breadcrumb-item active">Activities</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- <div class="row project-wrapper">
        <div class="col-xxl-8">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                        <i data-feather="briefcase" class="text-primary"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-3">My Balance</p>
                                    <div class="d-flex align-items-center mb-3">
                                        <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="{{$transactions->where('payment_type', "Monthly Dues")->sum('original')}}"></span></h4>
                                        <span class="badge badge-soft-danger fs-12"></span>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->
            </div><!-- end row -->

        </div><!-- end col -->

    </div> --}}

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title flex-grow-1 mb-0">My Transactions</h4>
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
                                    <th scope="col">Description</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                </tr><!-- end tr -->
                            </thead><!-- thead -->

                            <tbody>
                                @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="fw-medium">{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $transaction->payment_type }}</td>
                                    <td class="fw-medium">{{ $transaction->month }}</td>
                                    <td class="fw-medium"><i class="ri-check-double-line me-3 align-middle fs-16"></i></td>
                                    <td class="text-muted">{{ $transaction->updated_at }}</td>
                                </tr><!-- end tr -->
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>

                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-5">
        </div><!-- end col -->
    </div><!-- end row -->


</div>
@endsection
