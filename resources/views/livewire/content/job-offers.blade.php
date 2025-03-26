<div>
    <div class="content">

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Job Offers</h4>
                    <h6>Explore our latest overseas job offers and apply for the position that suits you best. We are
                        excited to have you join our company!</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh" class="reload_btn"><i
                            data-feather="rotate-ccw" class="feather-rotate-ccw"></i></a>
                </li>

            </ul>
        </div>

        <div class="card table-list-card border-0">
            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new d-flex mb-1">
                    <div class="search-set mb-0 d-flex w-100 justify-content-start">

                        <div class="search-set mb-0">
                            <div class="search-input">
                                <a class="btn btn-searchset"><i data-feather="search" class="feather-search"></i></a>
                                <input id="searchInput" type="search" class="form-control"
                                    placeholder="Search Job Offers">
                            </div>

                        </div>
                        
                    </div>
                </div>

                <div id="jobOffersContainer" class="row p-4"></div>

                <div id="paginationContainer" class="px-4 mb-5"></div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                getJobOffers();
            });

            const getJobOffers = function(page = 1, searchQuery = '') {
                @this.call('getJobOffers', page, searchQuery).then(jobOffers => {
                    console.log(jobOffers);

                    const $container = $('#jobOffersContainer');
                    $container.empty(); 

                    jobOffers.original.data.forEach(job => {

                        const timeAgo = moment(job.created_at).fromNow();

                        const jobCard = `
                            <div class="col-lg-4 col-md-12">
                                <div class="card" style="height: 300px"> 
                                    <div class="card-header border-bottom-0">
                                        <div class="d-flex align-items-center w-100 justify-content-between">
                                            <div class="">
                                                <div class="fs-17 fw-bold">${job.job_title}</div>
                                                <p class="mb-0 text-muted font-weight-bold fs-12">${job.employer.company_name}</p>
                                                <p class="mb-0 text-muted fs-12">${timeAgo}</p>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <a href="javascript:void(0);" class="btn btn-primary apply-job" data-jobid="${job.job_id}">Apply Now</a>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <span class="badge bg-outline-info d-inline-flex align-items-center">
                                                <span class="badge-label">${job.country}</span>
                                                <span class="ms-1" data-feather="map-pin" style="height:12px;width:12px;"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body px-3 pb-3 mb-4 card-body-application" style="max-height: 250px; overflow-y: auto;">
                                       <div class="d-flex align-items-center">
                                            <div class="fs-14 fw-semibold text-muted me-2">Salary:</div>
                                           <p class="text-muted mb-0">
                                                ₱${job.salary.split('-')[0]} - ₱${job.salary.split('-')[1]}
                                            </p>
                                        </div>
                                        <div class="mt-3">
                                            <p class="text-muted">${job.job_description}</p>
                                        </div>
                                        <div class="fs-14 fw-semibold text-muted mt-3">Job qualification</div>
                                        <p class="text-muted">${job.job_qualifications}</p>
                                    </div>
                                </div>
                            </div>
                        `;

                        $container.append(jobCard);
                    });

                    const $paginationContainer = $('#paginationContainer');
                    $paginationContainer.empty();

                    let paginationHTML = `
                        <nav aria-label="Page navigation" class="pagination-style-3 d-flex justify-content-center">
                            <ul class="pagination mb-0 flex-wrap">
                    `;

                    if (jobOffers.original.prev_page_url) {
                        paginationHTML += `
                            <li class="page-item">
                                <a class="page-link" href="javascript:void(0);" onclick="getJobOffers(${jobOffers.original.current_page - 1}, '${searchQuery}')">
                                    Prev
                                </a>
                            </li>
                        `;
                    } else {
                        paginationHTML += `
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0);">Prev</a>
                            </li>
                        `;
                    }

                    for (let i = 1; i <= jobOffers.original.last_page; i++) {
                        if (i === jobOffers.original.current_page) {
                            paginationHTML +=
                                `<li class="page-item active"><a class="page-link" href="javascript:void(0);">${i}</a></li>`;
                        } else if (i === 1 || i === jobOffers.original.last_page || (i >= jobOffers.original
                                .current_page - 1 && i <=
                                jobOffers.original.current_page + 1)) {
                            paginationHTML +=
                                `<li class="page-item"><a class="page-link" href="javascript:void(0);" onclick="getJobOffers(${i}, '${searchQuery}')">${i}</a></li>`;
                        } else if (i === jobOffers.original.current_page - 2 || i === jobOffers.original
                            .current_page + 2) {
                            paginationHTML += `
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                </li>
                            `;
                        }
                    }

                    // Next Button
                    if (jobOffers.original.next_page_url) {
                        paginationHTML += `
                            <li class="page-item">
                                <a class="page-link text-primary" href="javascript:void(0);" onclick="getJobOffers(${jobOffers.original.current_page + 1}, '${searchQuery}')">
                                    Next
                                </a>
                            </li>
                        `;
                    } else {
                        paginationHTML += `
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0);">Next</a>
                            </li>
                        `;
                    }

                    paginationHTML += `</ul></nav>`;
                    $paginationContainer.append(paginationHTML);

                    feather.replace();
                });
            };

            $('#searchInput').on('input', function() {
                const searchQuery = $(this).val().trim()
                const country_id = $('.country_filter').val().trim();
                getJobOffers(1, searchQuery); 
            });

            $(document).on('click', '.apply-job', function() {
                const jobId = $(this).data('jobid');

                @this.call('checkExistingApplication').then(response => {
                    if (response.status) {
                        messageAlert('Warning', response.message);
                        getJobOffers();
                    } else {
                        const url = `{{ url('/apply') }}?job_id=${jobId}`;
                        window.location.href = url;
                    }
                });
            });
        </script>
    @endpush
</div>
