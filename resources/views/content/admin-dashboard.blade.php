@extends('layout.app-layout')

@section('title', 'MMML - Dashboard')

@section('content')

    <div class="content">
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fa fa-building" style="color: #ffc107; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters" data-count="{{ $total_branch }}">{{ $total_branch }} | Branch</span>
                        </h5>
                        <h6>Total Branch</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash1 w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fa fa-user-tie" style="color: #28C76F; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters" data-count="{{ $total_employees }}">{{ $total_employees }}</span>
                        </h5>
                        <h6>Total Employees</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash2 w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fa fa-users" style="color: #007bff; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters" data-count="{{ $total_applicants }}">{{ $total_applicants }}</span>
                        </h5>
                        <h6>Total Applicants</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-widget dash3 w-100">
                    <div class="dash-widgetimg">
                        <span><i class="fa fa-briefcase" style="color: #dc3545; font-size: 1.3rem;"></i></span>
                    </div>
                    <div class="dash-widgetcontent">
                        <h5>
                            <span class="counters" data-count="{{ $total_jobs }}">{{ $total_jobs }}</span>
                        </h5>
                        <h6>Total Jobs</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count">
                    <div class="dash-counts">
                        <h4>{{ $unscheduled_applications }}</h4>
                        <h5>Unscheduled Applications</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das1">
                    <div class="dash-counts">
                        <h4>{{ $scheduled_interviews }}</h4>
                        <h5>Today's Scheduled Interview</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="user-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das2">
                    <div class="dash-counts">
                        <h4>{{ $pending_hiring }}</h4>
                        <h5>Pending Hiring</h5>
                    </div>
                    <div class="dash-imgs">
                        <img src="assets/img/icons/file-text-icon-01.svg" class="img-fluid" alt="icon" />
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 d-flex">
                <div class="dash-count das3">
                    <div class="dash-counts">
                        <h4>{{ $pending_deployment }}</h4>
                        <h5>Pending Deployment</h5>
                    </div>
                    <div class="dash-imgs">
                        <i data-feather="file"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->

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
                            <div class="dropdown dropdown-wraper">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    2023
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">2023</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">2022</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item">2021</a>
                                    </li>
                                </ul>
                            </div>
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
                        <h4 class="card-title mb-0">Scheduled Interviews</h4>
                        <div class="view-all-link">
                            <a href="scheduled-employer-interviews" class="view-all d-flex align-items-center">
                                View All<span class="ps-2 d-flex align-items-center"><i data-feather="arrow-right"
                                        class="feather-16"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($scheduled_interviews_list->isEmpty())
                            <div class="text-center mt-4">
                                <i class="fa fa-calendar-times" style="font-size: 2rem; color: #dc3545;"></i>
                                <p class="mt-4">No scheduled interviews available.</p>
                            </div>
                        @else
                            <div class="table-responsive dataview">
                                <table class="table dashboard-recent-products">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Applicant</th>
                                            <th>Job</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($scheduled_interviews_list as $scheduled_interview)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="productimgname">
                                                    <a href="product-list.html" class="product-img">
                                                        <img src="/storage/{{$scheduled_interview->applicant->profile_photo_path}}" alt="product" />
                                                    </a>
                                                    <a>{{ $scheduled_interview->applicant->first_name }} {{ substr($scheduled_interview->applicant->middle_name, 0, 1) }}. {{ $scheduled_interview->applicant->last_name }}</a>
                                                </td>
                                                <td>{{$scheduled_interview->job->job_title}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
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
