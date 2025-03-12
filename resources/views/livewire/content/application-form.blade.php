<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Application Form</h4>
            <h6>Review and update personal information, and upload the required documents.</h6>
        </div>
    </div>
    <div class="card mb-0">
        <form wire:submit.prevent="submit_application">
            @csrf
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
                                    <h4>Change Image</h4>
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
                                        <input type="text" class="form-control" placeholder="Enter first name"
                                            id="first_name" wire:model.lazy="first_name">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="middle_name">Middle
                                            Name</label>
                                        <input type="text" class="form-control" placeholder="Enter middle name"
                                            id="middle_name" wire:model.lazy="middle_name">
                                        @error('middle_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="last_name">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Enter last name"
                                            id="last_name" wire:model.lazy="last_name">
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
                                <input type="text" class="form-control" placeholder="e.g., Jr., Sr., III, Ph.D."
                                    id="suffix" wire:model.lazy="suffix">
                                @error('suffix')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" placeholder="e.g., name@mail.com"
                                    id="email" wire:model.lazy="email">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="contact_number">Contact
                                    Number</label>
                                <input type="text" id="contact_number" class="form-control"
                                    placeholder="e.g., +63 999 999 9999" wire:model.lazy="contact_number">
                                @error('contact_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Date of
                                    Birth</label>
                                <input type="date" class="form-control" wire:model="date_of_birth">
                                @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="gender">Gender</label>
                                <div wire:ignore>
                                    <select class="select" id="gender" name="gender" wire:model="gender">
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
                                <label class="form-label" for="citizenship">Citizenship</label>
                                <input type="text" class="form-control" placeholder="Enter citizenship"
                                    id="citizenship" wire:model.lazy="citizenship">
                                @error('citizenship')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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
                                        <input type="text" class="form-control" id="{{ $field }}"
                                            wire:model.lazy="{{ $field }}"
                                            placeholder="Enter your {{ $field }}">
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
                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Branch</h6>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <div wire:ignore>
                                    <select class="select" id="branch_id" name="branch_id" wire:model="branch_id">
                                        <option value="">Choose</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->branch_id }}">{{ $branch->municipality }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('branch_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-submit">Submit</button>
            </div>
        </form>

    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $(document).on('change', '[id]', handleInputChange);
            });

            function handleInputChange(e) {

                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);

                   
                }
            }
        </script>
    @endpush
</div>
