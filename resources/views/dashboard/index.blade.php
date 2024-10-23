@extends('dashboard.master')
@section('header')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container-fluid">

     <!-- Start here.... -->
     <div class="row">
          <div class="col-xxl-5">
               <div class="row">
                    <div class="col-12">



                         <h6> Registration Link
                              <p class="d-flex align-items-center border p-2 rounded-2 border-dashed alert alert-primary text-start mb-0">
                                   <span id="cttaste-link">https://ecoperative.com/{{ $user->company->slug }}</span>
                                   <a href="#!" class="ms-auto fs-4 copy-link"><i class="ti ti-copy"></i></a>
                              </p>
                         </h6>



                    </div>
               </div>



               <div class="row">
                    <div class="col-xl-4">
                         <div class="card overflow-hidden" style='background-image:url("/assets/images/vbg3.jpg");background-repeat:no-repeat;background-size:cover'>
                              
                              <div class="card-body pt-0">
                                   <div class="row">


                                        <div class="col-sm-12 pt-4 mt-4">
                                             <div class="pt-4 mt-4">
                                                  
                                                  <div class='alert alert-primary'>
                                                       <div style="margin: auto;">
                                                            <canvas id="ordersChart"></canvas>
                                                       </div>
                                                  </div>
                                                  <div class='card col-md-12 bg-light-success'>

                                                       <a onclick='return confirm("Are you sure you want to enable {{$user->name}}")'
                                                            href="disable/{{$user->id}}" class="btn btn-dark">Register New Member</a>

                                                      

                                                  </div>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>

                    </div>
                    <div class="col-xl-8">

                         <!-- end row -->

                         <div class="row">
                              <div class="col">
                                   <div class="card">
                                        <div class="card-body overflow-hidden position-relative">
                                             <iconify-icon icon="solar:bill-list-bold-duotone" class="fs-32 text-primary avatar-title"></iconify-icon>
                                             <h3 class="mb-0 fw-bold mt-3 mb-1">₦ {{ number_format($transactions->sum('balance'),2) }}</h3>
                                             <a href='/transactions' class="text-muted">Total Revenue</a>
                                             <!-- <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 10.58%</span> -->
                                             <i class="bx bx-building-house widget-icon"></i>
                                        </div> <!-- end card-body -->
                                   </div> <!-- end card -->
                              </div> <!-- end col -->
                              <div class="col">
                                   <div class="card">
                                        <div class="card-body overflow-hidden position-relative">
                                             <iconify-icon icon="iconamoon:3d-duotone" class="fs-36 text-info"></iconify-icon>
                                             <h3 class="mb-0 fw-bold mt-3 mb-1">{{count($users)}}</h3>
                                             <a href='/food' class="text-muted">Total Members</a>
                                             <!-- <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 8.72%</span> -->
                                             <i class="bx bx-user widget-icon"></i>

                                        </div> <!-- end card-body -->
                                   </div> <!-- end card -->
                              </div> <!-- end col -->

                              <div class="col">
                                   <div class="card">
                                        <div class="card-body overflow-hidden position-relative">
                                             <iconify-icon icon="iconamoon:category-duotone" class="fs-36 text-success"></iconify-icon>
                                             <h3 class="mb-0 fw-bold mt-3 mb-1">₦ {{ $transactions->where('payment_type', 'Registration')->sum('balance')}}</h3>
                                             <a href='/today_orders' class="text-muted">Registration Revenue</a>
                                             <i class="bx bx-bar-chart-alt-2 widget-icon"></i>
                                        </div>
                                   </div>
                              </div>

                              <!-- <div class="col">
                                   <div class="card">
                                        <div class="card-body overflow-hidden position-relative">
                                             <iconify-icon icon="iconamoon:store-duotone" class="fs-36 text-purple"></iconify-icon>
                                             <h3 class="mb-0 fw-bold mt-3 mb-1"> count($last_week_orders) </h3>
                                             <a href='/orders' class="text-muted">Last Week Orders</a>
                                              <i class="bx bx-doughnut-chart widget-icon"></i>


                                        </div> 
                                   </div>
                              </div>  -->




                         </div>



                         <div class="card">
                              <div class="card-body">
                                   
                                   <div class="row">
                                        <div class="col-xl-12">
                                             <div class="card">
                                                  <div class="card-header d-flex align-items-center">
                                                       <h4 class="card-title flex-grow-1 mb-0">Recent Transactions</h4>
                                                       <div class="flex-shrink-0">
                                                            <a href="javascript:void(0);" class="btn btn-soft-info btn-sm">Export Report</a>
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
                                                                           <th scope="col">Month</th>
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
                                                                           <td class="fw-medium">{{ $transaction->month }}</td>
                                                                           <td class="fw-medium">{{ number_format($transaction->original, 2) }}</td>
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

          <!-- <div class="col-xxl-7">
               <div class="card">
                    <div class="card-body">
                         <div class="d-flex justify-content-between align-items-center">
                              <h4 class="card-title">Performance</h4>
                              <div>
                                   <button type="button" class="btn btn-sm btn-outline-light">ALL</button>
                                   <button type="button" class="btn btn-sm btn-outline-light">1M</button>
                                   <button type="button" class="btn btn-sm btn-outline-light">6M</button>
                                   <button type="button" class="btn btn-sm btn-outline-light active">1Y</button>
                              </div>
                         </div> 

                         <div dir="ltr">
                              <div id="dash-performance-chart" class="apex-charts"></div>
                         </div>
                    </div> 
               </div>
          </div> -->
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


@endsection