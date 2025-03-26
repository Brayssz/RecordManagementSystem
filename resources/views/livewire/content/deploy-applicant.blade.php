<div>
    <div class="modal fade" id="deploy-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Deploy Applicant</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body ">
                            <form wire:submit.prevent="deployApplicant">
                                @csrf
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="new-employee-field">
                                            <div class="card-title-head" wire:ignore>
                                                <h6><span><i data-feather="info"
                                                            class="feather-edit"></i></span>Schedule
                                                    Information</h6>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="mb-3">
                                                        <label for="schedule_departure_date"
                                                            class="form-label">Departure Date Schedule</label>
                                                        <input type="date" class="form-control"
                                                            wire:model="schedule_departure_date">

                                                        @error('schedule_departure_date')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer-btn mb-4 mt-0">
                                    <button type="button" class="btn btn-cancel me-2 "
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-submit btn-deploy">Deploy</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reschedule-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>Reschedule Departure</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body ">
                            <form wire:submit.prevent="rescheduleDeparture">
                                @csrf
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="new-employee-field">
                                            <div class="card-title-head" wire:ignore>
                                                <h6><span><i data-feather="info"
                                                            class="feather-edit"></i></span>Schedule
                                                    Information</h6>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="mb-3">
                                                        <label for="actual_departure_date" class="form-label">Actual
                                                            Departure Date</label>
                                                        <input type="date" class="form-control"
                                                            wire:model="actual_departure_date">

                                                        @error('actual_departure_date')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-md-12">
                                                    <div class="mb-3">
                                                        <label for="schedule_departure_date"
                                                            class="form-label">Departure Date Schedule</label>
                                                        <input type="date" class="form-control"
                                                            wire:model="schedule_departure_date">

                                                        @error('schedule_departure_date')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="mb-3">
                                                        <label for="end_contract_date"
                                                            class="form-label">End Contract Date</label>
                                                        <input type="date" class="form-control"
                                                            wire:model="end_contract_date">

                                                        @error('end_contract_date')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer-btn mb-4 mt-0">
                                    <button type="button" class="btn btn-cancel me-2 "
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-submit btn-reschedule">Reschedule</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                handleScheduleActions();
                initializeComponents();
            });

            function initializeComponents() {
                initSelect();
            }


            function handleScheduleActions() {
                $(document).on('change', '[id]', handleInputChange);
                $(document).on('click', '.deploy', openDeployModal);
                $(document).on('click', '.reschedule', openRescheduleModal);
            }

            function handleInputChange(e) {
                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);
                }
            }

            function openDeployModal() {
                const application_id = $(this).data('applicationid');

                @this.set('application_id', application_id);

                $('#deploy-modal').modal('show');
            }

            $('.btn-deploy').click(function () {
                confirmAlert("Deploy Applicant?", "Are you sure you want to deploy this applicant?", function () {
                    submitDeploy();
                }, 'Deploy');
            });

            $('.btn-reschedule').click(function () {


                confirmAlert("Reschedule Departure?", "Are you sure you want to reschedule this applicant's departure?",
                    function () {
                        submitReschedule();
                    }, 'Reschedule');
            });

            const submitDeploy = () => {
                @this.call('deployApplicant');
            }

            const submitReschedule = () => {
                @this.call('rescheduleDeparture');
            }

            function openRescheduleModal() {
                const application_id = $(this).data('applicationid');

                @this.set('application_id', application_id);

                const deployment_id = $(this).data('deploymentid');

                @this.set('deployment_id', deployment_id);

                @this.call('getDeployment').then(() => {
                    $('#reschedule-modal').modal('show');
                });

            }
        </script>
    @endpush
</div>