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

     <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
     <style>
          .transaction-list {
               display: flex;
               flex-direction: column;
               gap: 0.5rem;
          }

          .transaction-item {
               display: grid;
               grid-template-columns: auto 2fr 2fr 1fr;
               align-items: center;
               gap: 1rem;
               padding: 0.75rem;
               background: #fff;
               border-radius: 8px;
               transition: all 0.2s ease;
               border: 1px solid #eee;
          }

          .transaction-item:hover {
               background: #f8f9fa;
               transform: translateX(4px);
          }

          .t-icon {
               width: 36px;
               height: 36px;
               border-radius: 8px;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 18px;
          }

          .transaction-item[data-type="Registration"] .t-icon {
               background: rgba(67, 24, 255, 0.1);
               color: #4318FF;
          }

          .transaction-item[data-type="Monthly Dues"] .t-icon {
               background: rgba(27, 231, 255, 0.1);
               color: #1BE7FF;
          }

          .transaction-item[data-type="Repayment"] .t-icon {
               background: rgba(52, 202, 165, 0.1);
               color: #34CAA5;
          }

          .t-info {
               line-height: 1.2;
          }

          .t-user {
               font-weight: 600;
               color: #2c3345;
          }

          .t-type {
               font-size: 0.813rem;
               color: #6c757d;
          }

          .t-details {
               line-height: 1.2;
          }

          .t-month {
               font-size: 0.875rem;
               color: #2c3345;
          }

          .t-date {
               font-size: 0.813rem;
               color: #6c757d;
          }

          .t-amount {
               font-weight: 600;
               color: #2c3345;
               text-align: right;
          }

          .search-box {
               position: relative;
               width: 250px;
          }

          .search-input {
               padding: 0.5rem 1rem 0.5rem 2.5rem;
               border-radius: 6px;
               border: 1px solid #e0e0e0;
               font-size: 0.875rem;
          }

          .search-icon {
               position: absolute;
               left: 1rem;
               top: 50%;
               transform: translateY(-50%);
               color: #6c757d;
          }

          /* Update icon styles */
          .t-icon {
               width: 36px;
               height: 36px;
               border-radius: 8px;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 16px;
          }

          /* Update transaction status colors */
          .t-amount[data-status="pending"] {
               color: #F59E0B;
          }

          .t-amount[data-status="success"] {
               color: #10B981;
          }

          .t-amount[data-status="failed"] {
               color: #EF4444;
          }

          /* Update icon backgrounds */
          .transaction-item[data-type="Registration"] .t-icon {
               background: #EEF2FF;
               color: #4F46E5;
          }

          .transaction-item[data-type="Monthly Dues"] .t-icon {
               background: #ECFDF5;
               color: #059669;
          }

          .transaction-item[data-type="Repayment"] .t-icon {
               background: #FEF3C7;
               color: #D97706;
          }

          /* Simplify date display */
          .t-date {
               font-size: 0.875rem;
               color: #6B7280;
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