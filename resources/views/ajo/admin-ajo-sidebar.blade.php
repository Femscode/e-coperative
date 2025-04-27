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
          <a class="nav-link " href="/my-profile">
               <span class="nav-icon">
                    <iconify-icon icon="solar:user-id-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text"> Profile </span>
          </a>
     </li>
     <li class="nav-item">
          <a class="nav-link " href="/admin/group">
               <span class="nav-icon">
                    <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text"> Contribution Group(s) </span>
          </a>
     </li>
     <li class="nav-item">
          <a class="nav-link " href="/admin/group/contribution-dues">
               <span class="nav-icon">
                    <iconify-icon icon="solar:wallet-money-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text"> My Dues </span>
          </a>
     </li>

     <li class="nav-item">
          <a class="nav-link menu-link collapsed" data-bs-toggle="collapse" href="#transactionsCollapse" role="button" aria-expanded="false">
               <span class="nav-icon">
                    <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
               </span>
               <span class="nav-text">Transactions</span>
               <span class="nav-arrow">
                    <iconify-icon icon="solar:alt-arrow-right-bold-duotone"></iconify-icon>
               </span>
          </a>
          <div class="collapse" id="transactionsCollapse">
               <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                         <a href="/admin/all-transactions" class="nav-link">

                              <span class="nav-text">All Transactions</span>
                         </a>
                    </li>
                    <li class="nav-item">
                         <a href="/admin/my-transactions" class="nav-link">
                             
                              <span class="nav-text">My Transactions</span>
                         </a>
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