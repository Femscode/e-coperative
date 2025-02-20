<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/larkon/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Sep 2024 15:15:07 GMT -->

<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>SyncoSave | Dashboard</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="No. Ordering Platform" />
     <meta name="author" content="Techzaa" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />

     <!-- App favicon -->

     <meta name="csrf-token" content="{{ csrf_token() }}">

     <link rel="shortcut icon" href="{{ asset('admindashboard/images/logo/syncologo1.png') }}">
     <!-- Vendor css (Require in all Page) -->
     <link href="{{url('admindashboard/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />

     <!-- Icons css (Require in all Page) -->
     <link href="{{url('admindashboard/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

     <!-- App css (Require in all Page) -->
     <link href="{{url('admindashboard/css/app.min.css')}}" rel="stylesheet" type="text/css" />

     <!-- Theme Config js (Require in all Page) -->
     <script src="{{url('admindashboard/js/config.js')}}"></script>
     <style>
          .nav-tabs-custom {
               background: #fff;
               border-radius: 12px;
               box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
               overflow: hidden;
          }

          .nav-tabs-custom .nav-link {
               color: #6c757d;
               border: none;
               position: relative;
               transition: all 0.3s ease;
               text-decoration: none;
          }

          .nav-tabs-custom .nav-link:after {
               content: '';
               position: absolute;
               bottom: 0;
               left: 0;
               width: 100%;
               height: 3px;
               background: transparent;
               transition: all 0.3s ease;
          }

          .nav-tabs-custom .nav-link.active {
               color: #094168;
               background: rgba(13, 110, 253, 0.1);
          }

          .nav-tabs-custom .nav-link.active:after {
               background: #094168;
          }

          .nav-tabs-custom .nav-link:hover {
               background: rgba(108, 117, 125, 0.1);
          }
     </style>

     @yield('header')
</head>

<body>

     <!-- START Wrapper -->
     <div class="wrapper">

          <!-- ========== Topbar Start ========== -->
          <header class="topbar">
               <div class="container-fluid">
                    <div class="navbar-header">
                         <div class="d-flex align-items-center">
                              <!-- Menu Toggle Button -->
                              <div class="topbar-item">
                                   <button type="button" class="button-toggle-menu me-2">
                                        <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                                   </button>
                              </div>

                              <!-- Menu Toggle Button -->
                              <div class="topbar-item">
                                   <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0">SyncoSave!</h4>
                              </div>
                         </div>

                         <div class="d-flex align-items-center gap-1">

                              <!-- Theme Color (Light/Dark) -->
                              <div class="topbar-item">
                                   <button type="button" class="topbar-button" id="light-dark-mode">
                                        <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                                   </button>
                              </div>




                              <!-- User -->
                              <div class="dropdown topbar-item">
                                   <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-flex align-items-center">
                                             @if($user->image ?? auth()->user()->image !== null)
                                             <img src="https://syncosave.com/synco_files/public/{{ Auth::user()->profile_image }}"
                                                  alt="" class="rounded-circle" width="32">
                                             @else
                                             <img src="{{url('assets/images/avatar.png')}}"
                                                  alt="" class="rounded-circle" width="32">
                                             @endif
                                        </span>
                                   </a>
                                   <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <h6 class="dropdown-header">Welcome {{$user->name ?? auth()->user()->name }}!</h6>
                                        <a class="dropdown-item" href="/my-profile">
                                             <i class="bx bx-user-circle text-muted fs-18 align-middle me-1"></i><span class="align-middle">Profile</span>
                                        </a>

                                        <a class="dropdown-item" href="https://wa.me/2349058744473?">
                                             <i class="bx bx-help-circle text-muted fs-18 align-middle me-1"></i><span class="align-middle">Contact Us</span>
                                        </a>


                                        <div class="dropdown-divider my-1"></div>

                                        <a class="dropdown-item text-danger" href="/logout" onclick="return confirm('Are you sure you want to logout?')">
                                             <i class="bx bx-log-out fs-18 align-middle me-1"></i><span class="align-middle">Logout</span>
                                        </a>
                                   </div>
                              </div>

                              <!-- App Search-->
                              <!-- <form class="app-search d-none d-md-block ms-2">
                                   <div class="position-relative">
                                        <input type="search" class="form-control" placeholder="Search..." autocomplete="off" value="">
                                        <iconify-icon icon="solar:magnifer-linear" class="search-widget-icon"></iconify-icon>
                                   </div>
                              </form> -->
                         </div>
                    </div>
               </div>
          </header>



          <!-- ========== App Menu Start ========== -->
          <div class="main-nav">
               <!-- Sidebar Logo -->
               <div class="logo-box">
                    <a href="/admin" class="logo-dark">

                         <img src="{{ asset('admindashboard/images/logo/syncologo1.png') }}" alt="" width="70%">

                    </a>

                    <a href="/admin" class="logo-light">
                         <img src="{{ asset('admindashboard/images/logo/syncologo1.png') }}" alt="" width="70%">

                    </a>
               </div>

               <!-- Menu Toggle Button (sm-hover) -->
               <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
                    <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
               </button>

               <div class="scrollbar" data-simplebar>
                    @if(auth()->user()->plan()->type == 1)
                    @include('ajo.admin-coop-sidebar')
                    @else
                    @include('ajo.admin-ajo-sidebar')
                    @endif
               </div>
          </div>
          <!-- ========== App Menu End ========== -->

          <!-- ==================================================== -->
          <!-- Start right Content here -->
          <!-- ==================================================== -->
          <div class="page-content">

               <!-- Start Container Fluid -->
               @yield('content')
               <!-- End Container Fluid -->

               <!-- ========== Footer Start ========== -->
               <footer class="footer">
                    <div class="container-fluid">
                         <div class="row">
                              <div class="col-12 text-center">
                                   <script>
                                        document.write(new Date().getFullYear())
                                   </script> &copy; SyncoSave.
                                  </div>
                         </div>
                    </div>
               </footer>
               <!-- ========== Footer End ========== -->

          </div>


     </div>
     <!-- END Wrapper -->
     @livewireScripts
     <!-- Vendor Javascript (Require in all Page) -->
     <script src="{{url('admindashboard/js/vendor.js')}}"></script>

     <!-- App Javascript (Require in all Page) -->
     <script src="{{url('admindashboard/js/app.js')}}"></script>

     <!-- Vector Map Js -->
     <script src="{{url('admindashboard/vendor/jsvectormap/js/jsvectormap.min.js')}}"></script>
     <script src="{{url('admindashboard/vendor/jsvectormap/maps/world-merc.js')}}"></script>
     <script src="{{url('admindashboard/vendor/jsvectormap/maps/world.js')}}"></script>

     <!-- Dashboard Js -->
     <script src="{{url('admindashboard/js/pages/cooperative.admin.js')}}"></script>
     <script src="{{url('cdn/sweetalert.min.js')}}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script src="{{ asset('admindashboard/js/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('js\requestController.js') }}"></script>
     <script src="{{ asset('js\formController.js') }}"></script>

     <script src="{{url('assets/js/professionallocker.js')}}"></script>
     <script>
          $(document).ready(function() {
               var oTable = $('.datatable').DataTable({
                    ordering: false,
                    searching: true
               });
          })
          var hashTable = $('#datatable').DataTable({
               ordering: false,
               searching: true
          });
     </script>

     @yield('script')

</body>

</html>