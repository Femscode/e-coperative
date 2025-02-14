@extends('dashboard.master')
@section('header')

@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <div class="btn-group mb-1 me-1">
                <a href="/admin/transaction/all" class="btn btn-light">All</a>
                <a href="/admin/transaction/registration" class="btn btn-light">Registration</a>
                <a href="/admin/transaction/monthly_dues" class="btn btn-light">Dues</a>
                <a href="/admin/transaction/repayment" class="btn btn-secondary">Repayment</a>
            </div>
        </div>
        </div>
    </div>
    <!-- end page title -->
    @livewire('repayment-transaction')
</div>
@endsection
