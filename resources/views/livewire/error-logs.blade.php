<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Log</h4>
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
                                    <th scope="col">Message</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Url</th>
                                    <th scope="col">File</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            @if($errors->count() > 0)
                                <tbody class="list form-check-all">
                                    @foreach ($errors as $transaction)
                                    <tr>
                                        <td class="fw-medium">{{ $loop->iteration }}</td>
                                        <td class="fw-medium">{{ $transaction->message}}</td>
                                        <td class="fw-medium">{{ $transaction->email }}</td>
                                        <td class="fw-medium">{{ $transaction->ur }}</td>
                                        <td class="fw-medium">{{ $transaction->file}}</td>
                                        <td class="text-muted">{{ $transaction->created_at }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            @endif
                        </table>
                        @if($errors->count() < 1)
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
                            {{ $errors->links() }}
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
