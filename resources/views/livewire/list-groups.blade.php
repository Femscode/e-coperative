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
                                    <th scope="col">Title</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Mode</th>
                                    <th scope="col">Min</th>
                                    <th scope="col">Max</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Joined</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @if($loans->count() > 0)
                                <tbody class="list form-check-all">
                                    @foreach ($loans as $transaction)
                                    <tr>
                                        <td class="fw-medium">{{ $transaction->title }}</td>
                                        <td class="fw-medium" style="text-align: center">{{ number_format($transaction->amount, 2) }}</td>
                                        <td class="fw-medium" style="text-align: center">{{ $transaction->mode }}</td>
                                        <td class="fw-medium" style="text-align: center">{{ $transaction->min }}</td>
                                        <td class="fw-medium" style="text-align: center">{{ $transaction->max }}</td>
                                        <td class="fw-medium">                                            
                                            <button class="btn copy-btn rounded-pill btn-sm btn-soft-info" data-link="{{ $transaction->link }}">Copy Link</button>
                                        </td>
                                        <td class="fw-medium"><a href="{{ route('admin_group_members', $transaction->uuid) }}"> {{ $transaction->members->count() }} </a></td>
                                        <td class="text-muted">
                                            @if($transaction->status == 0)
                                            <button class="btn rounded-pill btn-sm btn-soft-info approveButton" data-id="{{ $transaction->id }}">Start</button>
                                            <span class="badge bg-warning">Processing</span>
                                            @else
                                            <span class="badge bg-info ">Ongoing</span>
                                            <a href="{{ route('contribution-dues', $transaction->uuid) }}">View Dues</a>
                                            @endif
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