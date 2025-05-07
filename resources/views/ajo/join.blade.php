<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Join Contribution - SyncoSave</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ url('admindashboard/js/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #094168 0%, #000000 100%);
        }

        .custom-shadow {
            box-shadow: 0 10px 30px rgba(9, 65, 104, 0.1);
        }

        .amount-badge {
            background: linear-gradient(135deg, rgba(9, 65, 104, 0.1) 0%, rgba(9, 65, 104, 0.05) 100%);
            border: 1px solid rgba(9, 65, 104, 0.1);
        }

        .join-btn {
            background: linear-gradient(135deg, #094168 0%, #083857 100%);
            transition: all 0.3s ease;
        }

        .join-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(9, 65, 104, 0.2);
        }

        .join-btn:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-50 p-4">
    <div class="bg-white custom-shadow rounded-2xl p-8 max-w-md w-full">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Join {{ $group->mode}} Contribution</h1>
            <p class="text-gray-600">Be a part of something great! Join our trusted savings community.</p>

            <div class="amount-badge mt-6 p-6 rounded-xl space-y-4">
                <div class="flex flex-col items-center">
                    <p class="text-sm text-gray-600 mb-2">Contribution Amount</p>
                    <div class="text-3xl font-bold text-[#094168] flex items-center">
                        <span class="text-xl mr-1">₦</span>
                        {{ number_format($group->amount,2) }}
                    </div>
                </div>
                
                <div class="flex items-center justify-center space-x-2 pt-2 border-t border-gray-100">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600">Your Turn:</span>
                        <span class="ml-2 px-3 py-1 bg-[#094168] bg-opacity-10 rounded-full text-[#094168] font-semibold">
                            @if($group->turn_type == 'random')
                                <i class="fas fa-random mr-1"></i> Random
                            @else
                                <i class="fas fa-list-ol mr-1"></i> {{ $numAlreadyJoined }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Total Slots</p>
                    <p class="text-xl font-bold text-gray-800">{{ $group->min }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Joined</p>
                    <p class="text-xl font-bold text-gray-800">{{ $numAlreadyJoined }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Remaining</p>
                    <p class="text-xl font-bold text-gray-800">{{ $group->min - $numAlreadyJoined }}</p>
                </div>
            </div>

            <button
                data-id="{{ $group->id }}"
                class="join-btn mt-8 w-full text-white font-semibold py-4 px-6 rounded-xl approveButton"
                @if($group->start_date) disabled @endif
                >
                @if($group->start_date)
                Already Started
                @else
                Join Now
                @endif
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.approveButton').on('click', function() {
                const id = $(this).data('id');
                const button = $(this);

                Swal.fire({
                    title: 'Join Contribution?',
                    text: 'You are about to join this contribution group',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Join!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#094168',
                    cancelButtonColor: '#64748b',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'px-6 py-3',
                        cancelButton: 'px-6 py-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.prop('disabled', true)
                            .html('<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...</span>');

                        $.get("{{ route('join-contribution') }}?id=" + id)
                            .done(function(data) {
                                if (data.status === "ok") {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Successfully Joined!',
                                        text: data.message,
                                        confirmButtonColor: '#094168',
                                        customClass: {
                                            popup: 'rounded-2xl'
                                        }
                                    }).then(() => {
                                        window.location.href = "{{ route('dashboard') }}";
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: data.message,
                                        confirmButtonColor: '#094168',
                                        customClass: {
                                            popup: 'rounded-2xl'
                                        }
                                    });
                                    button.prop('disabled', false).text('Join Now');
                                }
                            })
                            .fail(function(error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.',
                                    confirmButtonColor: '#094168',
                                    customClass: {
                                        popup: 'rounded-2xl'
                                    }
                                });
                                button.prop('disabled', false).text('Join Now');
                            });
                    }
                });
            });
        });

        // Handle Laravel Flash Messages
        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: "{!! implode('', $errors->all('<p class=\"text-sm mb-1\">:message</p>')) !!}",
            confirmButtonColor: '#094168',
            customClass: {
                popup: 'rounded-2xl'
            }
        });
        @endif

        @if(session()->has('message') || session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session()->get('message') ?? session()->get('success') }}",
            confirmButtonColor: '#094168',
            customClass: {
                popup: 'rounded-2xl'
            }
        });
        @endif
    </script>
</body>

</html>