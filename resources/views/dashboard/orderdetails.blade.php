@extends('vendordashboard.master')
@section('header')

@endsection

@section('content')
<div class="container-xxl" id="kt_content_container">
    <!--begin::Order details page-->
<div class='row justify-content-center'>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <!-- Logo & title -->
                <div class="clearfix pb-3 bg-primary-subtle p-lg-3 p-2 m-n2 rounded position-relative">
                    <div class="float-sm-start">
                        <div class="auth-logo">
                            <img src="{{url('assets/images/logo-wh.png')}}" alt="" height="30">

                            <!-- <img class="logo-dark me-1" src="assets/images/logo-dark.png" alt="logo-dark" height="24"> -->
                        </div>
                        <div class="mt-4">
                            <h4>CTTaste Receipt.</h4>
                            <address class="mt-3 mb-0">
                                {{ $user->address }}<br>
                                <abbr title="Phone">Phone:</abbr> {{ $user->phone }}
                            </address>

                        </div>
                    </div>
                    <div class="float-sm-end">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td class="p-0 pe-5 py-1">
                                            <p class="mb-0 text-dark fw-semibold"> Order Id : </p>
                                        </td>
                                        <td class="text-end text-dark fw-semibold px-0 py-1">#{{$order->order_id}}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-0 pe-5 py-1">
                                            <p class="mb-0">Order Date: </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0 py-1">{{ Date('jS M, Y - g:iA', strtotime($order->created_at)) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="p-0 pe-5 py-1">
                                            <p class="mb-0">Amount : </p>
                                        </td>
                                        <td class="text-end text-dark fw-medium px-0 py-1">₦{{number_format($order->total_price,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="p-0 pe-5 py-1">
                                            <p class="mb-0">Status : </p>
                                        </td>
                                        <td class="text-end px-0 py-1"><span class="badge bg-success text-white  px-2 py-1 fs-13">Paid</span></td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="position-absolute top-100 start-50 translate-middle">
                        <img src="{{url('vendorsdashboard/images/check-2.png')}}" alt="" class="img-fluid">
                    </div>
                </div>

                <div class="clearfix pb-3 mt-4">
                    <div class="float-sm-start">
                        <div class="">
                            <h4 class="card-title">Customer Details :</h4>
                            <div class="mt-3">
                                <h4>{{$order->name}}</h4>
                                <p class="mb-2">{{$order->location}} - {{$order->address}}</p>
                                <p class="mb-2"><span class="">Phone :</span> {{$order->phone}}</p>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-70px text-end">Product</th>

                                        <th class="min-w-70px text-end">Qty</th>
                                        <th class="min-w-100px text-end">Unit Price</th>
                                        <th class="min-w-100px text-end">Total</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <!--begin::Products-->
                                    @foreach($carts->items as $product)
                                    <tr>
                                        <!--begin::Product-->
                                        <td class='text-end'>
                                            <a
                                                class="fw-bolder text-gray-600 text-hover-primary">{{$product['name']}}</a>


                                        </td>
                                        <!--end::Product-->
                                        <!--begin::SKU-->

                                        <!--end::SKU-->
                                        <!--begin::Quantity-->
                                        <td class="text-end">{{$product['qty']}}</td>
                                        <!--end::Quantity-->
                                        <!--begin::Price-->
                                        <td class="text-end">₦{{number_format($product['price'],2)}}</td>
                                        <!--end::Price-->
                                        <!--begin::Total-->
                                        <td class="text-end">₦{{number_format($product['price'] *
                                                        $product['qty'],2) }}</td>
                                        <!--end::Total-->
                                    </tr>
                                    @endforeach
                                    <br>
                                    <tr>
                                        <td class="text-end"></td>
                                        <td colspan="text-end" class="text-end"></td>
                                        <td colspan="text-end" class="text-end">Subtotal</td>
                                        <td class="text-end">₦{{number_format($order->total_price - $order->delivery_amount,2)}}</td>
                                    </tr>
                                    <!--end::Subtotal-->
                                    <!--begin::VAT-->
                                    <tr>
                                        <td class="text-end"></td>
                                        <td colspan="text-end" class="text-end"></td>
                                        <td colspan="text-end" class="text-end">Delivery (0%)</td>
                                        <td class="text-end">₦{{number_format($order->delivery_amount,2)}}
                                        </td>
                                    </tr>
                                    <!--end::VAT-->
                                    <!--begin::Shipping-->
                                    <tr>
                                        <td class="text-end"></td>
                                        <td colspan="text-end" class="text-end"></td>
                                        <td colspan="text-end" class="text-end">CT Charge</td>
                                        <td class="text-end">₦50</td>
                                    </tr>
                                    <!--end::Shipping-->
                                    <!--begin::Grand total-->
                                    <tr>
                                        <td class="text-end"></td>
                                        <td colspan="text-end" class="text-end"></td>
                                        <td colspan="text-end" class="fs-3 text-dark text-end">Grand Total
                                        </td>
                                        <td class="text-dark fs-3 fw-boldest text-end">
                                            ₦{{number_format($order->total_price,2)}}</td>
                                    </tr>
                                    <!--end::Grand total-->
                                </tbody>
                                <!--end::Table head-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->

               

                <div class="mt-3 mb-1">
                    <div class="text-end d-print-none">
                        <a href="javascript:window.print()" class="btn btn-primary width-xl">Print</a>

                    </div>
                </div>

            </div> <!-- end card body -->
        </div> <!-- end card -->
    </div>
</div>

    <!--end::Order details page-->
</div>
@endsection

@section('script')

@endsection