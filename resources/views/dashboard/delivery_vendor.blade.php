@extends('vendordashboard.master')
@section('header')

@endsection

@section('content')

<div class="modal fade" id="kt_modal_invite_friends2" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header pb-0 border-0 justify-content-end">
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-3 mx-xl-10 pt-0 pb-1">
                <!--begin::Heading-->
                <div class="text-center mb-13">
                    <!--begin::Title-->
                    <h1 class="mb-3">Add Rider</h1>
                  
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-5 my-15">
                    <!--begin::Form-->
                    <form method='post' id='add_rider' class="form">
                        @csrf
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-7 fv-row fv-plugins-icon-container">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required">Rider's Name</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Specify name of rider"></i>
                            </label>
                            <!--end::Label-->
                            <input required type="text" id='rider_name' class="form-control form-control-solid"
                                placeholder="Name of rider" name="name" value="">

                            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                                <span class="required">Rider's Number</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title=""
                                    data-bs-original-title="Specify phone number of rider"></i>
                            </label>
                            <!--end::Label-->
                            <input required type="number" id='rider_phone' class="form-control form-control-solid"
                                placeholder="Rider's phone number" value="">

                        </div>

                        <div class="text-center mt-2">
                            <button type="reset" id="kt_modal_new_card_cancel"
                                class="btn btn-light me-3">Discard</button>
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                        </div>
                        <!--end::Actions-->
                        <div></div>
                    </form>
                    <!--end::Form-->
                </div>


            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Delivery's Dashboard</h4>
                <div class='alert alert-primary' style='border:1.5px dashed secondary'>
                    <input  value='manual' style='transform: scale(2); cursor:pointer' class='tracking_type m-2 p-2' name='delivery_type' type='radio'@if($user->tracking_type == 'manual') checked @endif> Manual
                    <input value='automatic' style='transform: scale(2); cursor:pointer' class='tracking_type m-2 p-2' name='delivery_type' type='radio' @if($user->tracking_type == 'automatic') checked @endif > Automatic
                </div>
            </div>
            <div class='row'>
                <div class='col-md-6'>
            <div class=" alert alert-primary" role="alert">
                You are currently running on a manual tracking mode which requires that your 
                you <strong> merge an order with a rider</strong> when the payment is confirmed.
               

            </div>
                </div>
            <div class='col-md-6'>
                <div class='row'>
            <div class="col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <a href='#' class="text-muted fw-medium">Pending Delivery</a>
                                <h4 class="mb-0" id='pending_delivery'>{{ count($pending_deliveries) }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="bx bx-store-alt font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <a href='#' class="text-muted fw-medium">Completed Delivery</a>
                                <h4 class="mb-0" id='completed_delivery'>{{ count($completed_deliveries) }}</h4>
                            </div>

                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-restaurant font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>

            </div>
            @if($user->approve == 0)
            <div class="alert alert-danger" role="alert">

                Please note that for you to start selling on CTtaste, you have to get your restaurant
                approved by clicking on the approve button below.<br>
                <a href='https://wa.me/2349058744473?text=Hi%20Admin,%20%0a--�--%0aI%20just%20finish%20setting%20up%20my%20account%20at%20CTTaste,%20you%20can%20check%20out%20my%20restaurant%20profile({{$user->name}})%20for%20proper%20verification%20and%20approval.'
                    class='btn-sm btn btn-danger'>Approve</a>

            </div>
            @endif

        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        
        <div class='col-md-4'>

            <div class="card card-xl-stretch mb-xl-8">
                <!--begin::Header-->
                <div class="p-4 border-0">
                    <div class='row'>
                        <div class='col-md-6'>
                            <h3 class="card-title fw-bolder text-dark">Available Riders</h3>
                        </div>
                        <div class='col-md-6'>
                            <a data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends2"
                            class='btn btn-primary btn-sm m-auto w-100'>Add Rider</a>
                   
                            {{-- <a class='clear_rider btn btn-sm btn-light'>Rider's Record</a> --}}
                        </div>

                    </div>


                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body pt-2">
                    <!--begin::Item-->
                    <div class="table-responsive dataTables_length" id='datatable_length'>
                    <table class="mytable table table-bordered align-middle mb-0">
                        <thead>
                            <tr class="fw-bolder text-muted">

                                <th>#</th>
                                <th>Rider Name</th>

                                <th>Count</th>

                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody id='search_food_tbody'>
                           
                            <input style='display:none' type='text' id='real_rider_id'>
                            @foreach($riders as $rider)
                          
                            <tr>
                                <td><input value='{{ $rider->id }}' data-id='{{ $rider->id }}' type='radio'
                                        name='rider_id' class='rider_id form form-control-bg'></td>


                                <td>{{ $rider->name }} - {{ $rider->phone }}</td>
                                <td><span id='rider_count_{{ $rider->id }}'>{{ $rider->count }}</span> - (₦<span id='rider_amount_{{ $rider->id }}'>{{ number_format($rider->amount) }}</span>)</td>


                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">


                                        <a data-id='{{ $rider->id }}' class="delete_rider btn btn-danger btn-sm">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    </div>
                   
                    <div class='col-md-12'>
                        <a class='w-100 m-2 clear_rider btn btn-sm btn-dark'>Clear Rider's Record</a>
                        
                      </div>
                    <div class='col-md-12 mt-4'>Total Delivery : <span id='total_delivery'>{{ number_format($riders->sum('count')) }}</span></div>
                    <div class='col-md-12 mt-4'>Total Amount : NGN <span id='total_amount'>{{ number_format($riders->sum('amount')) }}</span></div>
                
                </div>
                <!--end::Body-->
            </div>

        </div>
        <div class='col-md-8'>
            <div class='row'>
               
                <div class="card">
                    <div class="card-body">
                        <div class='row'>
                            <div class="card-title col-md-8">Deliveries</div>
                            <a id='merge_orders' class='col-md-4 btn btn-success'>Merge Orders</a>

                        </div>
                        
                        <div class="table-responsive dataTables_length" id='datatable_length'>
                            <table  class="mytable table table-bordered w-100 align-middle mb-0">
                                <thead>
                                    <tr class="fw-bolder text-grey">

                                        <th>#</th>
                                        <th>Delivery Address</th>
                                        <th>Rider Name</th>
                                        <th>Status</th>
                                        <th>Delivery Price</th>

                                        <th>Request Time</th>
                                        <th>Pick Up Time</th>
                                    

                                        {{-- <th class="min-w-120px">Price</th> --}}

                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody id='myTbody'>
                                    @foreach($deliveries as $delivery)
                                    <tr id='tr_{{ $delivery->id }}' @if($delivery->status == 0) style='background:#cbffda'  @else style='background:#ffcccb' @endif>

                                        <td><input data-id='{{ $delivery->id }}' type='checkbox'
                                                class='check_order form form-control-bg'></td>
                                        <td>{{ $delivery->order_to }} - {{ $delivery->address }}</td>

                                        <td id='rider_name_{{ $delivery->id }}'>{{ $delivery->rider_name ?? "pending" }}</td>

                                        <td id='delivery_status_{{ $delivery->id }}'>
                                            @if($delivery->status == 1)
                                            Success
                                            @elseif($delivery->status == 0)
                                            Merged
                                            @else
                                            Not started
                                            @endif

                                        </td>
                                        <td>₦{{ $delivery->delivery_price }}</td>
                                        <td>{{ date('h:i A', strtotime($delivery->request_time)) }}</td>
                                        <td id='pick_up_time_{{ $delivery->id }}'>{{ date('h:i A', strtotime($delivery->pick_up_time)) ?? 'pending' }}</td>


                                        <td>
                                            <div class="d-flex justify-content-end flex-shrink-0">
                                                @if($delivery->status == 2)
                                               <a id='change_status_{{ $delivery->id }}' data-change='{{ $delivery->id }}' style='margin-right:5px' data-id='{{ $delivery->uuid }}' class='confirm_payment btn btn-sm btn-secondary mr-2'>
                                                Deny Payment
                                            </a>
                                            @elseif($delivery->status == 3)
                                            <a id='change_status_{{ $delivery->id }}' data-change='{{ $delivery->id }}' style='margin-right:5px' data-id='{{ $delivery->uuid }}' class='confirm_payment btn btn-sm btn-info mr-2'>
                                                Confirm Payment
                                            </a>
                                            @else 
                                            @endif
                                            
                                                <a data-id='{{ $delivery->uuid }}'
                                                    class="mark_complete btn btn-dark btn-sm">
                                                    Mark Complete
                                                </a>
                                                <a style='margin-left:5px' data-id='{{ $delivery->uuid }}'
                                                    class="delete_delivery btn btn-danger btn-sm">
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>




    </div>
    <!-- end row -->


</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


            const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })
    @if (session('message'))
    Swal.fire('CT-Taste',"{{ session('message') }}",'success');
    @endif
    @if (session('error'))
    Swal.fire('CT-Taste',"{{ session('error') }}",'error');
    @endif
  





    // $(".mytable").dataTable();
    $(".mytable").DataTable({
        pageLength: 15,
        filter: false,
        deferRender: true,
        lengthChange: false,
        "searching": false,
    });

    $('body').on('submit', '#set_group_link',async function(e) {
        e.preventDefault()
      
        var fd = new FormData;
        fd.append('group_link',$("#group_link").val());
        console.log(fd)
        $.ajax({
            type: 'POST',
            url: "{{route('set_group_link')}}",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log('the data', data)
                Swal.close()
                    if(data == true) {
                        Swal.fire('Success!', 'Group Link Set Successfully!', 'success')
                    console.log(data)
                    }
                    else {
                        Swal.fire('Error setting group link','Group link not set, please try again' ,'error')
                    
                    }
                    
               
                // window.location.reload()

            },
            error: function(data) {
                console.log(data)
                Swal.close()
                Swal.fire('Opps!', 'Group Link Not Updated, Contact The Admin', 'error')
            }
        })


    });

    $('body').on('click', '.clear_rider', function() {
        // var id = $("#delete_id").val();
    
        var token = $("meta[name='csrf-token']").attr("content");
      
        clearRider();
    });


    async function clearRider() {
        const willUpdate = await Swal.fire({
            title: "Are you sure you want to clear the rider's record",
            text: `Clearing will result to lost of all riders records!`,
            icon: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            showCancelButton: true,
            buttons: ["Cancel", "Yes, Clear"]
        });
        if (willUpdate.isDismissed == false) {
            //performReset()
            performClear();
        }
    }


    function performClear() {

        try {
            $.get('{{ route("clear_rider") }}',
                function(data, status) {
                    console.log(status);
                    console.table(data);
                    if (status === "success") {
                        Toast.fire({
                        icon: 'success',
                        title: 'Riders record cleared successfully'
                        })
                        //  Swal.fire('success', "Menu successfully deleted!.", 'success');
                     window.location.reload()
                       

                    }
                }
            );
        } catch (e) {
            let alert = Swal.fire(e.message);
        }
    }

    $('body').on('click', '.delete_rider', function() {
        // var id = $("#delete_id").val();
        id = $(this).data('id');
        console.log(id)
        var token = $("meta[name='csrf-token']").attr("content");
        var el = this;
        // alert(user_id);
        resetFood(el, id);
    });


    async function resetFood(el, id) {
        const willUpdate = await Swal.fire({
            title: "Confirm Rider Delete",
            text: `Deleting this rider will result to lost of all records related to this rider?`,
            icon: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            showCancelButton: true,
            buttons: ["Cancel", "Yes, Delete"]
        });
        if (willUpdate.isDismissed == false) {
            //performReset()
            performDeleteFood(el, id);
        }
    }


    function performDeleteFood(el, id) {

        try {
            $.get('{{ route("delete_rider") }}?id=' + id,
                function(data, status) {
                    console.log(status);
                    console.table(data);
                    if (status === "success") {
                        Toast.fire({
                        icon: 'success',
                        title: 'Rider deleted successfully'
                        })
                        //  Swal.fire('success', "Menu successfully deleted!.", 'success');
                        $(el).closest("tr").remove();
                       

                    }
                }
            );
        } catch (e) {
            let alert = Swal.fire(e.message);
        }
    }
    $('body').on('click', '.confirm_payment', function() {
        // var id = $("#delete_id").val();
        id = $(this).data('id');
        change_id = $(this).data('change');
        console.log(id)
        var token = $("meta[name='csrf-token']").attr("content");
        var el = this;
        // alert(user_id);
        denyPayment(el, id, change_id);
    });


    async function denyPayment(el, id, change_id) {
        const willUpdate = await Swal.fire({
            title: "Confirm User's Payment",
            // text: `Are you sure you want to confirm th?`,
            icon: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            showCancelButton: true,
            buttons: ["Cancel", "Yes, Confirm"]
        });
        if (willUpdate.isDismissed == false) {
            //performReset()
            performDenyPayment(el, id, change_id);
        }
    }


    function performDenyPayment(el, id, change_id) {

        try {
            $.get('{{ route("confirm_payment") }}?id=' + id,
                function(data, status) {
                    console.log(status);
                    console.table(data);
                    if (status === "success") {
                        if(data == true) {

                            Toast.fire({
                                icon: 'success',
                                title: 'Payment Confirmed Succssfully!'
                            })
                            $("#myTbody #tr_"+change_id).css('background-color','#ffc107')
                            $("#delivery_status_"+change_id).text('Paid')
                            $("#change_status_"+change_id).text('Deny Payment')
                            
                            //  Swal.fire('success', "Menu successfully deleted!.", 'success');
                            // $(el).closest("tr").remove();
                        }
                        else {
                            Toast.fire({
                                icon: 'success',
                                title: 'Payment Declined Successfully!'
                            }) 
                            $("#myTbody #tr_"+change_id).css('background-color','#ffcccb')
                            $("#delivery_status_"+change_id).text('Not Paid')
                            $("#change_status_"+change_id).text('Confirm Payment')
                        }
                       

                    }
                }
            );
        } catch (e) {
            let alert = Swal.fire(e.message);
        }
    }

    $('body').on('click', '.mark_complete', function() {
        // var id = $("#delete_id").val();
        id = $(this).data('id');
        console.log(id)
        var token = $("meta[name='csrf-token']").attr("content");
        var el = this;
        // alert(user_id);
        markPayment(el, id);
    });


    async function markPayment(el, id) {
        const willUpdate = await Swal.fire({
            title: "Confirm Delivery Success",
            // text: `Are you sure this order has been delivered?`,
            icon: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            showCancelButton: true,
            buttons: ["Cancel", "Yes, Confirm"]
        });
        if (willUpdate.isDismissed == false) {
            //performReset()
            performMarkSuccess(el, id);
        }
    }


    function performMarkSuccess(el, id) {

        try {
            $.get('{{ route("mark_complete") }}?id=' + id,
                function(data, status) {
                    console.log(status);
                    console.table(data);
                    if (status === "success") {
                        if(data == true) {

                            Toast.fire({
                                icon: 'success',
                                title: 'Delivery Completed'
                            })
                            var count = parseInt($('#completed_delivery').text());

                            // Increment the count by one
                            count++;
                            $("#completed_delivery").text(count)
                            //  Swal.fire('success', "Menu successfully deleted!.", 'success');
                            $(el).closest("tr").remove();
                        }
                        else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Cannot complete order without merging!'
                            }) 
                        }
                       

                    }
                }
            );
        } catch (e) {
            let alert = Swal.fire(e.message);
        }
    }


    $('body').on('click', '.delete_delivery', function() {
        // var id = $("#delete_id").val();
        id = $(this).data('id');
        console.log(id)
        var token = $("meta[name='csrf-token']").attr("content");
        var el = this;
        // alert(user_id);
        deleteDelivery(el, id);
    });


    async function deleteDelivery(el, id) {
        const willUpdate = await Swal.fire({
            title: "Confirm Delivery Delete",
            // text: `Are you sure you want to delete this delivery?`,
            icon: "warning",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            showCancelButton: true,
            buttons: ["Cancel", "Yes, Delete"]
        });
        if (willUpdate.isDismissed == false) {
            //performReset()
            performDeliveryDelete(el, id);
        }
    }


    function performDeliveryDelete(el, id) {

        try {
            $.get('{{ route("delete_delivery") }}?id=' + id,
                function(data, status) {
                    console.log(status);
                    console.table(data);
                    if (status === "success") {
                        if(data == true) {

                            Toast.fire({
                                icon: 'success',
                                title: 'Delivery Deleted Successfully!'
                            })
                            // var count = parseInt($('#completed_delivery').text());
                                //   count++;
                            // $("#completed_delivery").text(count)
                             $(el).closest("tr").remove();
                        }
                        else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Delivery has been assigned a rider!'
                            }) 
                        }
                       

                    }
                }
            );
        } catch (e) {
            let alert = Swal.fire(e.message);
        }
    }

   $("body").on('click','.rider_id', function() {
    
    $("#real_rider_id").val($(this).data('id'))
   })
 
    $("#merge_orders").click(function() {
            const checkedValues = [];

            // Loop through all the checked checkboxes and get their data-id attributes
            $(".check_order:checked").each(function() {
                checkedValues.push($(this).data("id"));
            });

            // Log the checked values to the console
            var rider_id = $("#real_rider_id").val()
           
            console.log(checkedValues);
            var fd = new FormData;
            fd.append('deliveries',checkedValues);
            fd.append('rider_id',rider_id);
       


        console.log(fd)
        $.ajax({
            type: 'POST',
            url: "{{route('merge_order')}}",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log('the data', data)
                Swal.close()
                if(data[0] == true) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Order merged'
                        })
                        $(".check_order:checked").each(function() {
                           
                             id = $(this).data('id')
                        
                            // $("#myTbody #tr_"+id).css('color','red')
                            $("#myTbody #tr_"+id).css('background-color','#cbffda')
                            $("#rider_name_"+id).text(data[1].rider_name)
                            $("#pick_up_time_"+id).text((new Date(data[1].pick_up_time)).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}));
                            $("#delivery_status_"+id).text('Merged')
                          

                            // $("#tr_"+id).css("color","red !important")pelumi o
                            //    $("#tr_"+id).css('background-color','red !important')
                            //    $("#tr_"+id).css('display','none')
                            });
                            var current_rider_count = parseInt($("#rider_count_"+data[1].rider_id).text())
                            var current_rider_amount = parseInt($("#rider_amount_"+data[1].rider_id).text().replace(",", ""))
                            var total_delivery = parseInt($("#total_delivery").text().replace(",", ""))
                            var total_amount = parseInt($("#total_amount").text().replace(",", ""))
                            console.log(current_rider_amount, 'the amount')
                            $("#rider_count_"+data[1].rider_id).text(current_rider_count + 1)
                            $("#rider_amount_"+data[1].rider_id).text(current_rider_amount + data[1].delivery_price)
                            $("#total_delivery").text(total_delivery + 1)
                            $("#total_amount").text(total_amount + data[1].delivery_price)
                            var pending_delivery = parseInt($("#pending_delivery").text())
                           console.log(pending_delivery,'the pending')
                            $("#pending_delivery").text(pending_delivery + 1)
                        }
                  else if(data[0] == false) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Order has already been merged with a rider'
                        })
                  }
                 
                  else {
                    Toast.fire({
                        icon: 'success',
                        title: 'Order have been sent to CTTASTE Delivery'
                        })

                    window.location.replace('/cttaste_delivery/'+data[1].uuid)
                   }
              },
            error: function(data) {
                console.log(data)
                Swal.close()
                 Toast.fire({
                        icon: 'error',
                        title: 'Order not marged, merge order with a rider!'
                        })
            }
        })
            
        });
       
        $(".tracking_type").click(function() {

            var deliveryType = $('input[name="delivery_type"]:checked').val();
  console.log(deliveryType); 
          
           var fd = new FormData;
        fd.append('tracking_type',deliveryType);
       
        console.log(fd)
        $.ajax({
            type: 'POST',
            url: "{{route('tracking_type')}}",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log('the data', data)
               if($.trim(data) == 'automatic') {
                Toast.fire({
                icon: 'success',
                title: 'Tracking Status Change'
                })
                 window.location.reload()
               }
               else {
                Toast.fire({
                icon: 'success',
                title: 'Tracking Status Changed'
                })
                window.location.reload()
               }
            
            },
            error: function(data) {
                console.log(data)
                Swal.close()
                Swal.fire('Opps!', 'Something went wrong try again later', 'error')
            }
        })

        })
    $(".copy-link").click(function() {
       
            var link = $(this).data('id');
            navigator.clipboard.writeText(link).then(function() {
                Toast.fire({
                icon: 'success',
                title: 'Linked Copied'
                })
                
            });
            });

            $("#add_rider").on("submit", async function(e) {
        Swal.fire('Adding rider, please wait...')
        e.preventDefault();
        var fd = new FormData;
        fd.append('name', $("#rider_name").val());
        fd.append('phone', $("#rider_phone").val());
       
        console.log(fd)
        $.ajax({
            type: 'POST',
            url: "{{route('add_rider')}}",
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log('the data', data)
                Swal.close()
                Toast.fire({
                        icon: 'success',
                        title: 'Rider added successfully'
                        })
                $("#search_food_tbody").append(`
                <tr>
                    <td><input value='${data.id}' data-id='${data.id}' type='radio'
                                        name='rider_id' class='rider_id form form-control-bg'></td>


                                <td>${data.name} - ${data.phone}</td>
                                <td>0</td>
                               

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">
                                       

                                        <a data-id="${data.id}" 
                                            class="btn btn-danger btn-sm">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                `)
                $("#rider_name").val('')
                $("#rider_phone").val('')
              
                Swal.close()
                // window.location.reload()

            },
            error: function(data) {
                console.log(data)
                Swal.close()
                Swal.fire('Opps!', 'Rider not created, contact the administrator', 'error')
            }
        })

    })


        })
</script>
    @endsection