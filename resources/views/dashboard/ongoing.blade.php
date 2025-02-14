@extends('dashboard.master')
@section('header')

@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="btn-group mb-1 me-1">
                    <a href="/admin/application" class="btn btn-light">Pending</a>
                    <a href="/admin/application/awaiting-disbursement" class="btn btn-light">Awaiting</a>
                    <a href="/admin/application/ongoing" class="btn btn-secondary">Ongoing</a>
                    <a href="/admin/application/completed" class="btn btn-light">Completed</a>
                </div>

            </div>
        </div>

        @livewire('ongoing-loan')


    </div>
    <!-- container-fluid -->
@endsection

