@extends('layout.app-layout')

@section('title', 'MMML - Dashboard')

@section('content')

    <div class="content">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fas fa-file-alt" style="color: #ffc107; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters" data-count="{{ $total_applications }}">{{ $total_applications }}</span>
                        </h5>
                        <h6>Total Applications</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash1 w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fas fa-calendar-check" style="color: #28C76F; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters"
                                data-count="{{ $total_scheduled_interviews }}">{{ $total_scheduled_interviews }}</span>
                        </h5>
                        <h6>Total Scheduled Interviews</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash2 w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fas fa-check-circle" style="color: #007bff; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters"
                                data-count="{{ $total_approve_applications }}">{{ $total_approve_applications }}</span>
                        </h5>
                        <h6>Total Approve Applications</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash3 w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fas fa-times-circle" style="color: #dc3545; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters"
                                data-count="{{ $total_rejected_applications }}">{{ $total_rejected_applications }}</span>
                        </h5>
                        <h6>Total Rejected Applications</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7 col-sm-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Hired & Deployed</h5>
                        <div class="graph-sets">
                            <ul class="mb-0">
                                <li>
                                    <span>Hired</span>
                                </li>
                                <li>
                                    <span>Deployed</span>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="application_charts"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-sm-12 col-12 d-flex">
                <div class="card flex-fill default-cover mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Applicants Submitting Documents</h4>
                        <div class="view-all-link">
                            <a href="scheduled-branch-interviews" class="view-all d-flex align-items-center">
                                View All<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right"
                                        class="feather-16"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive dataview">
                            @if ($applications_submitting_documents->isEmpty())
                                <div class="text-center mt-4">
                                    <i class="fa fa-calendar-times" style="font-size: 2rem; color: #dc3545;"></i>
                                    <p class="mt-4">No applicants submitting documents available.</p>
                                </div>
                            @else
                                <table class="table dashboard-recent-products">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Applicant</th>
                                            <th>Job</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($applications_submitting_documents as $application)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="productimgname">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="/storage/{{ $application->applicant->profile_photo_path }}"
                                                            alt="product" />
                                                    </a>
                                                    <a>{{ $application->applicant->first_name }}
                                                        {{ substr($application->applicant->middle_name, 0, 1) }}.
                                                        {{ $application->applicant->last_name }}</a>
                                                </td>
                                                <td>{{ $application->job->job_title }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            if ($("#application_charts").length > 0) {
                $.ajax({
                    url: "/get-application-chart-data", // Laravel route
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        var maxHired = Math.max(...response.hired);
                        var maxDeployed = Math.max(...response.deployed);
                        var maxY = Math.max(maxHired, maxDeployed);

                        var options = {
                            series: [{
                                    name: "Hired",
                                    data: response.hired,
                                },
                                {
                                    name: "Deployed",
                                    data: response.deployed,
                                },
                            ],
                            colors: ["#28C76F", "#EA5455"],
                            chart: {
                                type: "bar",
                                height: 320,
                                zoom: {
                                    enabled: true
                                },
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    borderRadius: 4,
                                    columnWidth: "50%",
                                },
                            },
                            dataLabels: {
                                enabled: false
                            },
                            yaxis: {
                                min: 0,
                                max: maxY,
                                tickAmount: 5
                            },
                            xaxis: {
                                categories: [
                                    "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                                ],
                            },
                            legend: {
                                show: false
                            },
                            fill: {
                                opacity: 1
                            },
                        };

                        var chart = new ApexCharts(
                            document.querySelector("#application_charts"),
                            options
                        );
                        chart.render();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    }
                });
            }
        });
    </script>
@endpush
