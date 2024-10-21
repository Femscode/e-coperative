<ul class="navbar-nav" id="navbar-nav">
    <li class="menu-title"><span data-key="t-menu">Menu</span></li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('member_home') ? 'active' : '' }}" href="/member" role="button"
            aria-expanded="false" aria-controls="sidebarDashboards">
            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('loan.home') ? 'active' : '' }}" href="{{ route('loan.home') }}" role="button"
            aria-expanded="false" aria-controls="sidebarApps">
            <i class="ri-apps-2-line"></i> <span data-key="t-apps">Loan Applications</span>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link " href="{{ route('member-automatic-payment') }}" role="button"
            aria-expanded="false" aria-controls="sidebarLayouts">
            <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Automatic Payment</span>
        </a>
    </li> <!-- end Dashboard Menu --> --}}

    <li class="nav-item">
        <a class="nav-link {{ Route::is('member-manual-payment') ? 'active' : '' }}" href="{{ route('member-manual-payment') }}" role="button"
            aria-expanded="false" aria-controls="sidebarAuth">
            <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Pay Dues</span>
        </a>
    </li>

</ul>
