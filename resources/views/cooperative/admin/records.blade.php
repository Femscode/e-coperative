@extends('vendorcooperative.admin.master')
@section('header')

@endsection

@section('content')

<div class="container-xxl" id="kt_content_container">
    <!--begin::Products-->


    <div class="row">
        <!--begin::Col-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body overflow-hidden position-relative">
                    <iconify-icon icon="iconamoon:category-duotone" class="fs-36 text-success"></iconify-icon>
                     <a href='/today_orders' class="text-muted"><br>Total Sales</a>
                    <h3 class="mb-0 fw-bold mt-1 mb-1">₦{{number_format($total_sales,2) }}</h3>
                    <div id="kt_table_widget_4_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">
                            <button id="exportButton" class='btn btn-success'>Download In Excel</button>
                            <div style='overflow-x:auto;max-width: 100%'>
                                <table style='width:100%' id='datatable'
                                    class="table align-middle table-row-dashed fs-6 gy-3 dataTable no-footer">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px sorting_disabled" rowspan="1" colspan="1"
                                        style="width: 100px;">Product ID</th>
                                            <th class="text-end min-w-100px sorting_disabled" rowspan="1"
                                                colspan="1" style="width: 100px;">Name</th>
                                            <th class="text-end min-w-125px sorting_disabled" rowspan="1"
                                                colspan="1" style="width: 125px;">Count</th>
                                            <th class="text-end min-w-100px sorting_disabled" rowspan="1"
                                                colspan="1" style="width: 100px;">Unit Price(₦)
                                            </th>
                                            <th class="text-end min-w-100px sorting_disabled" rowspan="1"
                                                colspan="1" style="width: 100px;">Sales(₦)</th>

                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold">





                                        @foreach($foods as $key=> $food)

                                        <tr>
                                        <td>
                                                    #PRD-{{ $food[0]['id']
                                                        }}
                                                </td>
                                            <td class="text-end">{{ $food[0]['name'] }}</td>
                                            <td class="text-end">
                                                {{ number_format($food[1])}}
                                            </td>
                                            <td class="text-end">{{ number_format($food[0]['price']) }}</td>

                                            <td class="text-end">
                                                {{number_format( $food[0]['price'] * $food[1] )}}</span>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>


                            </div>
                        </div>
                        <div class="row">
                            <div
                                class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
                            </div>
                            <div
                                class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
                            </div>
                        </div>
                    </div>
                    <i class="bx bx-bar-chart-alt-2 widget-icon"></i>
                </div>
            </div>

        </div>



    </div>
    <!--end::Products-->
</div>
@endsection

@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#datatable').DataTable();

        // Add export functionality
        $('#exportButton').on('click', function() {
            // Convert DataTable to Excel
            var data = table
                .rows()
                .data()
                .toArray();

            var ws = XLSX.utils.aoa_to_sheet(data);
            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

            // Save the Excel file
            XLSX.writeFile(wb, 'datatable_export.xlsx');
        });
    });
</script>



@endsection