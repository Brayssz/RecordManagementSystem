<div>

    <div class="modal fade" id="add-employer-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                @if ($submit_func == 'add-employer')
                                    <h4>Add Employer</h4>
                                @else
                                    <h4>Edit Employer</h4>
                                @endif
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="submit_employer">
                                @csrf
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="new-employee-field">
                                            <div class="card-title-head" wire:ignore>
                                                <h6><span><i data-feather="info"
                                                            class="feather-edit"></i></span>Personal
                                                    Information</h6>
                                            </div>
                                            <div class="profile-pic-upload"
                                                x-data="{ photoPreview: @entangle('photoPreview'), photoName: '' }">
                                                <div class="profile-pic">
                                                    <template x-if="photoPreview">
                                                        <span><img :src="photoPreview" alt=""></span>
                                                    </template>
                                                    <template x-if="!photoPreview">
                                                        <span><i class="plus-down-add fa fa-plus"></i> Profile
                                                            Photo</span>
                                                    </template>
                                                </div>
                                                <div class="input-blocks mb-0">
                                                    <div class="image-upload mb-0">
                                                        <input type="file" wire:model.live="photo" x-ref="photo"
                                                            x-on:change="
                                                                photoName = $refs.photo.files[0].name;
                                                                const reader = new FileReader();
                                                                reader.onload = (e) => {
                                                                    photoPreview = e.target.result;
                                                                };
                                                                reader.readAsDataURL($refs.photo.files[0]);
                                                            ">
                                                        <div class="image-uploads">
                                                            <h4>Upload Image</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-10 col-md-6">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="first_name">First
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter first name" id="first_name"
                                                                    wire:model.lazy="first_name">
                                                                @error('first_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="middle_name">Middle
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter middle name" id="middle_name"
                                                                    wire:model.lazy="middle_name">
                                                                @error('middle_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="last_name">Last
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter last name" id="last_name"
                                                                    wire:model.lazy="last_name">
                                                                @error('last_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="suffix">Suffix</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="e.g., Jr., Sr., III, Ph.D." id="suffix"
                                                            wire:model.lazy="suffix">
                                                        @error('suffix')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="email">Email</label>
                                                        <input type="email" class="form-control"
                                                            placeholder="e.g., name@mail.com" id="email"
                                                            wire:model.lazy="email">
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="contact_number">Contact
                                                            Number</label>
                                                        <input type="text" id="contact_number"
                                                            class="form-control phMobile not_pass"
                                                            placeholder="e.g., +63 999 999 9999"
                                                            wire:model.lazy="contact_number">
                                                        @error('contact_number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="gender">Gender</label>
                                                        <div wire:ignore>
                                                            <select class="select" id="gender" name="gender"
                                                                wire:model="gender">
                                                                <option value="">Choose</option>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                                <option value="Others">Others..</option>
                                                            </select>
                                                        </div>
                                                        @error('gender')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="industry">Industry</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter industry" id="industry"
                                                            wire:model.lazy="industry">
                                                        @error('industry')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="company_name">Company
                                                            Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter company name" id="company_name"
                                                            wire:model.lazy="company_name">
                                                        @error('company_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @if ($submit_func == 'edit-employer')
                                                    <div class="col-lg-4 col-md-6 status-group">
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

    </div>


    <div class="modal fade" id="view-employer-modal" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-xl custom-modal-two">
            <div class="modal-content">
                <div class="page-wrapper-new p-0">
                    <div class="content">
                        <div class="modal-header border-0 custom-modal-header">
                            <div class="page-title">
                                <h4>View Employer</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form wire:submit.prevent="submit_employer">
                                @csrf
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="new-employee-field">
                                            <div class="card-title-head" wire:ignore>
                                                <h6><span><i data-feather="info"
                                                            class="feather-edit"></i></span>Personal
                                                    Information</h6>
                                            </div>
                                            <div class="profile-pic-upload"
                                                x-data="{ photoPreview: @entangle('photoPreview'), photoName: '' }">
                                                <div class="profile-pic">
                                                    <template x-if="photoPreview">
                                                        <span><img :src="photoPreview" alt=""></span>
                                                    </template>
                                                    <template x-if="!photoPreview">
                                                        <span><img src="/img/no-profile.png" alt=""></span>
                                                    </template>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-10 col-md-6">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="first_name">First
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="No first name" id="first_name"
                                                                    wire:model.lazy="first_name" readonly>
                                                                @error('first_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="middle_name">Middle
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="No middle name" id="middle_name"
                                                                    wire:model.lazy="middle_name" readonly>
                                                                @error('middle_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="last_name">Last
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="No last name" id="last_name"
                                                                    wire:model.lazy="last_name" readonly>
                                                                @error('last_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="suffix">Suffix</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="No suffix" id="suffix"
                                                            wire:model.lazy="suffix" readonly>
                                                        @error('suffix')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="email">Email</label>
                                                        <input type="email" class="form-control"
                                                            placeholder="No email" id="email"
                                                            wire:model.lazy="email" readonly>
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="contact_number">Contact
                                                            Number</label>
                                                        <input type="text" id="contact_number"
                                                            class="form-control phMobile not_pass"
                                                            placeholder="No contact number"
                                                            wire:model.lazy="contact_number" readonly>
                                                        @error('contact_number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="gender">Gender</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="No gender" id="gender"
                                                            wire:model.lazy="gender" readonly>
                                                        @error('gender')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="industry">Industry</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="No industry" id="industry"
                                                            wire:model.lazy="industry" readonly>
                                                        @error('industry')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="company_name">Company
                                                            Name</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="No company name" id="company_name"
                                                            wire:model.lazy="company_name" readonly>
                                                        @error('company_name')
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
                                        data-bs-dismiss="modal">Close</button>
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
                initializeComponents();
                handleEmployerActions();
            });

            function initSelect() {
                $('.select').select2({
                    minimumResultsForSearch: -1,
                    width: '100%'
                });
            }

            function initializeComponents() {
                updateTotalEmployers();
            }

            function updateTotalEmployers() {
                const totalEmployers = @js($total_employer);
                $('.employer_total').text(totalEmployers);
            }

            function handleEmployerActions() {
                $(document).on('change', '[id]', handleInputChange);
                $(document).on('click', '.add-employer', openAddEmployerModal);
                $(document).on('click', '.edit-employer', openEditEmployerModal);
                $(document).on('click', '.view-employer', openViewEmployerModal);
            }

            const openViewEmployerModal = function() {
                const employerId = $(this).data('employerid');
                console.log(employerId);
                @this.call('getEmployer', employerId).then(() => {
                    $('#view-employer-modal').modal('show');
                });
            };

            function handleInputChange(e) {
                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);
                }
            }

            function openAddEmployerModal() {
                console.log("Press");
                @this.set('submit_func', 'add-employer');

                @this.call('resetFields').then(() => {
                    initSelectVal("");
                    $('#add-employer-modal').modal('show');
                });
            }

            function openEditEmployerModal() {
                const employerId = $(this).data('employerid');

                @this.set('submit_func', 'edit-employer');
                @this.call('getEmployer', employerId).then(() => {
                    populateEditForm();
                    $('#add-employer-modal').modal('show');
                });
            }

            function initSelectVal(gender) {
                $('#gender').val(gender).change();
            }

            function populateEditForm() {
                const gender = @this.get('gender');

                initSelect();
                initSelectVal(gender);
            }
        </script>
    @endpush
</div>