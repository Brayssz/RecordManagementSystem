@extends('layout.app-layout')

@section('title', 'Scheduled Interviews')

@section('content')

    <div class="content">

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Scheduled Interviews</h4>
                    <h6>View scheduled interviews and record interview details for the applicant.</h6>
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


                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table interview-application-table pb-3">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Applicant</th>
                                <th>Job</th>
                                <th>Country</th>
                                <th class="no-sort">Action</th>
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
    @livewire('content.record-branch-interview')

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

            if ($('.interview-application-table').length > 0) {
                var table = $('.interview-application-table').DataTable({
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
                        "url": "/scheduled-branch-interviews",
                        "type": "GET",
                        "headers": {
                            "Accept": "application/json"
                        },
                        "data": function(d) {
                            d.status = $('.status_filter').val();
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
                            "data": null,
                            "render": function(data, type, row) {
                                return `
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2 record_interview" data-interviewid="${row.branch_interview.b_interview_id}">
                                        <i data-feather="file-text" class="feather-file-text"></i>
                                    </a>
                                </div>
                            `;
                            }
                        }
                    ],
                    "createdRow": function(row, data, dataIndex) {
                        $(row).find('td').eq(3).addClass('action-table-data');
                    },
                    "initComplete": function(settings, json) {
                        $('.dataTables_filter').appendTo('#tableSearch');
                        $('.dataTables_filter').appendTo('.search-input');
                        feather.replace();

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

    </script>
@endpush
