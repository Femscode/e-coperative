@extends('cooperative.admin.master')
@section('header')

@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Transaction</a></li>
                        <li class="breadcrumb-item active">Form</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    @livewire('form-transactions')
</div>
@endsection
