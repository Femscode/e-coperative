@extends('cooperative.admin.master')
@section('header')
<style>
     .referral-code-container {
          position: relative;
          background: #f8f9fa;
          border-radius: 8px;
          padding: 15px;
          margin: 15px 0;
          border: 1px solid #e9ecef;
     }

     .referral-code-container h3 {
          font-size: 14px;
          margin: 0;
          color: #094168;
          word-break: break-all;
     }

     .copy-icon2 {
          position: absolute;
          right: 15px;
          top: 50%;
          transform: translateY(-50%);
          cursor: pointer;
          color: #094168;
          font-size: 18px;
          transition: all 0.3s ease;
     }

     .copy-icon2:hover {
          color: #073553;
     }

     .ref-code {
          font-weight: normal;
          color: #6c757d;
     }
</style>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container-fluid">

     <!-- Start here.... -->
     <div class="row">
          <div class="col-xxl-12">

               <h4>Hi, {{ $user->name }}</h4>
               <div class="row">

                    <div class='col-md-12'>
                         <div class="row">
                              <div class="col">
                                   <div class="row g-4">
                                        <div class="col-lg-4">
                                             <div class="card border-0 shadow-sm h-100">
                                                  <div class="card-body">
                                                       <div class="d-flex align-items-center mb-3">
                                                            <div class="flex-shrink-0">
                                                                 <div class="avatar-sm">
                                                                      <div class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                           <i class="bx bx-wallet-alt fs-4"></i>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                 <h5 class="card-title mb-0">Total Revenue</h5>
                                                            </div>
                                                            <button class="btn btn-ghost-primary btn-icon" id="toggle-amount">
                                                                 <i class="ti ti-eye fs-20"></i>
                                                            </button>
                                                       </div>
                                                       <h2 class="mb-3 fw-semibold" id="amount-display">₦{{ number_format($all_transactions,2) }}</h2>
                                                       <a href='/admin/all-transactions' class="btn btn-sm btn-primary">View Transactions</a>
                                                  </div>
                                             </div>
                                        </div>

                                        <div class="col-lg-8">
                                             <div class="card border-0 shadow-sm h-100">
                                                  <div class="card-body">
                                                       <div class="d-flex align-items-center justify-content-between mb-4">
                                                            <div>
                                                                 <h5 class="card-title mb-1">Share your Synco Link</h5>
                                                                 <p class="text-muted small mb-0">Share this link with your members to join the group</p>
                                                            </div>
                                                       </div>

                                                       <div class="referral-code-container bg-light rounded-3 p-3 mb-4">
                                                            <div class="d-flex align-items-center">
                                                                 <div class="flex-grow-1">
                                                                      <span class="text-muted small">Your unique invite link</span>
                                                                      <div class="d-flex align-items-center gap-2">
                                                                           <h6 class="mb-0 text-truncate" id="referral-link">https://syncosave.com/signup/{{ $plan->slug }}</h6>
                                                                      </div>
                                                                 </div>
                                                                 <button class="btn btn-soft-primary btn-icon" onclick="copyRefLink()">
                                                                      <i class="ti ti-copy fs-16"></i>
                                                                 </button>
                                                            </div>
                                                       </div>

                                                       <div class="d-flex align-items-center justify-content-between">
                                                            <span class="text-muted small">Share via</span>
                                                            <ul class="list-inline mb-0 d-flex gap-2">
                                                                 <li class="list-inline-item">
                                                                      <a href="https://www.facebook.com/sharer/sharer.php?u=https://syncosave.com/{{ $plan->slug }}"
                                                                           target="_blank"
                                                                           class="btn btn-icon btn-soft-primary btn-sm">
                                                                           <i class="bx bxl-facebook"></i>
                                                                      </a>
                                                                 </li>
                                                                 <li class="list-inline-item">
                                                                      <a href="https://api.whatsapp.com/send?text=Join our Synco group: https://syncosave.com/{{ $plan->slug }}"
                                                                           target="_blank"
                                                                           class="btn btn-icon btn-soft-success btn-sm">
                                                                           <i class="bx bxl-whatsapp"></i>
                                                                      </a>
                                                                 </li>
                                                                 <li class="list-inline-item">
                                                                      <a href="https://twitter.com/intent/tweet?url=https://syncosave.com/{{ $plan->slug }}"
                                                                           target="_blank"
                                                                           class="btn btn-icon btn-soft-info btn-sm">
                                                                           <i class="bx bxl-twitter"></i>
                                                                      </a>
                                                                 </li>
                                                                 <li class="list-inline-item">
                                                                      <a href="mailto:?subject=Join Our Synco Group&body=https://syncosave.com/{{ $plan->slug }}"
                                                                           class="btn btn-icon btn-soft-warning btn-sm">
                                                                           <i class="bx bx-envelope"></i>
                                                                      </a>
                                                                 </li>
                                                            </ul>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div>
                                   </div> <!-- end card -->
                              </div> <!-- end col -->
                              <!-- end col -->
                         </div>



                         <div class="row mt-4 mb-4">
                              <div class="col-md-6 mb-2">
                                   <div class="card h-100">
                                        <div class="card-body">
                                             <div class="d-flex align-items-center mb-3">
                                                  <div class="flex-shrink-0">
                                                       <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-primary text-primary rounded">
                                                                 <iconify-icon icon="solar:inbox-line-broken" class="fs-24"></iconify-icon>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="flex-grow-1 ms-3">
                                                       <h5 class="card-title mb-0">Create New Group</h5>
                                                  </div>
                                             </div>
                                             <p class="text-muted mb-4">Create and manage new contribution groups for your members</p>
                                             <a href="/admin/group" class="btn btn-primary">Create Group</a>
                                        </div>
                                   </div>
                              </div>

                              <div class="col-md-6">
                                   <div class="card h-100">
                                        <div class="card-body">
                                             <div class="d-flex align-items-center mb-3">
                                                  <div class="flex-shrink-0">
                                                       <div class="avatar-sm">
                                                            <div class="avatar-title bg-soft-success text-success rounded">
                                                                 <iconify-icon icon="solar:clipboard-check-broken" class="fs-24"></iconify-icon>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="flex-grow-1 ms-3">
                                                       <h5 class="card-title mb-0">My Dues</h5>
                                                  </div>
                                             </div>
                                             <p class="text-muted mb-4">View and manage your contribution dues and payments</p>
                                             <a href="/admin/group/contribution-dues" class="btn btn-success">View Dues</a>
                                        </div>
                                   </div>
                              </div>
                         </div>


                    </div>


               </div>


          </div> <!-- end col -->


     </div>


