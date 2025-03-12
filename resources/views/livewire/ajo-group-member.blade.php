<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">{{ $title }}</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="customerList">
                    <div class="row g-4 mb-3">
                        {{-- <div class="col-sm-auto">
                            <div>
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control " wire:model="search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div> --}}
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Line</th>
                                    <th scope="col">Date Joined</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            @if($members->count() > 0)
                                <tbody class="list form-check-all">
                                    @foreach ($members as $transaction)
                                    <tr>
                                        <td class="fw-medium">{{ $transaction->user->name }}</td>
                                        <td class="fw-medium">{{ $transaction->turn }}</td>
                                        <td class="fw-medium">{{ $transaction->created_at }}</td>
                                        <td class="text-muted">
                                            @if($transaction->packed == 0)
                                                @if($nextMember && $nextMember->id == $transaction->id)
                                                <button class="btn rounded-pill btn-sm btn-soft-info disburseButton" data-id="{{ $transaction->id }}">Disburse</button>
                                                @endif
                                                {{-- <span class="badge bg-warning">Processing</span> --}}
                                            @else
                                                <span class="badge bg-info ">PAID</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            @endif
                        </table>
                        @if($members->count() < 1)
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
                            {{ $members->links() }}
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