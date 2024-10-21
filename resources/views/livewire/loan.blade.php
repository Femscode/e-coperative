<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">{{ $title }}</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control " wire:model="search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control " wire:model="search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    
                    <div class="table-responsive  mt-3 mb-1">
                        
                        <table class="table align-middle table-nowrap" >
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">S/N</th>
                                    <th scope="col">Member</th>
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
                                        <td class="fw-medium">{{ $transaction->member->name }}</td>
                                        <td class="fw-medium">{{ number_format($transaction->total_applied, 2) }}</td>
                                        <td class="fw-medium">{{ number_format($transaction->total_refund, 2) }}</td>
                                        <td class="fw-medium">{{ number_format($transaction->monthly_return, 2) }}</td>
                                        <td class="fw-medium">{{ $transaction->applied_date }}</td>
                                        <td class="fw-medium">{{ number_format($transaction->total_left, 2) }}</td>
                                        <td class="text-muted"><span class="badge bg-{{ $transaction->color() }}">{{ $transaction->status }}</span></td>
                                        <td class="text-muted"><span class="badge bg-{{ $transaction->approval() }}">{{ $transaction->approvalText() }}</span></td>
                                        <td class="text-muted"><span class="badge bg-{{ $transaction->payment() }}">{{ $transaction->paymentText() }}</span></td>
                                        <td class="text-muted">
                                            @if($transaction->approval_status == 0)
                                            <button class="btn approveButton rounded-pill btn-sm btn-soft-info" data-id="{{ $transaction->id }}">Approve</button>
                                            @endif
                                            @if($transaction->payment_status == 1 && $transaction->status == "Awaiting")
                                            <button class="btn disburseButton rounded-pill btn-sm btn-soft-info" data-id="{{ $transaction->id }}">Disburse</button>
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
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
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