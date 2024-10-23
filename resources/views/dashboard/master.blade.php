<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from techzaa.getappui.com/larkon/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Sep 2024 15:15:07 GMT -->

<head>
     <!-- Title Meta -->
     <meta charset="utf-8" />
     <title>CTTaste | Vendor's Dashboard</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta name="description" content="No. Ordering Platform" />
     <meta name="author" content="Techzaa" />
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />

     <!-- App favicon -->

     <meta name="csrf-token" content="{{ csrf_token() }}">

     <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
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

                              <!-- Notification -->
                              <div class="dropdown topbar-item">
                                   <button type="button" class="topbar-button position-relative" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <iconify-icon icon="solar:bell-bing-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                                        <span class="position-absolute topbar-badge fs-10 translate-middle badge bg-danger rounded-pill">1<span class="visually-hidden">unread messages</span></span>
                                   </button>
                                   <div class="dropdown-menu py-0 dropdown-lg dropdown-menu-end" aria-labelledby="page-header-notifications-dropdown">
                                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                             <div class="row align-items-center">
                                                  <div class="col">
                                                       <h6 class="m-0 fs-16 fw-semibold"> Notifications</h6>
                                                  </div>
                                                  <div class="col-auto">
                                                       <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                                                            <small>Clear All</small>
                                                       </a>
                                                  </div>
                                             </div>
                                        </div>
                                        <div data-simplebar style="max-height: 280px;">

                                             <!-- Item -->
                                             <a href="javascript:void(0);" class="dropdown-item py-3 border-bottom">
                                                  <div class="d-flex">
                                                       <div class="flex-shrink-0">
                                                            <div class="avatar-sm me-2">
                                                                 <span class="avatar-title bg-soft-info text-info fs-20 rounded-circle">
                                                                      P
                                                                 </span>
                                                            </div>
                                                       </div>
                                                       <div class="flex-grow-1">
                                                            <p class="mb-0 fw-semibold">Promote Your Brand Today!</p>
                                                            <p class="mb-0 text-wrap">
                                                                 With a token of NGN5,000 for a week.
                                                            </p>
                                                       </div>
                                                  </div>
                                             </a>



                                        </div>
                                        <div class="text-center py-3">
                                             <a href="javascript:void(0);" class="btn btn-primary btn-sm">View All Notification <i class="bx bx-right-arrow-alt ms-1"></i></a>
                                        </div>
                                   </div>
                              </div>



                              <!-- Activity -->
                              <div class="topbar-item d-none d-md-flex">
                                   <a type="button" class="topbar-button" id="theme-settings-btn" href='/working_hours' aria-controls="theme-settings-offcanvas">
                                        <iconify-icon icon="solar:clock-circle-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                                   </a>
                              </div>

                              <!-- User -->
                              <div class="dropdown topbar-item">
                                   <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-flex align-items-center">
                                             @if($user->image !== null)
                                             <img src="{{ config('app.env') === 'local' ? url('profilePic/' . $user->image) : 'https://cttaste.com/cttaste_files/public/profilePic/' . $user->image }}"
                                                  alt="" class="rounded-circle" width="32">
                                             @else
                                             <img src="https://dnasoundstudio.com/producers/assets/images/music-dashboard/feature-album/05.png"
                                                  alt="" class="rounded-circle" width="32">
                                             @endif
                                        </span>
                                   </a>
                                   <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <h6 class="dropdown-header">Welcome {{$user->name}}!</h6>
                                        <a class="dropdown-item" href="/profile">
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
                              <form class="app-search d-none d-md-block ms-2">
                                   <div class="position-relative">
                                        <input type="search" class="form-control" placeholder="Search..." autocomplete="off" value="">
                                        <iconify-icon icon="solar:magnifer-linear" class="search-widget-icon"></iconify-icon>
                                   </div>
                              </form>
                         </div>
                    </div>
               </div>
          </header>



          <!-- ========== App Menu Start ========== -->
          <div class="main-nav">
               <!-- Sidebar Logo -->
               <div class="logo-box">
                    <a href="/dashboard" class="logo-dark">

                    <img src="{{url('assets/images/logo-wh.png')}}" alt="" height="30">
                    </a>

                    <a href="/dashboard" class="logo-light">
                    <img src="{{url('assets/images/logo-wh.png')}}" alt="" height="30">
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
                              <a class="nav-link " href="/profile">
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
                                             <a class="sub-nav-link" href="/today_orders">Today Orders</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/orders">All Orders</a>
                                        </li>

                                   </ul>
                              </div>
                         </li>
                         <li class="nav-item">
                              <a class="nav-link menu-arrow" href="#sidebarExtendedAN" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarExtendedUI">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Analysis </span>
                              </a>
                              <div class="collapse" id="sidebarExtendedAN">
                                   <ul class="nav sub-navbar-nav">
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/order_analysis">Order Analysis</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/sales_analysis">Sales Analysis</a>
                                        </li>

                                   </ul>
                              </div>
                         </li>


                         <li class="nav-item">
                              <a class="nav-link " href="/working_hours">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:box-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Working Hours </span>
                              </a>

                         </li>






                         <li class="nav-item">
                              <a class="nav-link " href="/brand_promotion">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:chart-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Brand Promotion </span>
                              </a>

                         </li>

                         <!-- <li class="nav-item">
                              <a class="nav-link " href="/mywrap" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAttributes">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:confetti-minimalistic-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> My Wrap </span>
                              </a>

                         </li> -->

                         <li class="nav-item">
                              <a class="nav-link " href="/transactions">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Transactions </span>
                              </a>

                         </li>



                         <li class="nav-item">
                              <a class="nav-link" href="/checkreviews">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:chat-square-like-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Reviews </span>
                              </a>
                         </li>


                         <li class="nav-item">
                              <a class="nav-link " href="/myevent">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:gift-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Catering Events </span>
                              </a>

                         </li>




                         <li class="nav-item">
                              <a class="nav-link menu-arrow" href="#sidebarMaps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaps">
                                   <span class="nav-icon">
                                        <iconify-icon icon="solar:streets-map-point-bold-duotone"></iconify-icon>
                                   </span>
                                   <span class="nav-text"> Delivery </span>
                              </a>
                              <div class="collapse" id="sidebarMaps">
                                   <ul class="nav sub-navbar-nav">
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/delivery_locations">Delivery Locations</a>
                                        </li>
                                        <li class="sub-nav-item">
                                             <a class="sub-nav-link" href="/delivery_tracking">Delivery Tracking</a>
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
                                   </script> &copy; CTTaste. A product of <a
                                        href="https://cthostel.com" class="text-green" target="_blank">CTHostel</a>
                                        <!-- href="https://cthostel.com" class="fw-bold footer-text" target="_blank">CTHostel</a> -->
                              </div>
                         </div>
                    </div>
               </footer>
               <!-- ========== Footer End ========== -->

          </div>


     </div>
     <!-- END Wrapper -->

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
     <script src="{{ url('api_user/assets/libs/jquery/jquery.min.js')}}"></script>

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