</div>
@endsection

@section('script')
<script>
     function copyRefLink() {
          const linkText = document.getElementById('referral-link').textContent;
          
          // Create a temporary textarea element to copy the text
          const textarea = document.createElement('textarea');
          textarea.value = linkText;
          document.body.appendChild(textarea);
          textarea.select();
          
          try {
               document.execCommand('copy');
               const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                         toast.addEventListener('mouseenter', Swal.stopTimer)
                         toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
               });
               Toast.fire({
                    icon: 'success',
                    title: 'Link copied to clipboard'
               });
          } catch (err) {
               console.error('Failed to copy text: ', err);
          } finally {
               document.body.removeChild(textarea);
          }
     }
</script>
<script>
     document.addEventListener('DOMContentLoaded', function() {
          const toggleBtn = document.getElementById('toggle-amount');
          const amountDisplay = document.getElementById('amount-display');
          const originalAmount = amountDisplay.textContent;
          let isHidden = true; // Changed to true for default hidden state

          // Hide amount immediately when page loads
          amountDisplay.textContent = '₦*****';
          toggleBtn.innerHTML = '<i class="ti ti-eye-off fs-20"></i>';

          toggleBtn.addEventListener('click', function() {
               if (isHidden) {
                    amountDisplay.textContent = originalAmount;
                    toggleBtn.innerHTML = '<i class="ti ti-eye fs-20"></i>';
               } else {
                    amountDisplay.textContent = '₦*****';
                    toggleBtn.innerHTML = '<i class="ti ti-eye-off fs-20"></i>';
               }
               isHidden = !isHidden;
          });
     });
</script>


@endsection