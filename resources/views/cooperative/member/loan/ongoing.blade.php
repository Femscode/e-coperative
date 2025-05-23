@extends('cooperative.member.master')
@section('main')
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <img src='{{url("assets/images/payaza1.gif")}}' alt='payaza' width='50%' />

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="payaza-form">
                    <div class='alert alert-danger'>For testing purpose, kindly use the default prefilled card details</div>
                    <div class='text-center'>Amount To Be Paid</div>
                    <h1 class='text-center text-red' style='color:#212529;border:0px'>NGN<span id='amountToBePaid'>0</span></h1>
                    <div class="mb-3">
                        <label for="card-number" class="form-label">Card Number</label>
                        <input type='hidden' id='order_id' />

                        <input type="text" value='4012000033330026' id="card-number" class="form-control" required placeholder="Enter Card Number">
                    </div>
                    <div class='form-group row'>
                        <div class="mb-3 col">
                            <label for="expiry-date" class="form-label">Expiry Date</label>
                            <input value='01/39' type="text" id="expiry-date" class="form-control" required placeholder="MM/YY">
                        </div>
                        <div class="mb-3 col">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" value='100' id="cvv" class="form-control" required placeholder="Enter CVV">
                        </div>
                    </div>
                    <div class='justify-content-center d-flex'>
                        <button type="submit" style='background:#212529;border:0px' class="btn btn-success">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<main class="adminuiux-content has-sidebar" onclick="contentClick()">
    <div class="container mt-4" id="main-content">

        <!-- start page title -->


        @livewire('member-ongoing-loan')



        </>
</main>
<!-- container-fluid -->
@endsection