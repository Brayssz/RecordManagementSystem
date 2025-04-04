<div class="modal fade" id="add-applicant-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-xl custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            @if ($submit_func == 'add-applicant')
                                <h4>Add Applicant</h4>
                            @else
                                <h4>Edit Applicant</h4>
                            @endif
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="submit_applicant">
                            @csrf
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
                                                    <span>Passport Size<br></span>
                                                    
                                                </template>
                                            </div>
                                            <div class="input-blocks mb-0">
                                                <div class="image-upload mb-0">
                                                    <input type="file" wire:model.live="photo" x-ref="photo"
                                                        x-on:change="
                                                            const file = $refs.photo.files[0];
                                                            const img = new Image();
                                                            img.onload = () => {
                                                                if (img.width !== img.height) {
                                                                    messageAlert('Invalid Image', 'Please upload an image with equal dimesion.');
                                                                    $refs.photo.value = '';
                                                                } else {
                                                                    photoName = file.name;
                                                                    const reader = new FileReader();
                                                                    reader.onload = (e) => {
                                                                        photoPreview = e.target.result;
                                                                    };
                                                                    reader.readAsDataURL(file);
                                                                }
                                                            };
                                                            img.src = URL.createObjectURL(file);
                                                        ">
                                                    <div class="image-uploads">
                                                        <h4>Upload Image</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @error('photo')
                                            <div class="col-12 alert alert-danger d-flex align-items-center" role="alert">
                                                <i class="feather-alert-octagon flex-shrink-0 me-2"></i>
                                                <div>
                                                    {{ $message }}
                                                </div>
                                            </div>
                                        @enderror
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
                                                            <label class="form-label" for="last_name">Last Name</label>
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
                                                        class="form-control phMobile"
                                                        placeholder="e.g., +63 999 999 9999"
                                                        wire:model.lazy="contact_number">
                                                    @error('contact_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label for="date_of_birth" class="form-label">Date of
                                                        Birth</label>
                                                    <input type="date" class="form-control"
                                                        wire:model="date_of_birth">
                                                    @error('date_of_birth')
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
                                                    <label class="form-label" for="citizenship">Citizenship</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter citizenship" id="citizenship"
                                                        wire:model.lazy="citizenship">
                                                    @error('citizenship')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="marital_status">Marital
                                                        Status</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter marital status" id="marital_status"
                                                        wire:model.lazy="marital_status">
                                                    @error('marital_status')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if ($submit_func == 'edit-applicant')
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

                                        <div class="other-info">
                                            <div class="card-title-head" wire:ignore>
                                                <h6><span><i data-feather="info" class="feather-edit"></i></span>Other
                                                    Information</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3" wire:ignore>
                                                        <label class="form-label" for="region">Region</label>
                                                        <select class="form-select" id="region" name="region"
                                                            wire:model.lazy="region" autofocus>
                                                            <option value="">Select Region</option>
                                                            @foreach ($locationData as $region => $data)
                                                                <option value="{{ $region }}">
                                                                    {{ $data['region_name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('region')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3" wire:ignore>
                                                        <label class="form-label" for="province">Province</label>
                                                        <select class="form-select" id="province" name="province"
                                                            wire:model.lazy="province" disabled>
                                                            <option value="">Select Province</option>
                                                        </select>
                                                        @error('province')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3" wire:ignore>
                                                        <label class="form-label"
                                                            for="municipality">Municipality</label>
                                                        <select class="form-select" id="municipality"
                                                            name="municipality" wire:model.lazy="municipality"
                                                            disabled>
                                                            <option value="">Select Municipality</option>
                                                        </select>
                                                        @error('municipality')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3" wire:ignore>
                                                        <label class="form-label" for="barangay">Barangay</label>
                                                        <select class="form-select" id="barangay" name="barangay"
                                                            wire:model.lazy="barangay" disabled>
                                                            <option value="">Select Barangay</option>
                                                        </select>
                                                        @error('barangay')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="street">Street</label>
                                                        <input type="text" class="form-control" id="street"
                                                            name="street" wire:model.lazy="street" autofocus
                                                            autocomplete="street" placeholder="Enter your street">
                                                        @error('street')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postal_code">Postal
                                                            Code</label>
                                                        <input type="text" class="form-control" id="postal_code"
                                                            name="postal_code" wire:model.lazy="postal_code" autofocus
                                                            autocomplete="postal_code"
                                                            placeholder="Enter your postal code">
                                                        @error('postal_code')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pass-info">
                                            <div class="card-title-head" wire:ignore>
                                                <h6><span><i data-feather="info"
                                                            class="feather-edit"></i></span>Password</h6>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 input-blocks">
                                                    <label for="password">Password</label>
                                                    <div class="mb-3 pass-group">
                                                        <input type="password" class="pass-input" id="password"
                                                            wire:model.lazy="password"
                                                            placeholder="Enter your password">
                                                        <span class="fas toggle-password fa-eye-slash"></span>
                                                    </div>
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-4 col-md-6 input-blocks">
                                                    <label for="password_confirmation">Confirm Password</label>
                                                    <div class="mb-3 pass-group">
                                                        <input type="password" class="pass-inputa"
                                                            id="password_confirmation"
                                                            wire:model.lazy="password_confirmation"
                                                            placeholder="Confirm your password">
                                                        <span class="fas toggle-passworda fa-eye-slash"></span>
                                                    </div>
                                                    @error('password_confirmation')
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
                handleApplicantActions();
                handleLocationDropdowns();
            });

            function initSelect() {
                $('.select').select2({
                    minimumResultsForSearch: -1,
                    width: '100%'
                });
            }

            function initializeComponents() {
                updateTotalApplicants();
            }

            function updateTotalApplicants() {
                const totalApplicants = @js($total_applicant);
                $('.applicant_total').text(totalApplicants);
            }

            function handleApplicantActions() {
                $(document).on('change', '[id]', handleInputChange);
                $(document).on('click', '.add-applicant', openAddApplicantModal);
                $(document).on('click', '.edit-applicant', openEditApplicantModal);
            }

            function handleInputChange(e) {
                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);
                }
            }

            function openAddApplicantModal() {
                console.log("Press");
                @this.set('submit_func', 'add-applicant');

                @this.call('resetFields').then(() => {
                    initSelectVal("");
                    $('#add-applicant-modal').modal('show');
                });
            }

            function openEditApplicantModal() {
                const applicantId = $(this).data('applicantid');

                @this.set('submit_func', 'edit-applicant');
                @this.call('getApplicant', applicantId).then(() => {
                    populateEditForm();
                    $('#add-applicant-modal').modal('show');
                });
            }

            function initSelectVal(gender) {
                $('#gender').val(gender).change();
            }

            function populateEditForm() {
                const gender = @this.get('gender');
                const region = @this.get('region');
                const province = @this.get('province');
                const municipality = @this.get('municipality');
                const barangay = @this.get('barangay');

                initSelect();
                initSelectVal(gender);

                if (region) {
                    $('#region').val(region).change();
                    const provinces = @json($locationData);
                    const provinceOptions = provinces[region]?.province_list || {};

                    let provinceHtml = '<option value="">Select Province</option>';
                    for (const prov in provinceOptions) {
                        provinceHtml += `<option value="${prov}" ${prov === province ? 'selected' : ''}>${prov}</option>`;
                    }
                    $('#province').html(provinceHtml).prop('disabled', false);

                    if (province) {
                        const municipalities = provinceOptions[province]?.municipality_list || {};

                        let municipalityHtml = '<option value="">Select Municipality</option>';
                        for (const mun in municipalities) {
                            municipalityHtml +=
                                `<option value="${mun}" ${mun === municipality ? 'selected' : ''}>${mun}</option>`;
                        }
                        $('#municipality').html(municipalityHtml).prop('disabled', false);

                        if (municipality) {
                            const barangays = municipalities[municipality]?.barangay_list || [];

                            let barangayHtml = '<option value="">Select Barangay</option>';
                            barangays.forEach(bgy => {
                                barangayHtml +=
                                    `<option value="${bgy}" ${bgy === barangay ? 'selected' : ''}>${bgy}</option>`;
                            });
                            $('#barangay').html(barangayHtml).prop('disabled', false);
                        }
                    }
                }
            }

            function handleLocationDropdowns() {
                $('#region').on('change', function() {
                    const selectedRegion = $(this).val();
                    $('#province').prop('disabled', !selectedRegion);
                    $('#municipality').prop('disabled', true).html(
                        '<option value="">Select Municipality</option>');
                    $('#barangay').prop('disabled', true).html('<option value="">Select Barangay</option>');

                    if (selectedRegion) {
                        const provinces = @json($locationData);
                        const provinceOptions = provinces[selectedRegion]?.province_list || {};

                        let options = '<option value="">Select Province</option>';
                        for (const province in provinceOptions) {
                            options += `<option value="${province}">${province}</option>`;
                        }
                        $('#province').html(options);
                    } else {
                        $('#province').html('<option value="">Select Province</option>');
                    }
                });

                $('#province').on('change', function() {
                    const selectedProvince = $(this).val();
                    $('#municipality').prop('disabled', !selectedProvince);
                    $('#barangay').prop('disabled', true).html('<option value="">Select Barangay</option>');

                    if (selectedProvince) {
                        const provinces = @json($locationData);
                        const selectedRegion = $('#region').val();
                        const municipalities = provinces[selectedRegion]?.province_list[selectedProvince]
                            ?.municipality_list || {};

                        let options = '<option value="">Select Municipality</option>';
                        for (const municipality in municipalities) {
                            options += `<option value="${municipality}">${municipality}</option>`;
                        }
                        $('#municipality').html(options);
                    } else {
                        $('#municipality').html('<option value="">Select Municipality</option>');
                    }
                });

                $('#municipality').on('change', function() {
                    const selectedMunicipality = $(this).val();
                    $('#barangay').prop('disabled', !selectedMunicipality);

                    if (selectedMunicipality) {
                        const provinces = @json($locationData);
                        const selectedRegion = $('#region').val();
                        const selectedProvince = $('#province').val();
                        const barangays = provinces[selectedRegion]?.province_list[selectedProvince]
                            ?.municipality_list[selectedMunicipality]?.barangay_list || [];

                        let options = '<option value="">Select Barangay</option>';
                        barangays.forEach(barangay => {
                            options += `<option value="${barangay}">${barangay}</option>`;
                        });
                        $('#barangay').html(options);
                    } else {
                        $('#barangay').html('<option value="">Select Barangay</option>');
                    }
                });
            }
        </script>
    @endpush
</div>
