@if($refers->count() > 0)
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Referrals</h5>
                    <!-- Swiper -->
                    <div class="swiper project-swiper mt-n4">
                        <div class="d-flex justify-content-end gap-2 mb-2">
                            <div class="slider-button-prev">
                                <div class="avatar-title fs-18 rounded px-1">
                                    <i class="ri-arrow-left-s-line"></i>
                                </div>
                            </div>
                            <div class="slider-button-next">
                                <div class="avatar-title fs-18 rounded px-1">
                                    <i class="ri-arrow-right-s-line"></i>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-wrapper">
                           @foreach ($refers as $refer)
                                <!-- end slide item -->
                                <div class="swiper-slide">
                                    <div class="card profile-project-card shadow-none profile-project-danger mb-0 @if($refers->count() == 1) mt-5 @endif">
                                        <div class="card-body p-4">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 text-muted overflow-hidden">
                                                    <h5 class="fs-14 text-truncate mb-1"><a href="#" class="text-dark">{{ $refer->name }}</a></h5>
                                                    <p class="text-muted text-truncate mb-0">Last Update : <span class="fw-semibold text-dark">1 hr Ago</span></p>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <div class="badge badge-soft-success fs-10">Completed</div>
                                                </div>
                                            </div>
                                            <div class="d-flex mt-4">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        {{-- <div>
                                                            <h5 class="fs-12 text-muted mb-0">Members :</h5>
                                                        </div> --}}
                                                        <div class="avatar-group">
                                                            <div class="avatar-group-item">
                                                                <div class="avatar-xs">
                                                                    <img @if($refer->profile_image) src="{{ asset("$refer->profile_image") }}" @else src="{{ asset('assets/images/avatar.png') }}" @endif alt="" class="rounded-circle img-fluid" />
                                                                </div>
                                                            </div>
                                                            <div class="avatar-group-item">
                                                                <div class="avatar-xs">
                                                                    <div class="avatar-title rounded-circle bg-light text-primary">
                                                                        C
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end slide item -->
                           @endforeach
                            <!-- end slide item -->
                        </div>
                        
                    </div>
            
                </div>
                <!-- end card body -->
            </div><!-- end card -->
        </div>
    </div>
@endif
