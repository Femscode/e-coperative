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
                                    <th scope="col">Description</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            @if($transactions->count() > 0)
                                <tbody class="list form-check-all">
                                    @foreach ($transactions as $transaction)
                                    <tr>
                                        <td class="fw-medium">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $transaction->user->name ?? ""}}</td>
                                        <td class="fw-medium">{{ $transaction->payment_type }}</td>
                                        <td class="fw-medium">{{ $transaction->month }}</td>
                                        <td class="fw-medium">{{ number_format($transaction->original, 2) }}</td>
                                        <td class="text-muted">{{ $transaction->updated_at }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            @endif
                        </table>
                        @if($transactions->count() < 1)
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
                            {{ $transactions->links() }}
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
