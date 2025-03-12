<div class="modal fade" id="set-interview-schedule-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Interview Schedule</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="setInterviewSchedule">
                    @csrf
                    <div class="mb-3">
                        <label for="interview_date" class="form-label">Interview Date</label>
                        <input type="date" id="interview_date" class="form-control" wire:model.lazy="interview_date">
                        @error('interview_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer-btn mb-4 mt-0">
                        <button type="button" class="btn btn-cancel me-2"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-submit">Set Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $(document).on('click', '.set-schedule', function() {
                    var application_id = $(this).data('applicationid');
                    console.log("Clicked Application ID:", application_id);

                    // Update Livewire component state
                    @this.set('application_id', application_id).then(() => {
                        $('#set-interview-schedule-modal').modal('show'); // Open the modal
                    });
                });
            });
        </script>
    @endpush

</div>
