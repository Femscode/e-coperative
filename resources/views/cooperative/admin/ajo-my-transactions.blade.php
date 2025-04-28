@extends('cooperative.admin.master')
@section('header')


@endsection

@section('content')
<div class="container-fluid">

     <!-- Start here.... -->
     <div class="row">
          <div class="col-xxl-12">

            


               <div class='row'>
                    <div class='col-md-12'>

                         <div class="card">
                              <div class="card-body">

                                   <div class="row">
                                        <div class="col-xl-12">
                                             <div class="card">
                                                  <div class="card-header d-flex align-items-center">
                                                       <h4 class="card-title flex-grow-1 mb-0">My Transaction Histrory</h4>
                                                       <div class="flex-shrink-0">
                                                            <!-- <a href="#" class="btn btn-soft-dark btn-sm">View Chart</a> -->
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
                                                                      
                                                                           <th scope="col">Amount</th>
                                                                           <th scope="col">Date</th>
                                                                      </tr><!-- end tr -->
                                                                 </thead><!-- thead -->

                                                                 <tbody>
                                                                      @foreach ($transactions as $transaction)
                                                                      <tr>
                                                                           <td class="fw-medium">{{ $loop->iteration }}</td>
                                                                           <td class="fw-medium">{{ $transaction->user->name ?? ""}}</td>
                                                                           <td class="fw-medium">{{ $transaction->payment_type }}</td>
                                                                           <td class="fw-medium">₦ {{ $transaction->original > 0 ? number_format($transaction->original, 2 ) : number_format($transaction->amount, 2 )}}</td>
                                                                           <td class="text-muted">{{ \Carbon\Carbon::parse($transaction->updated_at)->format('jS M, Y - h:iA') }}</td>
                                                                      </tr>
                                                                      @endforeach
                                                                 </tbody><!-- end tbody -->
                                                            </table><!-- end table -->
                                                       </div>
                                                       <div class="d-flex justify-content-end">
                                                            <div class="pagination-wrap hstack gap-2">
                                                                 {{ $transactions->links() }}
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