@extends('vendordashboard.master')
@section('header')

@endsection

@section('content')

<div class="container-xxl">
    <h1>Customer's Reviews</h1>
    <div class="row">
        @foreach($reviews as $review)
        <div class="col-xl-3 col-md-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <p class="mb-2 text-dark fw-semibold fs-15">{{$review->complaint}}</p>
                 </div>
                <div class="card-footer bg-primary position-relative mt-3">
                    <div class="position-absolute top-0 start-0 translate-middle-y ms-3">
                        @if($review->phone == null)
                        <a onclick='return Swal.fire("This user does not include his/her phone number while making the review")' class='btn btn-dark btn-sm'>Message User</a>
                        @else
                        <a href='https://wa.me/234{{ substr($review->phone,1) }}?text=Hi,%20from%20{{ $user->name }},we%20received%20your%20complain%20in%20regards...' class='btn btn-dark btn-sm'>Message User</a>
                        @endif
                    </div>
                    <div class="position-absolute top-0 end-0 translate-middle-y me-3">
                        <img src="{{url('vendorsdashboard/images/double.png')}}" alt="" class="avatar-md">
                    </div>
                    <div class="mt-4">
                        <h4 class="text-white mb-1">{{$review->phone}}</h4>
                        <p class="text-white mb-0">{{Date('d-m-Y : m:dA', strtotime($review->created_at)) }}</p>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('script')

@endsection