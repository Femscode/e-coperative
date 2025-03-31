<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Contribution</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-sm text-center">
        <h1 class="text-2xl font-bold text-gray-700">Join {{ $group->mode}} Contribution</h1>
        <p class="text-gray-500 mt-2">Be a part of something great! Join now with the fixed amount below.</p>
        
        <div class="mt-4 bg-gray-200 p-3 rounded text-xl font-semibold text-gray-700">Amount: ₦{{ number_format($group->amount,2) }}</div>
        <div class="mt-4 text-gray-700">
            <p>Total Slots: <span id="totalSlots" class="font-bold">{{ $group->min }}</span></p>
            <p>Joined: <span id="joined" class="font-bold">{{ $numAlreadyJoined }}</span></p>
            <p>Remaining: <span id="remaining" class="font-bold">{{ $group->min - $numAlreadyJoined  }}</span></p>
        </div>
        <button data-id="{{ $group->id }}" class="mt-6 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded approveButton" @if($group->start_date) disabled @endif>Join</button>
    </div>
</body>

<script src="{{ url('admindashboard/js/jquery/jquery.min.js') }}"></script>
   
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="{{ url('admindashboard/css/sweetalert-custom.css') }}" rel="stylesheet">

<script src="{{ asset('admindashboard/js/sweetalert-custom.js') }}"></script>

<script>
    @if ($errors->any())
        showCustomAlert('Oops...', "{!! implode('', $errors->all('<p>:message</p>')) !!}", 'error')
    @endif

    @if (session()->has('message'))
        showCustomAlert(
            'Success!',
            "{{ session()->get('message') }}",
            'success'
        )
    @endif
    @if (session()->has('success'))
        showCustomAlert(
            'Success!',
            "{{ session()->get('success') }}",
            'success'
        )
    @endif
</script>
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
                text: `Are you sure you want to join this contribution?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Am In!"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performDelete(el,id);
            } else {
                new swal("Opss","Operation Terminated","error");
            }
        }
        function performDelete(el,id)
        {
            $('.approveButton').prop('disabled', true).text('Loading ...');
            try {
                // alert(data);
                    $.get("{{ route("join-contribution") }}?id=" + id,
                    function (data, status) {
                        // console.log(data, status);
                    //    alert(data.message)
                        if( data.status == "ok") {
                            let alert =  new swal("Good Job",data.message,"success");
                            window.location.href = "{{ route('dashboard') }}";
                        }else{
                            $('.approveButton').prop('disabled', false).text('Join');
                            new swal("Opss",data.message,"error");
                        }
                       
                    }
                );
            } catch (e) {$('.approveButton').prop('disabled', true).text('Loading ...');
                $('.approveButton').prop('disabled', true).text('Loading ...');
                // alert("here")
                let alert = new swal("Opss",e.message,"error");
            }
        }

        
    })
    </script>
</html>
