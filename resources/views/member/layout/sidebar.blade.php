<ul class="navbar-nav" id="navbar-nav">
    <li class="menu-title"><span data-key="t-menu">Menu</span></li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('member_home') ? 'active' : '' }}" href="/member" role="button"
            aria-expanded="false" aria-controls="sidebarDashboards">
            <i class="ri-apps-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link menu-link {{ Route::is('loan.home','loan.ongoing','loan.completed') ? 'active' : '' }}" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
        @if(Route::is('loan.home','loan.ongoing','loan.completed')) aria-expanded='true' @else aria-expanded='false' @endif aria-controls="sidebarDashboards">
            <i class="ri-layout-3-line"></i> <span data-key="t-apps">Loan Applications</span>
        </a>
        <div class="collapse menu-dropdown {{ Route::is('loan.home','loan.ongoing','loan.completed') ? 'show' : '' }}" id="sidebarDashboards">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{route('loan.home')}}" class="nav-link {{ Route::is('loan.home') ? 'active' : '' }}" data-key="t-analytics">Pending Applications </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('loan.ongoing')}}" class="nav-link {{ Route::is('loan.ongoing') ? 'active' : '' }}" data-key="t-members">Ongoing Applications</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('loan.completed')}}" class="nav-link {{ Route::is('loan.completed') ? 'active' : '' }}" data-key="t-memberx">Completed Applications</a>
                </li>

            </ul>
        </div>
    </li> <!-- end Dashboard Menu -->
    {{-- <li class="nav-item">
        <a class="nav-link " href="{{ route('member-automatic-payment') }}" role="button"
            aria-expanded="false" aria-controls="sidebarLayouts">
            <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Automatic Payment</span>
        </a>
    </li> <!-- end Dashboard Menu --> --}}

    <li class="nav-item">
        <a class="nav-link {{ Route::is('member-manual-payment') ? 'active' : '' }}" href="{{ route('member-manual-payment') }}" role="button"
            aria-expanded="false" aria-controls="sidebarAuth">
            <i class="ri-dashboard-2-line"></i> <span data-key="t-authentication">Pay Dues</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('member-loan-payment') ? 'active' : '' }}" href="{{ route('member-loan-payment') }}" role="button"
            aria-expanded="false" aria-controls="sidebarAuth">
            <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Loan Repayment</span>
        </a>
    </li>
    

</ul>
