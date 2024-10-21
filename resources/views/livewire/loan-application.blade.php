<!-- end page title -->
<div>
    <div class="card">
        <div class="card-header border-0 rounded">
            <div class="row g-2">
                <div class="col-xl-3">
                    <div class="search-box">  
                        <input type="text" wire:model="filter" class="form-control search" placeholder="">  <i class="ri-search-line search-icon"></i>  
                    </div>
                </div><!--end col-->
                <div class="col-xl-2 ms-auto" >
                    <div style="display: none">
                        <select class="form-control" data-choices data-choices-search-false>
                            <option value="">Select Categories</option>
                            <option value="All">All</option>
                            <option value="Retailer">Retailer</option>
                            <option value="Health & Medicine">Health & Medicine</option>
                            <option value="Manufacturer">Manufacturer</option>
                            <option value="Food Service">Food Service</option>
                            <option value="Computers & Electronics">Computers & Electronics</option>
                        </select>
                    </div>
                </div><!--end col-->
                {{-- @if(count(auth()->user()->refers()) >= auth()->user()->plan()->referrer_no) --}}
                    <div class="col-lg-auto">
                        <div class="hstack gap-2">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addSeller"><i class="ri-add-fill me-1 align-bottom"></i> Make Application</button>
                        </div>
                    </div><!--end col-->
                {{-- @endif --}}
            </div><!--end row-->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">{{ $title }}</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customerList">
                        
                        <div class="table-responsive  mt-3 mb-1">
                            
                            <table class="table align-middle table-nowrap" >
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">S/N</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Refund</th>
                                        <th scope="col">Monthly Return</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Balance</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Approval Status</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                @if($loans->count() > 0)
                                    <tbody class="list form-check-all">
                                        @foreach ($loans as $transaction)
                                        <tr>
                                            <td class="fw-medium">{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ number_format($transaction->total_applied, 2) }}</td>
                                            <td class="fw-medium">{{ number_format($transaction->total_refund, 2) }}</td>
                                            <td class="fw-medium">{{ number_format($transaction->monthly_return, 2) }}</td>
                                            <td class="fw-medium">{{ $transaction->applied_date }}</td>
                                            <td class="fw-medium">{{ number_format($transaction->total_left, 2) }}</td>
                                            <td class="text-muted"><span class="badge bg-{{ $transaction->color() }}">{{ $transaction->status }}</span></td>
                                            <td class="text-muted"><span class="badge bg-{{ $transaction->approval() }}">{{ $transaction->approvalText() }}</span></td>
                                            <td class="text-muted"><span class="badge bg-{{ $transaction->payment() }}">{{ $transaction->paymentText() }}</span></td>
                                            <td class="text-muted">
                                                @if($transaction->approval_status == 1 && $transaction->status == "Awaiting" && $transaction->payment_status == 0)
                                                <button class="btn rounded-pill btn-sm btn-soft-info" onclick="processPayment(this)" data-amount="{{auth()->user()->plan()->form_amount  }}" data-id="{{ $transaction->uuid }}">Pay</button>
                                                @endif
                                                {{-- <span class="badge bg-{{ $transaction->color() }}">{{ $transaction->status }}</span> --}}
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                @endif
                            </table>
                            @if($loans->count() < 1)
                                <div class="noresult" >
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Sorry! No Record Found</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <div class="pagination-wrap hstack gap-2">
                                {{ $loans->links() }}
                            </div>
                        </div>
                    </div>
                </div><!-- end card -->
            </div>
            <!-- end col -->
        </div>
        <!-- end col -->
    </div>
<!-- end row -->
</div>
 
