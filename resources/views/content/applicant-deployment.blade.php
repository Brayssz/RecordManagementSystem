@extends('layout.app-layout')

@section('title', 'Approve Applications')

@section('content')

    <div class="content">

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Applicant Deployment</h4>
                    <h6>Review and Hire Applicants</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh" class="reload_btn"><i
                            data-feather="rotate-ccw" class="feather-rotate-ccw"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
        </div>

        <div class="card table-list-card">
            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new d-flex ">
                    <div class="search-set mb-0 d-flex w-100 justify-content-start">

                        <div class="search-input text-left">
                            <a href="" class="btn btn-searchset"><i data-feather="search"
                                    class="feather-search"></i></a>
                        </div>

                        <div class="row mt-sm-3 mt-xs-3 mt-lg-0 w-sm-100 flex-grow-1">

                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group ">
                                    <select class="select branch_filter form-control">
                                        <option value="">Branch</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->municipality }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group ">
                                    <select class="select employer_filter form-control">
                                        <option value="">Employer</option>
                                        @foreach ($employers as $employer)
                                            <option value="{{ $employer->employer_id }}">{{ $employer->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group ">
                                    <select class="select deployed_filter form-control">
                                        <option value="">Pending</option>
                                        <option value=true>Deployed</option>
                                    </select>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table application-table pb-3">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Code</th>
                                <th>Employer</th>
                                <th>Applicant</th>
                                <th>Job</th>
                                <th>Country</th>
                                <th>Branch</th>
                                <th>Date Hired</th>
                                <th class="no-sort">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @livewire('content.deploy-applicant')
    @livewire('content.view-application')

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            initSelect();

            @if (session('message'))
                toastr.success("{{ session('message') }}", "Success", {
                    closeButton: true,
                    progressBar: true,
                });
            @endif

            if ($('.application-table').length > 0) {
                var table = $('.application-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "bFilter": true,
                    "sDom": 'fBtlpi',
                    'pagingType': 'numbers',
                    "ordering": true,
                    "order": [
                        [0, 'desc']
                    ],
                    "language": {
                        search: ' ',
                        sLengthMenu: '_MENU_',
                        searchPlaceholder: "Search...",
                        info: "_START_ - _END_ of _TOTAL_ items",
                    },
                    "ajax": {
                        "url": "/deploy-applicants",
                        "type": "GET",
                        "headers": {
                            "Accept": "application/json"
                        },
                        "data": function(d) {
                            d.branch_id = $('.branch_filter').val();
                            d.employer_id = $('.employer_filter').val();
                            d.only_deployed = $('.deployed_filter').val();
                        },
                        "dataSrc": "data"
                    },
                    "columns": [{
                            "data": "application_id",
                            "visible": false,
                            "searchable": false
                        },
                        {
                            "data": "hiring.confirmation_code"
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let avatarSrc = 'assets/img/no-profile.png';
                                if (row.job.employer.profile_photo_path) {
                                    avatarSrc = `/storage/${row.job.employer.profile_photo_path}`;
                                    return `
                                            <div class="userimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="${avatarSrc}" alt="product" loading="lazy">
                                                </a>
                                                <div>
                                                    <a href="javascript:void(0);">${row.job.employer.company_name}</a>
                                                    <span class="emp-team">${row.job.employer.first_name || "Unknown"} ${row.job.employer.middle_name ? `${row.job.employer.middle_name} ` : ""}${row.job.employer.last_name || "User"}</span>
                                                </div>
                                            </div>
                                        `;
                                } else {
                                    const colors = {
                                        A: 'bg-primary',
                                        B: 'bg-success',
                                        C: 'bg-info',
                                        D: 'bg-warning',
                                        E: 'bg-danger',
                                        F: 'bg-secondary',
                                        G: 'bg-dark',
                                        H: 'bg-light',
                                        I: 'bg-primary',
                                        J: 'bg-success',
                                        K: 'bg-info',
                                        L: 'bg-warning',
                                        M: 'bg-danger',
                                        N: 'bg-secondary',
                                        O: 'bg-dark',
                                        P: 'bg-light',
                                        Q: 'bg-primary',
                                        R: 'bg-success',
                                        S: 'bg-info',
                                        T: 'bg-warning',
                                        U: 'bg-danger',
                                        V: 'bg-secondary',
                                        W: 'bg-dark',
                                        X: 'bg-light',
                                        Y: 'bg-primary',
                                        Z: 'bg-success',
                                    };

                                    const firstLetter = (row.job.employer.first_name ? row.job
                                        .employer.first_name.charAt(0).toUpperCase() : 'U');
                                    const bgColor = colors[firstLetter] || 'bg-secondary';

                                    return `
                                            <div class="userimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <span class="avatar ${bgColor} avatar-rounded">
                                                        <span class="avatar-title">${row.job.employer.first_name ? row.job.employer.first_name.charAt(0).toUpperCase() : 'U'}${row.job.employer.last_name ? row.job.employer.last_name.charAt(0).toUpperCase() : 'U'}</span>
                                                    </span>
                                                </a>
                                                <div>
                                                     <a href="javascript:void(0);">${row.job.employer.company_name}</a>
                                                    <span class="emp-team">${row.job.employer.first_name || "Unknown"} ${row.job.employer.middle_name ? `${row.job.employer.middle_name} ` : ""}${row.job.employer.last_name || "User"}</span>
                                                </div>
                                            </div>
                                        `;
                                }
                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let avatarSrc = 'assets/img/no-profile.png';
                                if (row.applicant.profile_photo_path) {
                                    avatarSrc = `/storage/${row.applicant.profile_photo_path}`;
                                    return `
                                        <div class="userimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <img src="${avatarSrc}" alt="product" loading="lazy">
                                            </a>
                                            <div>
                                                <a href="javascript:void(0);">${row.applicant.first_name || "Unknown"} ${row.applicant.middle_name ? `${row.applicant.middle_name} ` : ""}${row.applicant.last_name || "User"}</a>
                                                <span class="emp-team">${moment(row.created_at).fromNow()}</span>
                                            </div>
                                        </div>
                                    `;
                                } else {
                                    const colors = {
                                        A: 'bg-primary',
                                        B: 'bg-success',
                                        C: 'bg-info',
                                        D: 'bg-warning',
                                        E: 'bg-danger',
                                        F: 'bg-secondary',
                                        G: 'bg-dark',
                                        H: 'bg-light',
                                        I: 'bg-primary',
                                        J: 'bg-success',
                                        K: 'bg-info',
                                        L: 'bg-warning',
                                        M: 'bg-danger',
                                        N: 'bg-secondary',
                                        O: 'bg-dark',
                                        P: 'bg-light',
                                        Q: 'bg-primary',
                                        R: 'bg-success',
                                        S: 'bg-info',
                                        T: 'bg-warning',
                                        U: 'bg-danger',
                                        V: 'bg-secondary',
                                        W: 'bg-dark',
                                        X: 'bg-light',
                                        Y: 'bg-primary',
                                        Z: 'bg-success',
                                    };

                                    const firstLetter = (row.applicant.first_name ? row.applicant
                                        .first_name.charAt(0)
                                        .toUpperCase() : 'U'
                                    ); // Default to 'U' if first_name is missing
                                    const bgColor = colors[firstLetter] || 'bg-secondary';

                                    return `
                                        <div class="userimgname">
                                            <a href="javascript:void(0);" class="product-img">
                                                <span class="avatar ${bgColor} avatar-rounded">
                                                    <span class="avatar-title">${row.applicant.first_name ? row.applicant.first_name.charAt(0).toUpperCase() : 'U'}${row.applicant.last_name ? row.applicant.last_name.charAt(0).toUpperCase() : 'U'}</span>
                                                </span>
                                            </a>
                                            <div>
                                                <a href="javascript:void(0);">${row.applicant.first_name || "Unknown"} ${row.applicant.middle_name ? `${row.applicant.middle_name} ` : ""}${row.applicant.last_name || "User"}</a>
                                                <span class="emp-team text-muted fs-2">${moment(row.created_at).fromNow()}</span>
                                            </div>
                                        </div>
                                    `;
                                }
                            }
                        },
                        {
                            "data": "job.job_title"
                        },
                        {
                            "data": "job.country"
                        },
                        {
                            "data": "branch.municipality"
                        },
                        {
                            "data": "hiring.confirmation_date",
                            "render": function(data, type, row) {
                                return moment(data).format('MMMM D, YYYY');
                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let actionButtons = `
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2 view-application" data-applicationid="${row.application_id}">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                `;

                                if (row.deployment === null) {
                                    actionButtons += `
                                    <a class="btn btn-primary deploy" data-applicationid="${row.application_id}">
                                        <i data-feather="calendar" class="feather-calendar me-1"></i> Set
                                    </a>
                                    `;
                                } else {
                                    actionButtons += `
                                    <a class="btn btn-primary reschedule" data-applicationid="${row.application_id}" data-deploymentid="${row.deployment.deployment_id}">
                                        <i data-feather="calendar" class="feather-calendar me-1"></i> Deploy
                                    </a>
                                    `;
                                }

                                actionButtons += `</div>`;

                                return actionButtons;
                            }
                        }
                    ],
                    "createdRow": function(row, data, dataIndex) {
                        $(row).find('td').eq(7).addClass('action-table-data');
                    },
                    "initComplete": function(settings, json) {
                        $('.dataTables_filter').appendTo('#tableSearch');
                        $('.dataTables_filter').appendTo('.search-input');
                        feather.replace();

                        $('.branch_filter, .employer_filter, .deployed_filter').on('change', function() {
                            table.draw();
                        });

                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                });

                $('.reload_btn').on('click', function() {
                    window.location.reload();
                })
            }
        });



        function initSelect() {
            $('.select').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });

            $('#job_countries').select2({
                placeholder: "Select countries",
                allowClear: true,
                closeOnSelect: false
            });
        }
    </script>
@endpush
