@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">{{ $title }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Applications</a></li>
                        <li class="breadcrumb-item active">Loan</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    @livewire('loan')
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

        /* When click approve button */
        $('body').on('click', '.approveButton', function () {
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert("here")
            resetAccount(el,id);
        });
        async function resetAccount(el,id) {
            const willUpdate = await new swal({
                title: "Confirm User Action",
                text: `Are you sure you want to approve this Application?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Approve"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performDelete(el,id);
            } else {
                new swal("Opss","Application will not be approved","error");
            }
        }
        function performDelete(el,id)
        {
            $('.preloader').show();
            try {
                    $.get('{{ route('admin.approve.loan.application') }}?id=' + id,
                    function (data, status) {
                        if( status === "success") {
                            let alert =  new swal("Good Job","Application approved successfully!","success");
                            window.location.reload()
                        }
                    }
                );
            } catch (e) {
                $('.preloader').hide();
                let alert = new swal("Opss",e.message,"error");
            }
        }
        /* When click disburse button */
        $('body').on('click', '.disburseButton', function () {
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert("here")
            notifyUser(el,id);
        });
        async function notifyUser(el,id) {
            const willUpdate = await new swal({
                title: "Confirm User Action",
                text: `Are you sure you want to disburse to this Application?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Disburse"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performDisburse(el,id);
            } else {
                new swal("Opss","Disbursement Cancelled","error");
            }
        }
        function performDisburse(el,id)
        {
            $('.preloader').show();
            try {
                    $.get('{{ route('admin.disburse.loan.application') }}?id=' + id,
                    function (data, status) {
                        // console.log(data)
                        if( data.status == "error") {
                            return new swal("Oops",data.message,"error");
                        }
                        if( status === "success") {
                            let alert =  new swal("Good Job","Disbursement Successfully!","success");
                            window.location.reload()
                        }
                    }
                );
            } catch (e) {
                $('.preloader').hide();
                let alert = new swal("Opss",e.message,"error");
            }
        }
    })
    </script>

@endsection
