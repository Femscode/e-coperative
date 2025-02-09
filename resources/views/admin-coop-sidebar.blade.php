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