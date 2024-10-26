@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Error Logs</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Error</a></li>
                        <li class="breadcrumb-item active">Logs</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    @livewire('error-logs')
</div>
@endsection