<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/larkon/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Sep 2024 15:15:07 GMT -->

<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>ECoop | Coop's Dashboard</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="No. Ordering Platform" />
     <meta name="author" content="Techzaa" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />

     <!-- App favicon -->

     <meta name="csrf-token" content="{{ csrf_token() }}">

     <link rel="shortcut icon" href="{{ asset('assets/images/cooplogo.png') }}">
     <!-- Vendor css (Require in all Page) -->
     <link href="{{url('vendorsdashboard/css/vendor.min.css')}}" rel="stylesheet" type="text/css" />

     <!-- Icons css (Require in all Page) -->
     <link href="{{url('vendorsdashboard/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

     <!-- App css (Require in all Page) -->
     <link href="{{url('vendorsdashboard/css/app.min.css')}}" rel="stylesheet" type="text/css" />

     <!-- Theme Config js (Require in all Page) -->
     <script src="{{url('vendorsdashboard/js/config.js')}}"></script>


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
                                   <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0">Welcome!</h4>
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
                                             <img src="https://e-coop.cthostel.com/ecoop_files/public/{{ Auth::user()->profile_image }}"
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

                    <img src="{{ asset('assets/images/cooplogo.png') }}" alt="" height="30"> 
                    <span class='text-white' style='font-size:large'>E-COOP</span>
                    </a>

                    <a href="/admin" class="logo-light">
                    <img src="{{ asset('assets/images/cooplogo.png') }}" alt="" height="30"> 
                    <span class='text-white' style='font-size:large'>E-COOP</span>
                    </a>
               </div>

               <!-- Menu Toggle Button (sm-hover) -->
               <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
                    <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
               </button>

               <div class="scrollbar" data-simplebar>
                    <ul class="navbar-nav" id="navbar-nav">

                         <li class="menu-title">General</li>

                         <li class="nav-item">
                              <a class="nav-link" href="/dashboard">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Dashboard </span>
                              </a>
                         </li>

                         <li class="nav-item">
                              <a class="nav-link " href="/my-profile">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:user-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Profile </span>
                              </a>
                         </li>

                       



                         <li class="nav-item">
                              <a class="nav-link menu-arrow" href="#sidebarExtendedUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarExtendedUI">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Manage Users</span>
                              </a>
                              <div class="collapse" id="sidebarExtendedUI">
                                   <ul class="nav sub-navbar-nav">
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/user">Admins</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/member">Members</a>
                                        </li>

                                   </ul>
                              </div>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link menu-arrow" href="#sidebarExtendedAN" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarExtendedUI">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Manage Settings </span>
                              </a>
                              <div class="collapse" id="sidebarExtendedAN">
                                   <ul class="nav sub-navbar-nav">
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/plan">Plan / Rules</a>
                                        </li>
                                       

                                   </ul>
                              </div>
                         </li>



                         <li class="nav-item">
                              <a class="nav-link menu-arrow" href="#sidebarMapss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaps">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:streets-map-point-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Manage Loan</span>
                              </a>
                              <div class="collapse" id="sidebarMapss">
                                   <ul class="nav sub-navbar-nav">
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/application">Pending Loan Application</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/application/awaiting-disbursement">Awaiting Disbursement </a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/application/ongoing">Ongoing Loan Application</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/application/completed">Completed Loan Application</a>
                                        </li>
                                        {{--  <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/all">All</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/form">Form</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/repayment">Repayment</a>
                                        </li>  --}}
                                   </ul>
                              </div>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link menu-arrow" href="#sidebarMaps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaps">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:streets-map-point-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Manage Transactions </span>
                              </a>
                              <div class="collapse" id="sidebarMaps">
                                   <ul class="nav sub-navbar-nav">
                                        {{--  <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/application">Loan Applications</a>
                                        </li>  --}}
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/registration">Registration</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/monthly_dues">Savings</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/all">All</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/form">Form</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/admin/transaction/repayment">Repayment</a>
                                        </li>
                                   </ul>
                              </div>
                         </li>



                         <li class="menu-title mt-2">Support</li>

                         <li class="nav-item">
                              <a class="nav-link" href="https://wa.me/2349058744473">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:help-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Help Center </span>
                              </a>
                         </li>

                         <li class="nav-item">
                              <a class="nav-link" href="#">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:question-circle-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> FAQs </span>
                              </a>
                         </li>



                         <li class="nav-item">
                              <a class="nav-link" href="/logout" onclick="return confirm('Are you sure you want to sign out?')">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:user-block-rounded-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Logout </span>
                              </a>
                         </li>
                    </ul>
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
                                   </script> &copy; E-Cooperative. 
                                   <!-- A product of <a
                                        href="https://cthostel.com" class="text-green" target="_blank">CTHostel</a> -->
                                        <!-- href="https://cthostel.com" class="fw-bold footer-text" target="_blank">CTHostel</a> -->
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
     <script src="{{url('vendorsdashboard/js/vendor.js')}}"></script>

     <!-- App Javascript (Require in all Page) -->
     <script src="{{url('vendorsdashboard/js/app.js')}}"></script>

     <!-- Vector Map Js -->
     <script src="{{url('vendorsdashboard/vendor/jsvectormap/js/jsvectormap.min.js')}}"></script>
     <script src="{{url('vendorsdashboard/vendor/jsvectormap/maps/world-merc.js')}}"></script>
     <script src="{{url('vendorsdashboard/vendor/jsvectormap/maps/world.js')}}"></script>

     <!-- Dashboard Js -->
     <script src="{{url('vendorsdashboard/js/pages/dashboard.js')}}"></script>
     <script src="{{url('cdn/sweetalert.min.js')}}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     <script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>
     <script src="{{ asset('js\requestController.js') }}"></script>
     <script src="{{ asset('js\formController.js') }}"></script>
     <script src="{{ url('api_user/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
     <script src="{{ url('api_user/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
     <script src="{{ url('api_user/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
     <script src="{{ url('api_user/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>


     <script src="{{ url('api_user/assets/js/pages/datatables.init.js')}}"></script>

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