@extends('ajo.member.master')

@section('main')
<!-- Payment Modal -->


<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div class="mb-3 mb-md-0">
                <h3 class="fw-bold mb-1">My Contribution Circle</h3>
                <!-- <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#" class="text-decoration-none">
                                <i class="bi bi-house-door small"></i>
                                <span class="ms-2">Contribution</span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Circle</li>
                    </ol>
                </nav> -->
            </div>
            <div>
                <button class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>
                    New Contribution
                </button>
            </div>
        </div>

        @livewire('member-contribution-livewire')
    </div>
</main>

<style>
.modal-content {
    border-radius: 1rem;
    overflow: hidden;
}

.form-control {
    border-radius: 0.5rem;
    border: 1px solid #e0e0e0;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    border-color: #094168;
    box-shadow: 0 0 0 0.2rem rgba(9, 65, 104, 0.1);
}

.input-group-text {
    background: transparent;
    border-left: 0;
}

.btn-primary {
    background: #094168;
    border: none;
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #073251;
    transform: translateY(-1px);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "•";
}

.breadcrumb-item a {
    color: #6c757d;
}

.breadcrumb-item.active {
    color: #094168;
    font-weight: 500;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
}
</style>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if(Session::has('message'))
        showCustomAlert({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get('
            message ') }}'
        });
        @endif
        @if(Session::has('error'))
        showCustomAlert({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get('
            error ') }}'
        });
        @endif
        var preLoader = $(".preloader")
        //copy link
        $(".copy-btn").click(function() {
            // Get the link from the data attribute of the clicked button
            var link = $(this).data("link");

            // Copy the link to the clipboard
            navigator.clipboard.writeText(link).then(() => {
                alert("Link copied: " + link);
            }).catch(err => {
                console.error("Failed to copy: ", err);
            });
        });
        // save contribution group
        $("#importMemberForm").on('submit', async function(e) {
            e.preventDefault();
            $(".preloader").show()
            const serializedData = $("#importMemberForm").serializeArray();
            try {
                const postRequest = await request("/admin/group/create",
                    processFormInputs(
                        serializedData), 'post');
                // console.log('postRequest.message', postRequest.message);
                new swal("Good Job", postRequest.message, "success");
                $('#importMemberForm').trigger("reset");
                $("#importMemberForm .close").click();
                window.location.reload();
            } catch (e) {
                $(".preloader").hide()
                if ('message' in e) {
                    // console.log('e.message', e.message);
                    new swal("Opss", e.message, "error");

                }
            }
        })
        //on input amount
        $(".loanAmount").keypress(function(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            $(".loanAmount").on('keyup', function() {
                // event.preventDefault();
                var n = parseInt($(this).val().replace(/\D/g, ''), 10);
                $(this).val(n.toLocaleString());
                if (isNaN(n)) {
                    $(".loanAmount").val("");
                    // $(this).val();
                }

            });
        });
        $('body').on('click', '.edit-user', function() {
            var id = $(this).data('id');
            $.get("{{ route('user_details') }}?id=' + id,
                function(data) {
                    // alert('hhgf');
                    $('#idUser').val(data.id);
                    $('#emailDetail').val(data.email);
                    $('#nameDetail').val(data.name);
                })
        });

        $("#frm_main").on('submit', async function(e) {
            e.preventDefault();
            const serializedData = $("#frm_main").serializeArray();

            try {

                const willUpdate = await new swal({
                    title: "Confirm Action",
                    text: `Are you sure you want to submit?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Submit"]
                });
                // console.log(willUpdate);
                if (willUpdate) {
                    //performReset()
                    const postRequest = await request("/admin/user/update",
                        processFormInputs(
                            serializedData), 'post');
                    console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    $('#frm_main').trigger("reset");
                    $("#frm_main .close").click();
                    window.location.reload();
                } else {
                    new swal("Process aborted  :)");
                }

            } catch (e) {
                if ('message' in e) {
                    console.log('e.message', e.message);
                    new swal("Opss", e.message, "error");

                }
            }
        })


        /* When click approve button */
        $('body').on('click', '.approveButton', function() {
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert("here")
            startAccount(el, id);
        });
        async function startAccount(el, id) {
            const willUpdate = await new swal({
                title: "Confirm User Action",
                text: `Are you sure you want to start this contribution?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Am In!"]
            });
            if (willUpdate.isConfirmed == true) {
                //performReset()
                performStart(el, id);
            } else {
                new swal("Opss", "Operation Terminated", "error");
            }
        }

        function performStart(el, id) {
            $('.approveButton').prop('disabled', true).text('Loading ...');
            try {
                // alert(data);
                $.get("{{ route('start-contribution') }}?id=" + id,
                    function(data, status) {
                        // console.log(data, status);
                        //    alert(data.message)
                        if (data.status == "ok") {
                            let alert = new swal("Good Job", data.message, "success");
                            window.location.href = "{{ route('admin_group_home') }}";
                        } else {
                            $('.approveButton').prop('disabled', false).text('Start');
                            new swal("Opss", data.message, "error");
                        }

                    }
                );
            } catch (e) {
                $('.approveButton').prop('disabled', false).text('Start');
                // alert("here")
                let alert = new swal("Opss", e.message, "error");
            }
        }


        /* When click delete button */
        $('body').on('click', '#deleteRecord', function() {
            var user_id = $(this).data('id');
            // alert(user_id)
            var token = $("meta[name='csrf-token']").attr("content");
            var el = this;
            // alert(user_id);
            resetAccount(el, user_id);
        });

        async function resetAccount(el, user_id) {
            const willUpdate = await new swal({
                title: "Confirm Delete",
                text: `Are you sure you want to delete this record?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Delete"]
            });
            // console.log(willUpdate);
            if (willUpdate) {
                //performReset()
                performDelete(el, user_id);
            } else {
                new swal("User record will not be deleted  :)");
            }
        }

        function performDelete(el, user_id) {
            //alert(user_id);
            try {
                $.get("{{ route('delete_users') }}?id=" + user_id,
                    function(data, status) {
                        if (data.status === "error") {
                            new swal("Opss", data.message, "error");
                        } else {
                            if (status === "success") {
                                let alert = new swal(" record successfully deleted!.");
                                $(el).closest("tr").remove();
                                window.location.reload();
                                // alert.then(() => {
                                // });
                            }
                        }

                    }
                );
            } catch (e) {
                let alert = new swal(e.message);
            }
        }

    })
</script>
@endsection