@extends('layout.applicant-layout')

@section('title', 'My Transactions')

@section('content')

    <div class="content">

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Applicant Transactions</h4>
                    <h6>Review your application transactions and stay updated with the latest status of your job
                        applications.</h6>
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
                                    <select class="select status_filter form-control">
                                        <option value="">Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="Canceled">Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group ">
                                    <select class="select branch_filter form-control">
                                        <option value="">Branch</option>

                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->municipality }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table my-application-table pb-3">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Applicant</th>
                                <th>Job</th>
                                <th>Country</th>
                                <th>Branch</th>
                                <th>Birth Certificate</th>
                                <th>Passport</th>
                                <th>Medical Certificate</th>
                                <th>NBI Clearance</th>
                                <th>Valid ID</th>
                                <th class="no-sort">Status</th>
                                <th class="no-sort">Cancel</th>
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
    @livewire('content.cancel-application')

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


            const recquiredDocs = ['Birth Certificate', 'Passport', 'Medical Certificate', 'NBI Clearance',
                'Valid ID'
            ];

            function checkDocsExist(documents, doc_type) {
                console.log('Documents:', documents);
                console.log('Document Type:', doc_type);
                const result = documents.includes(doc_type);
                console.log('Result:', result);
                return result;
            }
            if ($('.my-application-table').length > 0) {
                var table = $('.my-application-table').DataTable({
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
                        "url": "/my-applications",
                        "type": "GET",
                        "headers": {
                            "Accept": "application/json"
                        },
                        "data": function(d) {
                            d.status = $('.status_filter').val();
                            d.branch_id = $('.branch_filter').val();
                            d.country_id = $('.country_filter').val();
                        },
                        "dataSrc": "data"
                    },
                    "columns": [{
                            "data": "application_id",
                            "visible": false,
                            "searchable": false
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

                                    const firstLetter = (row.applicant.first_name ? row.applicant.first_name.charAt(0)
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
                            "data": null,
                            "render": function(data, type, row) {
                                let submittedDocs = row.documents.map(doc => doc.document_type);
                                if (checkDocsExist(submittedDocs, 'Birth Certificate') === true) {
                                    return `<span class="badge badge-linesuccess">✓</span>`;
                                } else {
                                    return `<span class="badge badge-linedanger">X</span>`;
                                }

                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let submittedDocs = row.documents.map(doc => doc.document_type);
                                if (checkDocsExist(submittedDocs, 'Passport') === true) {
                                    return `<span class="badge badge-linesuccess">✓</span>`;
                                } else {
                                    return `<span class="badge badge-linedanger">X</span>`;
                                }

                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let submittedDocs = row.documents.map(doc => doc.document_type);
                                if (checkDocsExist(submittedDocs, 'Medical Certificate') === true) {
                                    return `<span class="badge badge-linesuccess">✓</span>`;
                                } else {
                                    return `<span class="badge badge-linedanger">X</span>`;
                                }

                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let submittedDocs = row.documents.map(doc => doc.document_type);
                                if (checkDocsExist(submittedDocs, 'NBI Clearance') === true) {
                                    return `<span class="badge badge-linesuccess">✓</span>`;
                                } else {
                                    return `<span class="badge badge-linedanger">X</span>`;
                                }

                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let submittedDocs = row.documents.map(doc => doc.document_type);
                                if (checkDocsExist(submittedDocs, 'Valid ID') === true) {
                                    return `<span class="badge badge-linesuccess">✓</span>`;
                                } else {
                                    return `<span class="badge badge-linedanger">X</span>`;
                                }
                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                if (row.status === "Pending") {
                                    return `<span class="badge badge-linewarning">Pending for Manager Interview</span>`;
                                } else if (row.status === "Interviewed") {
                                    return `<span class="badge badge-lineprimary">Interviewed</span>`;
                                } else if (row.status === "Submitting") {
                                    return `<span class="badge badge-lineinfo">Submitting Documents</span>`;
                                } else if (row.status === "Reviewing") {
                                    return `<span class="badge badge-linesecondary">Reviewing Application</span>`;
                                } else if (row.status === "ScheduledBranchInterview") {
                                    return `<span class="badge badge-linesecondary">Scheduled for Branch Interview</span>`;
                                } else if (row.status === "ScheduledEmployerInterview") {
                                    return `<span class="badge badge-lineinfo">Scheduled for Employer Interview</span>`;
                                } else if (row.status === "Waiting") {
                                    return `<span class="badge badge-lineyellow">Waiting to be Hired</span>`;
                                } else if (row.status === "Hired") {
                                    return `<span class="badge badge-lineyellow">Waiting to be Deployed</span>`;
                                } else if (row.status === "Deployed") {
                                    return `<span class="badge badge-linesuccess">Deployed With Departure Schedule</span>`;
                                } else if (row.status === "Cancelled") {
                                    return `<span class="badge badge-linedanger">Canceled Application</span>`;
                                } else if (row.status === "Rejected") {
                                    return `<span class="badge badge-linedanger">Rejected Application</span>`;
                                } else {
                                    return `<span class="badge badge-linedark">Unknown</span>`;
                                }
                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                return `
                        <div class="edit-delete-action">
                            <a class="me-2 p-2 cancel-application" data-applicationid="${row.application_id}">
                                <i data-feather="x" class="feather-x"></i>
                            </a>
                        </div>
                    `;
                            }
                        }
                    ],
                    "createdRow": function(row, data, dataIndex) {
                        $(row).find('td').eq(10).addClass('action-table-data');
                    },
                    "initComplete": function(settings, json) {
                        $('.dataTables_filter').appendTo('#tableSearch');
                        $('.dataTables_filter').appendTo('.search-input');
                        feather.replace();

                        $('.status_filter, .branch_filter, .country_filter').on('change', function() {
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