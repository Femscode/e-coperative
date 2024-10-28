@extends('frontend.master')

@section('header')
<script src="{{ url('assets/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ url('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Custom Css-->
<link href="{{ url('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
<style>
    .field-icon {
        float: right;
        left: -10px;
        margin-top: -23px;
        position: relative;
        z-index: 2;
    }
    .preloader {
        align-items: center;
        background: gray;
        display: flex;
        height: 100vh;
        justify-content: center;
        left: 0;
        position: fixed;
        top: 0;
        transition: opacity 0.3s linear;
        width: 100%;
        z-index: 9999;
        opacity: 0.4;
    }
</style>
@endsection

@section('content')
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4" style="font-weight: bold; color: #00563f;">All Cooperatives</h1>
        <div class="table-responsive">
            <table class="table" style="border-collapse: separate; border-spacing: 0; width: 100%;">
                <thead style="background-color: #00462a; color: #fdfdfd;">
                    <tr>
                        <th scope="col" style="padding: 16px 12px;">Name</th>
                        <th scope="col" style="padding: 16px 12px;">Description</th>
                        <th scope="col" style="padding: 16px 12px; text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cooperatives as $index => $cooperative)
                        <tr style="background-color: {{ $index % 2 == 0 ? '#f9f9f9' : '#ffffff' }};">
                            <td class="align-middle" style="padding: 16px 12px;">{{ $cooperative->name }}</td>
                            <td class="align-middle" style="padding: 16px 12px;">{{ $cooperative->description }}</td>
                            <td class="align-middle text-center" style="padding: 16px 12px;">
                                <a href="{{ route('cooperatives.details', $cooperative->id) }}" style="color: #041505; border: 1px solid #013e03; padding: 8px 12px; border-radius: 5px; text-decoration: none; transition: background-color 0.3s ease;">
                                    <i class="fa fa-eye" style="margin-right: 5px;"></i> View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
@endsection
