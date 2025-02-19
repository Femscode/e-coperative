@extends('dashboard.master')
@section('header')

@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="col-12 mb-4">
            <div class="nav-tabs-custom">
                <div class="d-flex w-100 overflow-hidden">
                    <a href="/admin/transaction/all" class="nav-link flex-fill text-center py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-exchange-dollar-line fs-22 me-2"></i>
                            <h5 class="mb-0">All</h5>
                        </div>
                    </a>
                    <a href="/admin/transaction/registration" class="nav-link flex-fill text-center py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-user-add-line fs-22 me-2"></i>
                            <h5 class="mb-0">Registration</h5>
                        </div>
                    </a>
                    <a href="/admin/transaction/monthly_dues" class="nav-link flex-fill text-center py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-calendar-check-line fs-22 me-2"></i>
                            <h5 class="mb-0">Dues</h5>
                        </div>
                    </a>
                    <a href="/admin/transaction/repayment" class="nav-link flex-fill text-center py-3 active">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-refund-2-line fs-22 me-2"></i>
                            <h5 class="mb-0">Repayments</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    <!-- end page title -->
    @livewire('repayment-transaction')
</div>
@endsection
