<ul class="navbar-nav" id="navbar-nav">
    <li class="menu-title">General</li>

    <li class="nav-item">
         <a class="nav-link" href="/dashboard">
              <span class="nav-icon">
                   <iconify-icon icon="solar:chart-2-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> Dashboard </span>
         </a>
    </li>

    <li class="nav-item">
         <a class="nav-link" href="/my-profile">
              <span class="nav-icon">
                   <iconify-icon icon="solar:user-id-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> Profile </span>
         </a>
    </li>

    <li class="nav-item">
         <a class="nav-link" href="/admin/member/pending" role="button" aria-expanded="false">
              <span class="nav-icon">
                   <iconify-icon icon="solar:users-group-rounded-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text">Pending Members </span>
         </a>
    </li>
    <li class="nav-item">
         <a class="nav-link" href="/admin/member" role="button" aria-expanded="false">
              <span class="nav-icon">
                   <iconify-icon icon="solar:users-group-rounded-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> Members </span>
         </a>
    </li>

    <li class="nav-item">
         <a class="nav-link" href="/admin/plan" role="button">
              <span class="nav-icon">
                   <iconify-icon icon="solar:tuning-square-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> Settings </span>
         </a>
    </li>

    <li class="nav-item">
         <a class="nav-link menu-arrow" href="#sidebarMapss" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaps">
              <span class="nav-icon">
                   <iconify-icon icon="solar:hand-money-bold-duotone"></iconify-icon>
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
              </ul>
         </div>
    </li>

    <li class="nav-item">
         <a class="nav-link menu-arrow" href="#sidebarMaps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMaps">
              <span class="nav-icon">
                   <iconify-icon icon="solar:card-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> Manage Transactions </span>
         </a>
         <div class="collapse" id="sidebarMaps">
              <ul class="nav sub-navbar-nav">
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
                   <iconify-icon icon="solar:chat-round-dots-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> Help Center </span>
         </a>
    </li>

    <li class="nav-item">
         <a class="nav-link" href="#">
              <span class="nav-icon">
                   <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> FAQs </span>
         </a>
    </li>

    <li class="nav-item">
         <a class="nav-link" href="/logout" onclick="return confirm('Are you sure you want to sign out?')">
              <span class="nav-icon">
                   <iconify-icon icon="solar:logout-2-bold-duotone"></iconify-icon>
              </span>
              <span class="nav-text"> Logout </span>
         </a>
    </li>
</ul>