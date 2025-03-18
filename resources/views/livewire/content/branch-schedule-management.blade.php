<div class="modal fade" id="schedule-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-md custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">

                            @if ($submit_func == 'add-schedule')
                                <h4>Add Schedule</h4>
                            @else
                                <h4>Edit Schedule</h4>
                            @endif

                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <form wire:submit.prevent="submitSchedule">
                            @csrf
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="new-employee-field">
                                        <div class="card-title-head" wire:ignore>
                                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Schedule
                                                Information</h6>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label for="interview_date" class="form-label">Interview
                                                        Date</label>
                                                    <input type="date" class="form-control interviewDate"
                                                        wire:model="interview_date">

                                                    @error('interview_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="job_countries">Available
                                                        Slots</label>

                                                    <div class="product-quantity" wire:ignore>
                                                        <span class="quantity-btn">+<i data-feather="plus-circle"
                                                                class="plus-circle"></i></span>
                                                        <input type="numbers" class="quntity-input not_pass"
                                                            id="available_slots" wire:model.lazy="available_slots">
                                                        <span class="quantity-btn"><i data-feather="minus-circle"
                                                                class="feather-search"></i></span>
                                                    </div>

                                                    @error('available_slots')
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
                handleScheduleActions();
                initializeComponents();
            });

            function initializeComponents() {
                initSelect();
                updateTotalSchedules();
            }

            function updateTotalSchedules() {
                const totalSchedules = @js($total_schedules);
                $('.schedule_total').text(totalSchedules);
            }

            function handleScheduleActions() {
                $(document).on('change', '[id]', handleInputChange);
                $(document).on('click', '.add-schedule', openAddScheduleModal);
                $(document).on('click', '.edit-schedule', openEditScheduleModal);
            }

            function handleInputChange(e) {
                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);
                }
            }

            function openAddScheduleModal() {
                @this.set('submit_func', 'add-schedule');

                @this.call('resetFields').then(() => {
                    $('#schedule-modal').modal('show');
                });
            }

            const viewInterviewDate = function() {
                var interviewDate = @this.get('interview_date');

                var formattedDate = interviewDate.split(' ')[0]; // Extracts '2025-02-28'

                $('.interviewDate').val(formattedDate).change(); // Set value correctly

                console.log(formattedDate);
            }

            function openEditScheduleModal() {
                const scheduleId = $(this).data('scheduleid');

                @this.set('submit_func', 'edit-schedule');
                @this.call('getSchedule', scheduleId).then(() => {
                    initSelect();
                    viewInterviewDate();
                    $('#schedule-modal').modal('show');
                });
            }
        </script>
    @endpush
</div>