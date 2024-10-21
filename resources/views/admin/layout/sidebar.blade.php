<ul class="navbar-nav" id="navbar-nav">
    <li class="menu-title"><span data-key="t-menu">Menu</span></li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('admin-home') ? 'active' : '' }}" href="/admin" role="button"
            aria-expanded="false" aria-controls="sidebarDashboards">
            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link menu-link {{ Route::is('user_home','admin_member_home') ? 'active' : '' }}" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
        @if(Route::is('user_home','admin_member_home')) aria-expanded='true' @else aria-expanded='false' @endif aria-controls="sidebarDashboards">
            <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Manage Users</span>
        </a>
        <div class="collapse menu-dropdown {{ Route::is('user_home','admin_member_home') ? 'show' : '' }}" id="sidebarDashboards">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{route('user_home')}}" class="nav-link {{ Route::is('user_home') ? 'active' : '' }}" data-key="t-analytics"> Users </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin_member_home')}}" class="nav-link {{ Route::is('admin_member_home') ? 'active' : '' }}" data-key="t-members"> Members </a>
                </li>

            </ul>
        </div>
    </li> <!-- end Dashboard Menu -->
    <li class="nav-item">
        <a class="nav-link menu-link {{ Route::is('admin.plan') ? 'active' : '' }}" href="#sidebarApps" data-bs-toggle="collapse"
            role="button" @if(Route::is('admin.plan')) aria-expanded='true' @else aria-expanded='false' @endif aria-controls="sidebarApps">
            <i class="ri-apps-2-line"></i> <span data-key="t-apps">Manage Settings</span>
        </a>
        <div class="collapse menu-dropdown {{ Route::is('admin.plan') ? 'show' : '' }}" id="sidebarApps">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item ">
                    <a href="{{route('admin.plan')}}" class="nav-link {{ Route::is('admin.plan') ? 'active' : '' }}" data-key="t-calendar"> Plan </a>
                </li>

            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['admin.registration.transactions', 'admin.dues.transactions', 'admin.all.transactions','admin.form.transactions','admin.repayment.transactions']) ? 'active' : '' }}" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" @if(in_array(Route::currentRouteName(), ['admin.registration.transactions', 'admin.dues.transactions', 'admin.all.transactions','admin.form.transactions','admin.repayment.transactions'])) aria-expanded='true' @else aria-expanded='false' @endif aria-controls="sidebarLayouts">
            <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Manage Transactions</span>
        </a>
        <div class="collapse menu-dropdown {{ Route::is('admin.registration.transactions','admin.loan.applications', 'admin.dues.transactions', 'admin.all.transactions','admin.form.transactions','admin.repayment.transactions') ? 'show' : '' }}" id="sidebarLayouts">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.loan.applications') }}" class="nav-link {{ Route::is('admin.loan.applications') ? 'active' : '' }}" data-key="t-horizontal">Loan Application</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.registration.transactions') }}" class="nav-link {{ Route::is('admin.registration.transactions') ? 'active' : '' }}" data-key="t-horizontal">Registration</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dues.transactions')  }}" class="nav-link {{ Route::is('admin.dues.transactions') ? 'active' : '' }}" data-key="t-detached">Monthly Dues</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.all.transactions')  }}" class="nav-link {{ Route::is('admin.all.transactions') ? 'active' : '' }}" data-key="t-two-column">All</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.form.transactions')  }}" class="nav-link {{ Route::is('admin.form.transactions') ? 'active' : '' }}" data-key="t-hovered">Form</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.repayment.transactions')  }}" class="nav-link {{ Route::is('admin.repayment.transactions') ? 'active' : '' }}" data-key="t-hovered">Repayment</a>
                </li>
            </ul>
        </div>
    </li>

</ul>
