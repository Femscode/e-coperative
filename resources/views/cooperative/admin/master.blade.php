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
          .dropdown-toggle::after {
               font-family: boxicons;
               content: "\ea4a";
               position: relative;
               display: none !important;
               top: 3px;
               margin-left: 0.255em;
               font-size: 16px;
               font-weight: 400;
               line-height: 1;
               text-rendering: auto;
               text-transform: none;
          }

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
     <link href="{{ url('admindashboard/css/sweetalert-custom.css') }}" rel="stylesheet">

     <script src="{{ asset('admindashboard/js/sweetalert-custom.js') }}"></script>

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
                              <!-- User -->
                              <div class="dropdown">


                                   <style>
                                        .avatar-icon {
                                             width: 32px;
                                             height: 32px;
                                             border-radius: 50%;
                                             background: linear-gradient(45deg, #094168, #0d6efd);
                                             display: flex;
                                             align-items: center;
                                             justify-content: center;
                                             color: white;
                                             font-size: 18px;
                                             transition: all 0.3s ease;
                                             animation: pulse 2s infinite;
                                        }

                                        @keyframes pulse {
                                             0% {
                                                  box-shadow: 0 0 0 0 rgba(9, 65, 104, 0.4);
                                             }

                                             70% {
                                                  box-shadow: 0 0 0 10px rgba(9, 65, 104, 0);
                                             }

                                             100% {
                                                  box-shadow: 0 0 0 0 rgba(9, 65, 104, 0);
                                             }
                                        }

                                        .dropdown:hover .avatar-icon {
                                             transform: scale(1.1);
                                        }
                                   </style>
                                   <button type="button" class=" dropdown-toggle p-0 border-0" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="d-flex align-items-center">
                                             <div class="avatar-icon">
                                                  <i class="ri-user-3-fill"></i>
                                             </div>
                                             <span class="ms-2 d-none d-sm-inline-block">
                                                  {{ $user->name ?? auth()->user()->name }}
                                                  <i class="ri-arrow-down-s-line"></i>
                                             </span>
                                        </span>
                                   </button>
                                   <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                             <h6 class="dropdown-header">Welcome {{$user->name ?? auth()->user()->name }}!</h6>
                                        </li>
                                        <li>
                                             <a class="dropdown-item d-flex align-items-center" href="/admin/faq">
                                                  <i class="bx bx-user-circle text-muted fs-18 me-2"></i>
                                                  <span>F.A.Q</span>
                                             </a>
                                        </li>
                                        <li>
                                             <a class="dropdown-item d-flex align-items-center" href="https://wa.me/2349058744473">
                                                  <i class="bx bx-help-circle text-muted fs-18 me-2"></i>
                                                  <span>Contact Us</span>
                                             </a>
                                        </li>
                                        <li>
                                             <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                             <a class="dropdown-item d-flex align-items-center text-danger" href="/logout" onclick="return confirm('Are you sure you want to logout?')">
                                                  <i class="bx bx-log-out fs-18 me-2"></i>
                                                  <span>Logout</span>
                                             </a>
                                        </li>
                                   </ul>
                              </div>
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