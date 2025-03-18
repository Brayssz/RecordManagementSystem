<div class="modal fade" id="interview-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            <h4>Record Interview Details</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="submitBranchInterview">
                            @csrf
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="new-employee-field">
                                        <div class="card-title-head" wire:ignore>
                                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Interview
                                                Information</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="remarks">Interview Details</label>
                                                    <div>
                                                        <textarea rows="7" cols="5" class="form-control"
                                                            wire:model.lazy="remarks"
                                                            placeholder="Enter interview details"></textarea>
                                                    </div>
                                                    @error('remarks')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label" for="rating">Interview Rating</label>
                                                    <div class="product-quantity" wire:ignore>
                                                        <span class="quantity-btn">+<i data-feather="plus-circle"
                                                                class="plus-circle"></i></span>
                                                        <input type="number" class="quntity-input not_pass" id="rating"
                                                            wire:model.lazy="rating">
                                                        <span class="quantity-btn"><i data-feather="minus-circle"
                                                                class="feather-search"></i></span>
                                                    </div>
                                                    @error('rating')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer-btn mb-4 mt-0">
                                <button type="button" class="btn btn-cancel me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-submit btn-interview">Submit</button>
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
                handleInterviewActions();
                initializeComponents();
            });

            function initializeComponents() {
                // Initialize any components if needed
            }

            $('.btn-interview').on('click', function() {

                confirmAlert("Record Interview?", "Are you sure you want to record this interview?", function() {
                    recordInterview();
                }, 'Record');
            });

            const recordInterview = () => {
                @this.call('submitBranchInterview');
            }



            function handleInterviewActions() {
                $(document).on('change', '[id]', handleInputChange);
                $(document).on('click', '.record_interview', openInterviewModal);
            }

            function handleInputChange(e) {
                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id.split(" ")[0];
                    const value = $(e.target).val();
                    @this.set(property, value);
                }
            }

            function openInterviewModal() {
                const interview_id = $(this).data('interviewid');
                const application_id = $(this).data('applicationid');

                @this.set('application_id', application_id);
                console.log(application_id);
                console.log(interview_id);

                if (interview_id === null) {
                    $('#interview-modal').modal('show');
                } 
                // else {
                //     @this.set('b_interview_id', interview_id);

                //     @this.call('getBranchInterview', interview_id).then(() => {
                //         $('#interview-modal').modal('show');
                //     });
                // }
            }
            $(document).on('hidden.bs.modal', '#interview-modal', function () {
                @this.call('resetFields');
            });


        </script>
    @endpush
</div>