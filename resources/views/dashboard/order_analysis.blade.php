@extends('vendordashboard.master')
@section('header')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="container-fluid">

     <!-- Start here.... -->
     <div class="row">
          <div class="col-xxl-5">
           


               <div class="row">
                   
                    <div class="col-xl-12">

                         <!-- end row -->

                         <div class="row">
                             
                              <div class="col">
                                   <div class="card">
                                        <div class="card-body overflow-hidden position-relative">
                                             <iconify-icon icon="iconamoon:3d-duotone" class="fs-36 text-info"></iconify-icon>
                                             <h3 class="mb-0 fw-bold mt-3 mb-1">{{number_format($total_orders)}}</h3>
                                             <a href='/food' class="text-muted">Total Orders</a>
                                             <!-- <span class="badge fs-12 badge-soft-success"><i class="ti ti-arrow-badge-up"></i> 8.72%</span> -->
                                             <i class="bx bx-bowl-hot widget-icon"></i>

                                        </div> <!-- end card-body -->
                                   </div> <!-- end card -->
                              </div> <!-- end col -->

                              <div class="col">
                                   <div class="card">
                                        <div class="card-body overflow-hidden position-relative">
                                             <iconify-icon icon="iconamoon:category-duotone" class="fs-36 text-success"></iconify-icon>
                                             <h3 class="mb-0 fw-bold mt-3 mb-1">{{number_format($orders)}}</h3>
                                             <a href='/today_orders' class="text-muted">Today's Orders</a>
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
                                   <div class="text-center">

                                        <p class="font-16 text-muted mb-2"></p>
                                        <h5><a href="javascript: void(0);" class="text-dark">Monthly Analysis
                                             </a></h5>
                                   </div>
                                   <div class='alert alert-info'>
                                        <div style="margin: auto;">
                                             <canvas id="ordersChart"></canvas>
                                        </div>
                                   </div>

                              </div>
                         </div>
                         <div class="card">
                              <div class="card-body">
                                   <div class="text-center">

                                        <p class="font-16 text-muted mb-2"></p>
                                        <h5><a href="javascript: void(0);" class="text-dark">Location Analysis
                                             </a></h5>
                                   </div>
                                   <div class='alert alert-info'>
                                        <div style="margin: auto;">
                                             <canvas id="locationChart"></canvas>
                                        </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ctx, {
            type: 'bar', // Bar chart
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Total Orders',
                    data: [
                         {{ $january ?? 0 }},
                         {{ $february ?? 0 }},
                         {{ $march ?? 0 }},
                         {{ $april ?? 0 }},
                         {{ $may ?? 0 }},
                         {{ $june ?? 0 }},
                         {{ $july ?? 0 }},
                         {{ $august ?? 0 }},
                         {{ $september ?? 0 }},
                         {{ $october ?? 0 }},
                         {{ $november ?? 0 }},
                         {{ $december ?? 0 }}
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
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('locationChart').getContext('2d');
        
        // Prepare data for the pie chart from the locations data
        const locations = @json($locations);
        const labels = locations.map(location => location.location); // Labels will be the location names
        const data = locations.map(location => location.location_count); // Data will be the counts of each location
        
        const ordersChart = new Chart(ctx, {
            type: 'pie', // Pie chart
            data: {
                labels: labels, // Location names
                datasets: [{
                    label: 'Total Orders',
                    data: data, // Number of orders per location
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>

@endsection