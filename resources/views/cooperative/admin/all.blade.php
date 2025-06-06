@extends('cooperative.admin.master')
@section('header')

@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="col-12 mb-4">
        <div class="nav-tabs-custom">
            <div class="row g-2">
                <div class="col-6">
                    <a href="/admin/transaction/all" class="nav-link text-center py-3 active h-100">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-exchange-dollar-line fs-22 me-2"></i>
                            <h5 class="mb-0">All</h5>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/admin/transaction/registration" class="nav-link text-center py-3 h-100 ">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-user-add-line fs-22 me-2"></i>
                            <h5 class="mb-0">Registration</h5>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/admin/transaction/monthly_dues" class="nav-link text-center py-3 h-100 ">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-calendar-check-line fs-22 me-2"></i>
                            <h5 class="mb-0">Dues</h5>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/admin/transaction/repayment" class="nav-link text-center py-3 h-100">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-refund-2-line fs-22 me-2"></i>
                            <h5 class="mb-0">Repayments</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    @livewire('all-transactions')
</div>
@endsection