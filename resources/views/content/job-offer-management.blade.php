@extends('layout.app-layout')

@section('title', 'Job Offer Management')

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Job Offers</h4>
                    <h6>Manage your job offers</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                            class="feather-rotate-ccw"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            data-feather="chevron-up" class="feather-chevron-up"></i></a>
                </li>
            </ul>
            <div class="page-btn">
                <a class="btn btn-added add-job-offer"><i data-feather="plus-circle" class="me-2"></i>Add New
                    Job Offer</a>
            </div>
        </div>
        <!-- /job offer list -->
        <div class="card table-list-card">
            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new d-flex ">
                    <div class="search-set mb-0 d-flex w-100 justify-content-start">
                        <div class="total-employees text-left">
                            <h6><i data-feather="briefcase" class="feather-briefcase"></i>Total Job Offers <span
                                    class="job_offer_total">21</span></h6>
                        </div>
                        <div class="search-input text-left">
                            <a href="" class="btn btn-searchset"><i data-feather="search"
                                    class="feather-search"></i></a>
                        </div>

                        <div class="row mt-sm-3 mt-xs-3 mt-lg-0 w-sm-100 flex-grow-1">
                            <div class="col-lg-2 col-sm-12">
                                <div class="form-group ">
                                    <select class="select status_filter form-control">
                                        <option value="">Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table job-offer-table pb-3">
                        <thead>
                            <tr>
                                <th>Job Title</th>
                                <th>Employer</th>
                                <th>Country</th>
                                <th>Salary</th>
                                <th>Available Slots</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @livewire('content.job-offer-management')

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            @if (session('message'))
                toastr.success("{{ session('message') }}", "Success", {
                    closeButton: true,
                    progressBar: true,
                });
            @endif


            if ($('.job-offer-table').length > 0) {
                var table = $('.job-offer-table').DataTable({
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
                        "url": "/jobs",
                        "type": "GET",
                        "headers": {
                            "Accept": "application/json"
                        },
                        "data": function(d) {
                            d.status = $('.status_filter').val();
                        },
                        "dataSrc": "data"
                    },
                    "columns": [
                        {
                            "data": "job_title"
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                let avatarSrc = 'assets/img/no-profile.png';
                                if (row.employer.profile_photo_path) {
                                    avatarSrc = `/storage/${row.employer.profile_photo_path}`;
                                    return `
                                            <div class="userimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="${avatarSrc}" alt="product" loading="lazy">
                                                </a>
                                                <div>
                                                    <a href="javascript:void(0);">${row.employer.company_name}</a>
                                                    <span class="emp-team">${row.employer.first_name || "Unknown"} ${row.employer.middle_name ? `${row.employer.middle_name} ` : ""}${row.employer.last_name || "User"}</span>
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

                                    const firstLetter = (row.employer.first_name ? row.employer.first_name.charAt(0).toUpperCase() : 'U');
                                    const bgColor = colors[firstLetter] || 'bg-secondary';

                                    return `
                                            <div class="userimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <span class="avatar ${bgColor} avatar-rounded">
                                                        <span class="avatar-title">${row.employer.first_name ? row.employer.first_name.charAt(0).toUpperCase() : 'U'}${row.employer.last_name ? row.employer.last_name.charAt(0).toUpperCase() : 'U'}</span>
                                                    </span>
                                                </a>
                                                <div>
                                                     <a href="javascript:void(0);">${row.employer.company_name}</a>
                                                    <span class="emp-team">${row.employer.first_name || "Unknown"} ${row.employer.middle_name ? `${row.employer.middle_name} ` : ""}${row.employer.last_name || "User"}</span>
                                                </div>
                                            </div>
                                        `;
                                }
                            }
                        },
                        {
                            "data": "country"
                        },
                        {
                            "data": "salary"
                        },
                        {
                            "data": "available_slots"
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                if (row.status === "Active") {
                                    return `<span class="badge badge-linesuccess">Active</span>`;
                                } else {
                                    return `<span class="badge badge-linedanger">Inactive</span>`;
                                }
                            }
                        },
                        {
                            "data": null,
                            "render": function(data, type, row) {
                                return `
                        <div class="edit-delete-action">
                            <a class="me-2 p-2 edit-job-offer" data-jobid="${row.job_id}">
                                <i data-feather="edit" class="feather-edit"></i>
                            </a>
                        </div>
                    `;
                            }
                        }
                    ],
                    "createdRow": function(row, data, dataIndex) {
                        $(row).find('td').eq(6).addClass('action-table-data');
                    },
                    "initComplete": function(settings, json) {
                        $('.dataTables_filter').appendTo('#tableSearch');
                        $('.dataTables_filter').appendTo('.search-input');
                        feather.replace();

                        $('.status_filter').on('change', function() {
                            table.draw();
                        });
                    },
                    "drawCallback": function(settings) {
                        feather.replace();
                    },
                });
            }
        });
    </script>
@endpush