@extends('cooperative.admin.master')
@section('header')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container-fluid">

     <!-- Start here.... -->
     <div class="row">
          <div class="col-xxl-12">

               <h4>Hi, {{ $user->name }}</h4>
               <div class="row">

                    <div class='col-md-8'>
                         <div class="row">
                              <div class="col">
                                   <div class="card">
                                        <div class="card-body overflow-hidden position-relative">

                                             <div class="d-flex align-items-center gap-2">
                                                  <h1 class="mb-0 fw-bold mt-3 mb-1" id="amount-display">₦{{ number_format($transactions->sum('balance'),2) }}</h1>
                                                  <button class="btn btn-link text-muted p-0 mt-3" id="toggle-amount">
                                                       <i class="ti ti-eye fs-20"></i>
                                                  </button>
                                             </div>
                                             <a href='/admin/transaction/all' class="text-muted">Total Revenue</a>
                                             <i class="bx bx-building-house widget-icon"></i>
                                        </div> <!-- end card-body -->
                                   </div> <!-- end card -->
                              </div> <!-- end col -->
                              <!-- end col -->
                         </div>



                         <div class="row mt-4 mb-4">

                              <div class="col-12">
                                   <div class="d-flex justify-content-center gap-4">

                                        <a href="/admin/transaction/repayment" class="text-decoration-none">
                                             <div class="circle-box text-center">
                                                  <div class="circle-icon">
                                                       <iconify-icon icon="solar:clock-circle-broken" class="fs-32"></iconify-icon>
                                                  </div>
                                                  <h6 class="mt-2 mb-0">Repayments</h6>
                                             </div>
                                        </a>

                                        <a href="/admin/member" class="text-decoration-none">
                                             <div class="circle-box text-center">
                                                  <div class="circle-icon">
                                                       <iconify-icon icon="solar:inbox-line-broken" class="fs-32"></iconify-icon>

                                                  </div>
                                                  <h6 class="mt-2 mb-0">Members</h6>
                                             </div>
                                        </a>

                                        <a href="/admin/transaction/monthly_dues" class="text-decoration-none">
                                             <div class="circle-box text-center">
                                                  <div class="circle-icon">
                                                       <iconify-icon icon="solar:clipboard-check-broken" class="fs-32"></iconify-icon>
                                                  </div>
                                                  <h6 class="mt-2 mb-0">Member Dues</h6>
                                             </div>
                                        </a>

                                        <a href="/admin/plan" class="text-decoration-none">
                                             <div class="circle-box text-center">
                                                  <div class="circle-icon">
                                                       <iconify-icon icon="solar:settings-bold" class="fs-32"></iconify-icon>
                                                  </div>
                                                  <h6 class="mt-2 mb-0">Settings</h6>
                                             </div>
                                        </a>
                                   </div>
                              </div>

                         </div>


                    </div>
                    <div class='col-md-4'>

                         <div class="col">
                              <div class="card">
                                   <div class="card-body text-center">
                                        <h4 class="card-title mb-2">Share your Synco Link</h4>
                                        <ul class="list-inline d-flex gap-1 my-3 align-items-center justify-content-center">
                                             <li class="list-inline-item">
                                                  <a href="https://www.facebook.com/sharer/sharer.php?u=https://syncosave.com/{{ $plan->slug }}&quote=Dear members, kindly join our synco group via this link"
                                                       target="_blank"
                                                       class="btn btn-soft-primary avatar-sm d-flex align-items-center justify-content-center fs-20">
                                                       <i class="bx bxl-facebook"></i>
                                                  </a>
                                             </li>

                                             <li class="list-inline-item">
                                                  <a href="https://www.instagram.com/share?url=https://syncosave.com/{{ $plan->slug }}"
                                                       target="_blank"
                                                       class="btn btn-soft-danger avatar-sm d-flex align-items-center justify-content-center fs-20">
                                                       <i class="bx bxl-instagram"></i>
                                                  </a>
                                             </li>

                                             <li class="list-inline-item">
                                                  <a href="https://twitter.com/intent/tweet?url=https://syncosave.com/{{ $plan->slug }}&text=Dear members, kindly join our synco group via this link"
                                                       target="_blank"
                                                       class="btn btn-soft-info avatar-sm d-flex align-items-center justify-content-center fs-20">
                                                       <i class="bx bxl-twitter"></i>
                                                  </a>
                                             </li>

                                             <li class="list-inline-item">
                                                  <a href="https://api.whatsapp.com/send?text=Dear members, kindly join our synco group via this link: https://syncosave.com/{{ $plan->slug }}"
                                                       target="_blank"
                                                       class="btn btn-soft-success avatar-sm d-flex align-items-center justify-content-center fs-20">
                                                       <i class="bx bxl-whatsapp"></i>
                                                  </a>
                                             </li>

                                             <li class="list-inline-item">
                                                  <a href="mailto:?subject=Join Our Synco Group&body=Dear members, kindly join our synco group via this link: https://syncosave.com/{{ $plan->slug }}"
                                                       class="btn btn-soft-warning avatar-sm d-flex align-items-center justify-content-center fs-20">
                                                       <i class="bx bx-envelope"></i>
                                                  </a>
                                             </li>
                                        </ul>
                                        <p class="text-muted">Copy the URL below and share it with your members:</p>
                                        <p class="d-flex align-items-center border p-2 rounded-2 border-dashed bg-body text-start mb-0" id="cttaste-link">
                                             https://syncosave.com/{{ $plan->slug }}<a href="#!" class="ms-auto fs-4"><i class="copy-link ti ti-copy"></i></a>
                                        </p>
                                   </div>
                              </div>
                         </div>

                    </div>

               </div>

               




               <div class='row'>
                    <div class='col-md-12'>

                         <div class="card">
                              <div class="card-body">

                                   <div class="row">
                                        <div class="col-xl-12">
                                             <div class="card">
                                                  <div class="card-header d-flex align-items-center">
                                                       <h4 class="card-title flex-grow-1 mb-0">Current Month Transactions</h4>
                                                       <div class="flex-shrink-0">
                                                            <a href="javascript:void(0);" class="btn btn-soft-dark btn-sm">Export Report</a>
                                                       </div>
                                                  </div><!-- end cardheader -->
                                                  <div class="card-body">
                                                       <div class="table-responsive table-card">
                                                            <table class="table table-nowrap table-centered align-middle">
                                                                 <thead class="bg-light text-muted">
                                                                      <tr>
                                                                           <th scope="col">S/N</th>
                                                                           <th scope="col">Member</th>
                                                                           <th scope="col">Description</th>
                                                                           <th scope="col">Week/Month</th>
                                                                           <th scope="col">Amount</th>
                                                                           <th scope="col">Date</th>
                                                                      </tr><!-- end tr -->
                                                                 </thead><!-- thead -->

                                                                 <tbody>
                                                                      @foreach ($monthly as $transaction)
                                                                      <tr>
                                                                           <td class="fw-medium">{{ $loop->iteration }}</td>
                                                                           <td class="fw-medium">{{ $transaction->user->name ?? ""}}</td>
                                                                           <td class="fw-medium">{{ $transaction->payment_type }}</td>
                                                                           <td class="fw-medium">{{ $transaction->month == NULL ? $transaction->week :  $transaction->month}}</td>
                                                                           <td class="fw-medium">₦ {{ $transaction->original > 0 ? number_format($transaction->original, 2 ) : number_format($transaction->amount, 2 )}}</td>
                                                                           <td class="text-muted">{{ \Carbon\Carbon::parse($transaction->updated_at)->format('jS M, Y - h:iA') }}</td>
                                                                      </tr>
                                                                      @endforeach
                                                                 </tbody><!-- end tbody -->
                                                            </table><!-- end table -->
                                                       </div>
                                                       <div class="d-flex justify-content-end">
                                                            <div class="pagination-wrap hstack gap-2">
                                                                 {{ $monthly->links() }}
                                                            </div>
                                                       </div>
                                                  </div><!-- end card body -->
                                             </div><!-- end card -->
                                        </div><!-- end col -->

                                        <div class="col-xl-5">
                                        </div><!-- end col -->
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
     $('.copy-link').click(function() {
          // Get the text of the link
          var linkText = $('#cttaste-link').text();

          // Create a temporary input element to copy the text
          var tempInput = $('<input>');
          $('body').append(tempInput);
          tempInput.val(linkText).select();
          document.execCommand('copy');
          tempInput.remove();
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
          })
          // Optionally show a notification or alert
          Toast.fire('Link Copied')
     });

     document.addEventListener("DOMContentLoaded", function() {
          const ctx = document.getElementById('ordersChart').getContext('2d');
          const ordersChart = new Chart(ctx, {
               type: 'bar', // Bar chart
               data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [{
                         label: 'Total Orders',
                         data: [{
                                   {
                                        $january ?? 0
                                   }
                              },
                              {
                                   {
                                        $february ?? 0
                                   }
                              },
                              {
                                   {
                                        $march ?? 0
                                   }
                              },
                              {
                                   {
                                        $april ?? 0
                                   }
                              },
                              {
                                   {
                                        $may ?? 0
                                   }
                              },
                              {
                                   {
                                        $june ?? 0
                                   }
                              },
                              {
                                   {
                                        $july ?? 0
                                   }
                              },
                              {
                                   {
                                        $august ?? 0
                                   }
                              },
                              {
                                   {
                                        $september ?? 0
                                   }
                              },
                              {
                                   {
                                        $october ?? 0
                                   }
                              },
                              {
                                   {
                                        $november ?? 0
                                   }
                              },
                              {
                                   {
                                        $december ?? 0
                                   }
                              }
                         ],

                         // Correct data array
                         backgroundColor: [
                              'rgba(75, 192, 192, 0.2)',
                              'rgba(153, 102, 255, 0.2)',
                              'rgba(255, 159, 64, 0.2)',
                              'rgba(54, 162, 235, 0.2)',
                              'rgba(255, 206, 86, 0.2)',
                              'rgba(75, 192, 192, 0.2)',
                              'rgba(153, 102, 255, 0.2)',
                              'rgba(255, 159, 64, 0.2)',
                              'rgba(54, 162, 235, 0.2)',
                              'rgba(255, 206, 86, 0.2)',
                              'rgba(75, 192, 192, 0.2)',
                              'rgba(153, 102, 255, 0.2)'
                         ],
                         borderColor: [
                              'rgba(75, 192, 192, 1)',
                              'rgba(153, 102, 255, 1)',
                              'rgba(255, 159, 64, 1)',
                              'rgba(54, 162, 235, 1)',
                              'rgba(255, 206, 86, 1)',
                              'rgba(75, 192, 192, 1)',
                              'rgba(153, 102, 255, 1)',
                              'rgba(255, 159, 64, 1)',
                              'rgba(54, 162, 235, 1)',
                              'rgba(255, 206, 86, 1)',
                              'rgba(75, 192, 192, 1)',
                              'rgba(153, 102, 255, 1)'
                         ],
                         borderWidth: 1
                    }]
               },
               options: {
                    responsive: true,
                    scales: {
                         y: {
                              beginAtZero: true
                         }
                    }
               }
          });
     });
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