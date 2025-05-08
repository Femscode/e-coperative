<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">{{ $title }}</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="customerList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3 mb-1">
                            <table class="datatable table align-middle table-nowrap">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Period</th>
                                    </tr>
                                </thead>
                                @if(count($months) > 0)
                                <tbody class="list form-check-all">
                                    @foreach ($months as $transaction)
                                    <tr>
                                        <td class="fw-medium">
                                            <div class="align-items-center gap-3">
                                                <div>
                                                    <h6 class="mb-1 fw-semibold">{{ $transaction['name'] }}</h6>
                                                    <p class="mb-0 text-muted">₦{{ number_format($transaction['amount'], 2) }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-medium">
                                            {{ $transaction['month'] }}
                                            <br>
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1">Pending</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @endif
                            </table>
                            @if(count($months) < 1)
                                <div class="noresult">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                            trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
    </div>
</div>