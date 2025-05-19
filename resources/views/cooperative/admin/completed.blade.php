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
                    <a href="/admin/application" class="nav-link text-center py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-time-line fs-22 me-2"></i>
                            <h5 class="mb-0">Pending</h5>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/admin/application/awaiting-disbursement" class="nav-link text-center py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-timer-line fs-22 me-2"></i>
                            <h5 class="mb-0">Awaiting</h5>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/admin/application/ongoing" class="nav-link text-center py-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-loader-2-line fs-22 me-2"></i>
                            <h5 class="mb-0">Ongoing</h5>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="/admin/application/completed" class="nav-link text-center py-3 active">
                        <div class="d-flex align-items-center justify-content-center">
                            <i class="ri-checkbox-circle-line fs-22 me-2"></i>
                            <h5 class="mb-0">Completed</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @livewire('completed-loan')


</div>
<!-- container-fluid -->
@endsection