

<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            
            <form method="Post" action="{{route('create_user')}}">
                @csrf
                <div class="modal-body">

                    <div class="mb-3" id="modal-id" style="display: none;">
                        <label for="id-field" class="form-label">ID</label>
                        <input type="text" id="id-field" class="form-control" placeholder="ID" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Enter Name" name="name" required />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter Email" name="email" required />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control"  placeholder="Enter Password" name="password" required />
                    </div>

                
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="update-btn">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div>
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-sm-4">
                    <div>
                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#addUser"><i class="ri-add-line align-bottom me-1"></i> Add Member</button>
                    </div>
                </div><!--end col-->
                <div class="col-sm-auto ms-auto">
                    <div class="list-grid-nav hstack gap-1">
                    <a class='btn btn-secondary' href='download_member_template'>Download Template</a>

                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#showModal"><i class="ri-add-fill me-1 align-bottom"></i> Upload Members</button>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
           
        <div class="col-md-6 mb-2 form-group">
    <div class="input-group">
        <input class="form-control" type="text" placeholder="Search for members by name, email or coopID"/>
        <button type="submit" class="btn btn-success">Search</button>
    </div>
</div>

            <div>
                <div class="team-list grid-view-filter row">
                    @foreach ($members as $member)
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="position-relative bg-light p-2 rounded text-center">
                                    <img @if($member->cover_image) src="https://e-coop.cthostel.com/ecoop_files/public/file/{{ $member->cover_image }}" @else src="{{ asset('assets/images/avatar.png') }}" @endif alt="" class="avatar-xxl">

                                </div>
                                <div class="d-flex flex-wrap justify-content-between my-3">
                                    <div>
                                        <h4 class="mb-1">{{ $member->name }}<span class="text-muted fs-13 ms-1">{{ strtoupper(Str::of($member->name)->explode(' ')->map(fn($word) => substr($word, 0, 1))->implode('')) }} </span></h4>
                                        <div>
                                            <a href="#!" class="link-primary fs-16 fw-medium">{{ $member->email }}</a>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0"><span class="badge bg-light text-dark fs-12 me-1"><i class="bx bxs-star align-text-top fs-14 text-warning me-1"></i> Coop ID: {{ $member->coop_id }}</span></p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mt-3 mb-1">
                                    <p class="mb-0 fs-15 fw-medium text-dark">Referrals</p>
                                    <div>
                                        <p class="mb-0 fs-15 fw-medium text-dark">{{ $member->refers()->count() }} <span class="ms-1"><iconify-icon icon="solar:course-up-outline" class="text-success"></iconify-icon></span></p>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer border-top gap-1 hstack">
                                <a href="{{ route('admin-member-details', $member->id) }}" class="btn btn-primary w-100">View Profile</a>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col">
                        <div class="card team-box">
                            <div class="team-cover">
                                <img @if($member->cover_image) src="{{ asset("$member->cover_image") }}" @else src="{{ asset('assets/images/profile-bg.jpg') }}" @endif alt="" class="img-fluid" />
                            </div>
                            <div class="card-body p-4">
                                <div class="row align-items-center team-row">
                                    <div class="col team-settings">
                                        <div class="row">
                                            <div class="col">
                                            <div class="bookmark-icon flex-shrink-0 me-2">
                                                <input type="checkbox" id="favourite1" class="bookmark-input bookmark-hide">
                                                <label for="favourite1" class="btn-star">
                                                    <svg width="20" height="20">
                                                        <use xlink:href="#icon-star"/>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                            <div class="col text-end dropdown">
                                                <a href="javascript:void(0);" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill fs-17"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                                    <li><a class="dropdown-item" href="{{ route('admin-member-details', $member->id) }}"><i class="ri-eye-line me-2 align-middle"></i>View</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-line me-2 align-middle"></i>Favorites</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col">
                                        <div class="team-profile-img">
                                            <div class="avatar-lg img-thumbnail rounded-circle flex-shrink-0">
                                                {{-- <img src="assets/images/users/avatar-2.jpg" alt="" class="img-fluid d-block rounded-circle" /> --}}
                                                <div class="avatar-title bg-soft-danger text-danger rounded-circle">
                                                    {{ strtoupper(Str::of($member->name)->explode(' ')->map(fn($word) => substr($word, 0, 1))->implode('')) }}
                                                </div>
                                            </div>
                                            <div class="team-content">
                                                <a data-bs-toggle="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">
                                                    <h5 class="fs-16 mb-1">{{ $member->name }}</h5>
                                                </a>
                                                <p class="text-muted mb-0">{{ $member->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col">
                                        <div class="row text-muted text-center">
                                            <div class="col-6 border-end border-end-dashed">
                                                <h5 class="mb-1">{{ $member->coop_id }}</h5>
                                                <p class="text-muted mb-0">Mem No</p>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="mb-1">{{ $member->refers()->count() }}</h5>
                                                <p class="text-muted mb-0">Referrals</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col">
                                        <div class="text-end">
                                            <a href="{{ route('admin-member-details', $member->id) }}" class="btn btn-light view-btn">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!--end col-->
                    @endforeach
                    <div class="col-lg-12">
                        <div class="text-center mb-3">
                            {{ $members->links() }}
                            {{-- <a href="javascript:void(0);" class="text-success"><i class="mdi mdi-loading mdi-spin fs-20 align-middle me-2"></i> Load More </a> --}}
                        </div>
                    </div>
                </div><!--end row-->

                <!-- Modal -->
                <div class="modal fade" id="addmembers" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Add New Members</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="teammembersName" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="teammembersName" placeholder="Enter name">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="designation" class="form-label">Designation</label>
                                                <input type="text" class="form-control" id="designation" placeholder="Enter designation">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="totalProjects" class="form-label">Projects</label>
                                                <input type="number" class="form-control" id="totalProjects" placeholder="Total projects">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="totalTasks" class="form-label">Tasks</label>
                                                <input type="number" class="form-control" id="totalTasks" placeholder="Total tasks">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-4">
                                                <label for="formFile" class="form-label">Profile Images</label>
                                                <input class="form-control" type="file" id="formFile">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Add Member</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!--end modal-content-->
                    </div><!--end modal-dialog-->
                </div><!--end modal-->

                <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="offcanvasExample">
                    <!--end offcanvas-header-->
                    <div class="offcanvas-body profile-offcanvas p-0">
                        <div class="team-cover">
                            <img src="assets/images/small/img-9.jpg" alt="" class="img-fluid" />
                        </div>
                        <div class="p-3">
                            <div class="team-settings">
                                <div class="row">
                                    <div class="col">
                                        <div class="bookmark-icon flex-shrink-0 me-2">
                                            <input type="checkbox" id="favourite13" class="bookmark-input bookmark-hide">
                                            <label for="favourite13" class="btn-star">
                                                <svg width="20" height="20">
                                                    <use xlink:href="#icon-star" />
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col text-end dropdown">
                                        <a href="javascript:void(0);" id="dropdownMenuLink14" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill fs-17"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink14">
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-eye-line me-2 align-middle"></i>View</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-star-line me-2 align-middle"></i>Favorites</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"><i class="ri-delete-bin-5-line me-2 align-middle"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!--end col-->
                        </div>
                        <div class="p-3 text-center">
                            <img src="assets/images/users/avatar-2.jpg" alt="" class="avatar-lg img-thumbnail rounded-circle mx-auto">
                            <div class="mt-3">
                                <h5 class="fs-15"><a href="javascript:void(0);" class="link-primary">Nancy Martino</a></h5>
                                <p class="text-muted">Team Leader & HR</p>
                            </div>
                            <div class="hstack gap-2 justify-content-center mt-4">
                                <div class="avatar-xs">
                                    <a href="javascript:void(0);" class="avatar-title bg-soft-secondary text-secondary rounded fs-16">
                                        <i class="ri-facebook-fill"></i>
                                    </a>
                                </div>
                                <div class="avatar-xs">
                                    <a href="javascript:void(0);" class="avatar-title bg-soft-success text-success rounded fs-16">
                                        <i class="ri-slack-fill"></i>
                                    </a>
                                </div>
                                <div class="avatar-xs">
                                    <a href="javascript:void(0);" class="avatar-title bg-soft-info text-info rounded fs-16">
                                        <i class="ri-linkedin-fill"></i>
                                    </a>
                                </div>
                                <div class="avatar-xs">
                                    <a href="javascript:void(0);" class="avatar-title bg-soft-danger text-danger rounded fs-16">
                                        <i class="ri-dribbble-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row g-0 text-center">
                            <div class="col-6">
                                <div class="p-3 border border-dashed border-start-0">
                                    <h5 class="mb-1">124</h5>
                                    <p class="text-muted mb-0">Projects</p>
                                </div>
                            </div><!--end col-->
                            <div class="col-6">
                                <div class="p-3 border border-dashed border-start-0">
                                    <h5 class="mb-1">81</h5>
                                    <p class="text-muted mb-0">Tasks</p>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="p-3">
                            <h5 class="fs-15 mb-3">Personal Details</h5>
                            <div class="mb-3">
                                <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Number</p>
                                <h6>+(256) 2451 8974</h6>
                            </div>
                            <div class="mb-3">
                                <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Email</p>
                                <h6>nancymartino@email.com</h6>
                            </div>
                            <div>
                                <p class="text-muted text-uppercase fw-semibold fs-12 mb-2">Location</p>
                                <h6 class="mb-0">Carson City - USA</h6>
                            </div>
                        </div>
                        <div class="p-3 border-top">
                            <h5 class="fs-15 mb-4">File Manager</h5>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 avatar-xs">
                                    <div class="avatar-title bg-soft-danger text-danger rounded fs-16">
                                        <i class="ri-image-2-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"><a href="javascript:void(0);">Images</a></h6>
                                    <p class="text-muted mb-0">4469 Files</p>
                                </div>
                                <div class="text-muted">
                                    12 GB
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 avatar-xs">
                                    <div class="avatar-title bg-soft-secondary text-secondary rounded fs-16">
                                        <i class="ri-file-zip-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"><a href="javascript:void(0);">Documents</a></h6>
                                    <p class="text-muted mb-0">46 Files</p>
                                </div>
                                <div class="text-muted">
                                    3.46 GB
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 avatar-xs">
                                    <div class="avatar-title bg-soft-success text-success rounded fs-16">
                                        <i class="ri-live-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"><a href="javascript:void(0);">Media</a></h6>
                                    <p class="text-muted mb-0">124 Files</p>
                                </div>
                                <div class="text-muted">
                                    4.3 GB
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 avatar-xs">
                                    <div class="avatar-title bg-soft-primary text-primary rounded fs-16">
                                        <i class="ri-error-warning-line"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1"><a href="javascript:void(0);">Others</a></h6>
                                    <p class="text-muted mb-0">18 Files</p>
                                </div>
                                <div class="text-muted">
                                    846 MB
                                </div>
                            </div>
                        </div>
                    </div><!--end offcanvas-body-->
                    <div class="offcanvas-foorter border p-3 hstack gap-3 text-center position-relative">
                        <button class="btn btn-light w-100"><i class="ri-question-answer-fill align-bottom ms-1"></i> Send Message</button>
                        <a href="pages-profile.html" class="btn btn-primary w-100"><i class="ri-user-3-fill align-bottom ms-1"></i> View Profile</a>
                    </div>
                </div><!--end offcanvas-->
            </div>
        </div><!-- end col -->
    </div><!--end row-->
</div>
