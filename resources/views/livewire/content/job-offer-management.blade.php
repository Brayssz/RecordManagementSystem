<div class="modal fade" id="add-job-offer-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-xl custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            @if ($submit_func == 'add-job-offer')
                                <h4>Add Job Offer</h4>
                            @else
                                <h4>Edit Job Offer</h4>
                            @endif
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="submit_job_offer">
                            @csrf
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="new-job-offer-field">
                                        <div class="card-title-head" wire:ignore>
                                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Job Offer
                                                Information</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="employer_id">Employer</label>
                                                    <div wire:ignore>
                                                        <select class="select" id="employer_id" name="employer_id"
                                                            wire:model="employer_id">
                                                            <option value="">Choose</option>
                                                            @foreach ($employers as $employer)
                                                                <option value="{{ $employer->employer_id }}">
                                                                    {{ $employer->company_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('employer_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="country">Country</label>
                                                    <div wire:ignore>
                                                        <select class="select" id="country" name="country"
                                                            wire:model="country">
                                                            <option value="">Choose</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country }}">{{ $country }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    @error('country')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="job_title">Job Title</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter job title" id="job_title"
                                                        wire:model.lazy="job_title">
                                                    @error('job_title')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="job_title">Salary</label>
                                                    <span class="text-muted">(Salary range is from 10,000 to
                                                        500,000)</span>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="mb-3">
                                                                <input type="number"
                                                                    class="form-control no-arrows not_pass"
                                                                    placeholder="From" id="range_from"
                                                                    wire:model.lazy="range_from">
                                                                @error('range_from')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <div class="mb-3">
                                                                <input type="number"
                                                                    class="form-control no-arrows not_pass"
                                                                    placeholder="To" id="range_to"
                                                                    wire:model.lazy="range_to">
                                                                @error('range_to')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="job_description">Job
                                                        Description</label>
                                                    <textarea class="form-control" placeholder="Enter job description" id="job_description"
                                                        wire:model.lazy="job_description"></textarea>
                                                    @error('job_description')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="job_qualifications">Job
                                                        Qualifications</label>
                                                    <textarea class="form-control" placeholder="Enter job qualifications" id="job_qualifications"
                                                        wire:model.lazy="job_qualifications"></textarea>
                                                    @error('job_qualifications')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="available_slots">Available
                                                        Slots</label>
                                                    <input type="number" class="form-control"
                                                        placeholder="Enter available slots" id="available_slots"
                                                        wire:model.lazy="available_slots">
                                                    @error('available_slots')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if ($submit_func == 'edit-job-offer')
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="status">Status</label>
                                                        <div wire:ignore>
                                                            <select class="select" id="status" name="status"
                                                                wire:model="status">
                                                                <option value="">Choose</option>
                                                                <option value="Active">Active</option>
                                                                <option value="Inactive">Inactive</option>
                                                            </select>
                                                        </div>
                                                        @error('status')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer-btn mb-4 mt-0">
                                <button type="button" class="btn btn-cancel me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                initializeComponents();
                handleJobOfferActions();
            });

            function initSelect() {
                $('.select').select2({
                    minimumResultsForSearch: -1,
                    width: '100%'
                });
            }

            function initializeComponents() {
                updateTotalJobOffers();
            }

            function updateTotalJobOffers() {
                const totalJobOffers = @js($total_job_offers);
                $('.job_offer_total').text(totalJobOffers);
            }

            function handleJobOfferActions() {
                $(document).on('change', '[id]', handleInputChange);
                $(document).on('click', '.add-job-offer', openAddJobOfferModal);
                $(document).on('click', '.edit-job-offer', openEditJobOfferModal);
            }

            function handleInputChange(e) {
                if ($(e.target).is('select')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);
                }
            }

            function openAddJobOfferModal() {
                @this.set('submit_func', 'add-job-offer');

                @this.call('resetFields').then(() => {
                    initSelectVal("");
                    $('#add-job-offer-modal').modal('show');
                });
            }

            function openEditJobOfferModal() {
                const jobId = $(this).data('jobid');

                @this.set('submit_func', 'edit-job-offer');
                @this.call('getJobOffer', jobId).then(() => {
                    populateEditForm();
                    $('#add-job-offer-modal').modal('show');
                });
            }

            function initSelectVal(status) {
                $('#status').val(status).change();
            }

            function populateEditForm() {
                const status = @this.get('status');

                initSelect();
                initSelectVal(status);
            }
        </script>
    @endpush
</div>