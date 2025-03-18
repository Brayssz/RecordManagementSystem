<div class="modal fade" id="application-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-xl custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            <h4>View Application</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="new-employee-field">
                                    <div class="card-title-head" wire:ignore>
                                        <h6><span><i data-feather="info" class="feather-edit"></i></span>Personal
                                            Information</h6>
                                    </div>
                                    <div class="profile-pic-upload" x-data="{ photoPreview: @entangle('photoPreview'), photoName: '' }">
                                        <div class="profile-pic">
                                            <template x-if="photoPreview">
                                                <span><img :src="photoPreview" alt=""></span>
                                            </template>
                                            <template x-if="!photoPreview">
                                                <span><i class="plus-down-add fa fa-plus"></i> Profile Photo</span>
                                            </template>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10 col-md-6">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="first_name">First Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter first name" id="first_name"
                                                            wire:model.lazy="first_name" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="middle_name">Middle Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter middle name" id="middle_name"
                                                            wire:model.lazy="middle_name" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="last_name">Last Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter last name" id="last_name"
                                                            wire:model.lazy="last_name" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="suffix">Suffix</label>
                                                <input type="text" class="form-control"
                                                    placeholder="e.g., Jr., Sr., III, Ph.D." id="suffix"
                                                    wire:model.lazy="suffix" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" class="form-control"
                                                    placeholder="e.g., name@mail.com" id="email"
                                                    wire:model.lazy="email" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="contact_number">Contact Number</label>
                                                <input type="text" id="contact_number" class="form-control"
                                                    placeholder="e.g., +63 999 999 9999"
                                                    wire:model.lazy="contact_number" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" wire:model="date_of_birth"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="gender">Gender</label>
                                                <input type="gender" class="form-control"
                                                    placeholder="No Gender" id="gender"
                                                    wire:model.lazy="gender" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="citizenship">Citizenship</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter citizenship" id="citizenship"
                                                    wire:model.lazy="citizenship" readonly>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="marital_status">Marital Status</label>
                                                <input type="text" class="form-control"
                                                    placeholder="Enter marital status" id="marital_status"
                                                    wire:model.lazy="marital_status" readonly>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="other-info">
                                        <div class="card-title-head" wire:ignore>
                                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Other
                                                Information</h6>
                                        </div>
                                        <div class="row">
                                            @foreach (['region', 'province', 'municipality', 'barangay', 'street', 'postal_code'] as $field)
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                        <input type="text" class="form-control"
                                                            id="{{ $field }}"
                                                            wire:model.lazy="{{ $field }}"
                                                            placeholder="Enter your {{ $field }}" readonly>
                                                        @error($field)
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="pass-info">
                                        <div class="card-title-head" wire:ignore>
                                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Other Information
                                            </h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="branch">Branch</label>
                                                    <input type="branch" class="form-control"
                                                        placeholder="No Branch" id="branch"
                                                        wire:model.lazy="branch" readonly>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer-btn mb-4 mt-0">
                            <button type="button" class="btn btn-submit" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                handleApplicantActions();
            });


            function handleApplicantActions() {
                $(document).on('click', '.view-application', openEditApplicantModal);
            }

            function openEditApplicantModal() {
                const applicationId = $(this).data('applicationid');

                @this.call('getApplication', applicationId).then(() => {
                    $('#application-modal').modal('show');
                });
            }
           
        </script>
    @endpush
</div>
