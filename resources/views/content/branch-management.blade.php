@extends('layout.app-layout')

@section('title', 'Branch Management')

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Branch</h4>
                    <h6>Manage branches</h6>
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
                <a class="btn btn-added add-branch"><i data-feather="plus-circle" class="me-2"></i>Add New
                    Branch</a>
            </div>
        </div>
        <!-- /product list -->
        <div class="card table-list-card">
            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new d-flex ">
                    <div class="search-set mb-0 d-flex w-100 justify-content-start">
                        <div class="total-employees text-left">
                            <h6><i data-feather="home" class="feather-user"></i>Total Branches<span
                                    class="branch_total">21</span></h6>
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
                    <table class="table branch-table pb-3">
                        <thead>
                            <tr>
                                <th>Branch Name</th>
                                <th>Contact Number</th>
                                <th>Email Address</th>
                                <th>Address</th>
                                <th>Status</th>
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
    @livewire('content.branch-management')

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


            if ($('.branch-table').length > 0) {
                var table = $('.branch-table').DataTable({
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
                        "url": "/branches",
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
                            "data": "municipality"
                        },
                        {
                            "data": "contact_number"
                        },
                        {
                            "data": "email"
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return [
                                    row.region,
                                    row.province,
                                    row.municipality,
                                    row.barangay,
                                    row.street,
                                    row.postal_code
                                ].filter(Boolean).join(', ');
                            },
                            title: 'Address'
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
                                        <a class="me-2 p-2 edit-branch" data-branchid="${row.branch_id}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                    </div>
                                `;
                            }
                        }
                    ],
                    "createdRow": function(row, data, dataIndex) {
                        $(row).find('td').eq(5).addClass('action-table-data');
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

        function initSelect() {
            $('.select').select2({
                minimumResultsForSearch: -1,
                width: '100%'
            });
        }
    </script>
@endpush