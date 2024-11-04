<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">


<head>
        
        <meta charset="utf-8" />
        <title>1 Milion Hands - Member </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/cooplogo.png')}}">

        <!-- Layout config Js -->
        <script src="assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
        @yield('links')

    </head>

    <body>

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="layout-width">
                    <div class="navbar-header">
                        <div class="d-flex">
                            <!-- LOGO -->
                            <div class="navbar-brand-box horizontal-logo">
                                <a href="/member" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="{{ asset('website/images/logo4.png')}}" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ asset('website/images/logo4.png')}}" alt="" height="17">
                                    </span>
                                </a>
            
                                <a href="/member" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="{{ asset('website/images/logo4.png')}}" alt="" height="22">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ asset('website/images/logo4.png')}}" alt="" height="17">
                                    </span>
                                </a>
                            </div>
            
                            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                                <span class="hamburger-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                            </button>
            
                            <!-- App Search-->
                            <form class="app-search d-none d-md-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                                        id="search-options" value="">
                                    <span class="mdi mdi-magnify search-widget-icon"></span>
                                    <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                                        id="search-close-options"></span>
                                </div>
                                <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                                    <div data-simplebar style="max-height: 320px;">
                                        <!-- item-->
                                        <div class="dropdown-header">
                                            <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                                        </div>
            
                                        <div class="dropdown-item bg-transparent text-wrap">
                                            <a href="/member" class="btn btn-soft-secondary btn-sm btn-rounded">how to setup <i
                                                    class="mdi mdi-magnify ms-1"></i></a>
                                            <a href="/member" class="btn btn-soft-secondary btn-sm btn-rounded">buttons <i
                                                    class="mdi mdi-magnify ms-1"></i></a>
                                        </div>
                                        <!-- item-->
                                        <div class="dropdown-header mt-2">
                                            <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                                        </div>
            
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                            <span>Analytics Dashboard</span>
                                        </a>
            
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                            <span>Help Center</span>
                                        </a>
            
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                            <span>My account settings</span>
                                        </a>
            
                                        <!-- item-->
                                        <div class="dropdown-header mt-2">
                                            <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                                        </div>
            
                                        <div class="notification-list">
                                            <!-- item -->
                                            <a href="javascript:void(0);" class="d-flex dropdown-item notify-item py-2">
                                                <img src="{{asset('assets/images/users/avatar-2.jpg')}}" class="me-3 rounded-circle avatar-xs"
                                                    alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="m-0">Angela Bernier</h6>
                                                    <span class="fs-11 mb-0 text-muted">Manager</span>
                                                </div>
                                            </a>
                                            <!-- item -->
                                            <a href="javascript:void(0);" class="d-flex dropdown-item notify-item py-2">
                                                <img src="{{asset('assets/images/users/avatar-3.jpg')}}" class="me-3 rounded-circle avatar-xs"
                                                    alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="m-0">David Grasso</h6>
                                                    <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                                </div>
                                            </a>
                                            <!-- item -->
                                            <a href="javascript:void(0);" class="d-flex dropdown-item notify-item py-2">
                                                <img src="{{asset('assets/images/users/avatar-5.jpg')}}" class="me-3 rounded-circle avatar-xs"
                                                    alt="user-pic">
                                                <div class="flex-1">
                                                    <h6 class="m-0">Mike Bunch</h6>
                                                    <span class="fs-11 mb-0 text-muted">React Developer</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
            
                                    <div class="text-center pt-3 pb-1">
                                        <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results <i
                                                class="ri-arrow-right-line ms-1"></i></a>
                                    </div>
                                </div>
                            </form>
                        </div>
            
                        <div class="d-flex align-items-center">
            
                            <div class="dropdown d-md-none topbar-head-dropdown header-item">
                                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                    id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="bx bx-search fs-22"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-search-dropdown">
                                    <form class="p-3">
                                        <div class="form-group m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search ..."
                                                    aria-label="Recipient's username">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
            
                            
            
                            <div class="dropdown topbar-head-dropdown ms-1 header-item">
                               
                            </div>
            
                            <div class="dropdown ms-sm-3 header-item topbar-user">
                                <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <span class="d-flex align-items-center">
                                        <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                            alt="Header Avatar">
                                        <span class="text-start ms-xl-2">
                                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::user()->name}}</span>
                                            <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{Auth::user()->coop_id}}</span>
                                        </span>
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <!-- item-->
                                   
                                    <a class="dropdown-item" href="/logout"><i
                                            class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                            class="align-middle" data-key="t-logout">Logout</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</header>
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="/member" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('website/images/logo4.png')}}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('website/images/logo4.png')}}" alt="" height="50">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="/member" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('website/images/logo4.png')}}" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('website/images/logo4.png')}}" alt="" height="50">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <div id="scrollbar">
                    <div class="container-fluid">
            
                        <div id="two-column-menu">
                        </div>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                            <li class="nav-item">
                                <a class="nav-link " href="/member" role="button"
                                    aria-expanded="false" aria-controls="sidebarDashboards">
                                    <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                                </a>
                            </li> 
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="sidebarApps">
                                    <i class="ri-apps-2-line"></i> <span data-key="t-apps">Apps</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarApps">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="apps-calendar.html" class="nav-link" data-key="t-calendar"> Calendar </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="apps-chat.html" class="nav-link" data-key="t-chat"> Chat </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="apps-mailbox.html" class="nav-link" data-key="t-mailbox"> Mailbox </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarEcommerce" class="nav-link" data-bs-toggle="collapse" role="button"
                                                aria-expanded="false" aria-controls="sidebarEcommerce" data-key="t-ecommerce"> Ecommerce
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarEcommerce">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-products.html" class="nav-link" data-key="t-products"> Products </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-product-details.html" class="nav-link" data-key="t-product-Details"> Product Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-add-product.html" class="nav-link" data-key="t-create-product"> Create Product </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-orders.html" class="nav-link" data-key="t-orders"> Orders </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-order-details.html" class="nav-link" data-key="t-order-details"> Order Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-customers.html" class="nav-link" data-key="t-customers"> Customers </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-cart.html" class="nav-link" data-key="t-shopping-cart"> Shopping Cart </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-checkout.html" class="nav-link" data-key="t-checkout"> Checkout </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-sellers.html" class="nav-link" data-key="t-sellers"> Sellers </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-ecommerce-seller-details.html" class="nav-link" data-key="t-sellers-details"> Seller Details </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarProjects" class="nav-link" data-bs-toggle="collapse" role="button"
                                                aria-expanded="false" aria-controls="sidebarProjects" data-key="t-projects"> Projects
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarProjects">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="apps-projects-list.html" class="nav-link" data-key="t-list"> List </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-projects-overview.html" class="nav-link" data-key="t-overview"> Overview </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-projects-create.html" class="nav-link" data-key="t-create-project"> Create Project </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarTasks" class="nav-link" data-bs-toggle="collapse" role="button"
                                                aria-expanded="false" aria-controls="sidebarTasks" data-key="t-tasks"> Tasks
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarTasks">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="apps-tasks-kanban.html" class="nav-link" data-key="t-kanbanboard"> Kanban Board </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-tasks-list-view.html" class="nav-link" data-key="t-list-view"> List View </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-tasks-details.html" class="nav-link" data-key="t-task-details"> Task Details </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarCRM" class="nav-link" data-bs-toggle="collapse" role="button"
                                                aria-expanded="false" aria-controls="sidebarCRM" data-key="t-crm"> CRM
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarCRM">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="apps-crm-contacts.html" class="nav-link" data-key="t-contacts"> Contacts </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crm-companies.html" class="nav-link" data-key="t-companies"> Companies </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crm-deals.html" class="nav-link" data-key="t-deals"> Deals </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crm-leads.html" class="nav-link" data-key="t-leads"> Leads </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarCrypto" class="nav-link" data-bs-toggle="collapse" role="button"
                                                aria-expanded="false" aria-controls="sidebarCrypto" data-key="t-crypto"> Crypto
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarCrypto">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="apps-crypto-transactions.html" class="nav-link" data-key="t-transactions"> Transactions </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crypto-buy-sell.html" class="nav-link" data-key="t-buy-sell"> Buy & Sell </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crypto-orders.html" class="nav-link" data-key="t-orders"> Orders </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crypto-wallet.html" class="nav-link" data-key="t-my-wallet"> My Wallet </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crypto-ico.html" class="nav-link" data-key="t-ico-list"> ICO List </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-crypto-kyc.html" class="nav-link" data-key="t-kyc-application"> KYC Application </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarInvoices" class="nav-link" data-bs-toggle="collapse" role="button"
                                                aria-expanded="false" aria-controls="sidebarInvoices" data-key="t-invoices"> Invoices
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarInvoices">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="apps-invoices-list.html" class="nav-link" data-key="t-list-view"> List View </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-invoices-details.html" class="nav-link" data-key="t-details"> Details </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-invoices-create.html" class="nav-link" data-key="t-create-invoice"> Create Invoice </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarTickets" class="nav-link" data-bs-toggle="collapse" role="button"
                                                aria-expanded="false" aria-controls="sidebarTickets" data-key="t-supprt-tickets"> Support Tickets
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarTickets">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="apps-tickets-list.html" class="nav-link" data-key="t-list-view"> List View </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="apps-tickets-details.html" class="nav-link" data-key="t-ticket-details"> Ticket Details </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('member-automatic-payment') }}" role="button"
                                    aria-expanded="false" aria-controls="sidebarLayouts">
                                    <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Automatic Payment</span>
                                </a>
                            </li> <!-- end Dashboard Menu -->

                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('member-manual-payment') }}" role="button"
                                    aria-expanded="false" aria-controls="sidebarAuth">
                                    <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Manual Payment</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    @yield('content')
                    <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> 
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    {{-- Design & Develop by Themesbrand --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        

        <div class="customizer-setting d-none d-md-block">
            <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
                data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
            </div>
        </div>

        

        <!-- JAVASCRIPT -->
        <script src="{{asset('assets/js/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
        <script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
        <script src="{{asset('assets/js/plugins.js')}}"></script>

        <!-- apexcharts -->
        <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- projects js -->
        <script src="{{asset('assets/js/pages/dashboard-projects.init.js')}}"></script>
        <script src="{{asset('assets/libs/list.js/list.min.js')}}"></script>
        <script src="{{asset('assets/libs/list.pagination.js/list.pagination.min.js')}}"></script>
        <script src="{{asset('assets/js/pages/listjs.init.js')}}"></script>
        <script src="{{ asset('js\requestController.js') }}"></script>
        <script src="{{ asset('js\formController.js') }}"></script>
        <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js') }}"></script>

        <!-- App js -->
        <script src="{{asset('assets/js/app.js')}}"></script>

        @yield('script')
    </body>


</html>