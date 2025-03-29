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
                                    <h4>Change Image</h4>
                                </div>
                            </div>
                            @error('photo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="marital_status">Marital Status</label>
                                <input type="text" class="form-control" placeholder="Enter marital status"
                                    id="marital_status" wire:model.lazy="marital_status">
                                @error('marital_status')
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
                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3" wire:ignore>
                                    <label class="form-label" for="region">Region</label>
                                    <select class="form-select" id="region" name="region"
                                        wire:model.lazy="region" >
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
                                    <label class="form-label" for="municipality">Municipality</label>
                                    <select class="form-select" id="municipality" name="municipality"
                                        wire:model.lazy="municipality" disabled>
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
                                    <input type="text" class="form-control" id="street" name="street"
                                        wire:model.lazy="street" autofocus autocomplete="street"
                                        placeholder="Enter your street">
                                    @error('street')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="postal_code">Postal
                                        Code</label>
                                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                                        wire:model.lazy="postal_code" autofocus autocomplete="postal_code"
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
                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Branch Information</h6>
                        </div>
                        <div class="row">


                            <div class="col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="branch_id">Branch</label>
                                    <div wire:ignore>
                                        <select class="select branch" id="branch_id" name="branch_id"
                                            wire:model="branch_id">
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
                            <div class="col-lg-6 col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="branch_id">Interview Schedule</label>
                                    <div class=" position-relative">
                                        <input type="text" id="datepicker"
                                            class="form-control pe-5 daterange_filter"
                                            placeholder="Select a branch first" readonly>
                                        <i
                                            class="far fa-calendar position-absolute top-50 end-0 translate-middle-y pe-3"></i>
                                    </div>
                                    @error('schedule_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="pass-info">
                        <div class="card-title-head" wire:ignore>
                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Valid ID</h6>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="mb-3">
                                    <label class="form-label" for="valid_id_type">Valid ID Type</label>
                                    <select class="form-select" id="valid_id_type" name="valid_id_type"
                                        wire:model.lazy="valid_id_type">
                                        <option value="">Select ID Type</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Driver's License">Driver's License</option>
                                        <option value="SSS ID">SSS ID</option>
                                        <option value="PhilHealth ID">PhilHealth ID</option>
                                        <option value="Voter's ID">Voter's ID</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    @error('valid_id_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="mb-3" x-data="{ docPhotoPreview: '', photoName: '' }">
                                    <label class="form-label" for="valid_id">Upload Valid ID</label>
                                    <input class="form-control" type="file" id="valid_id" accept="image/*"
                                        x-ref="valid_id"
                                        x-on:change="
                                            photoName = $refs.valid_id.files[0].name;
                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                docPhotoPreview = e.target.result;
                                            };
                                            reader.readAsDataURL($refs.valid_id.files[0]);
                                            $wire.upload('valid_id', $refs.valid_id.files[0]);
                                        ">
                                    @error('valid_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="product-list mt-3">
                                        <ul class="row" id="product-list">
                                            <template x-if="docPhotoPreview !== ''">
                                                <li class="ps-0 w-100">
                                                    <div class="product-view-set">
                                                        <div class="product-views-img" style="max-width: 100%;">
                                                            <img :src="docPhotoPreview" alt="Valid ID Preview">
                                                        </div>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pass-info">
                        <div class="card-title-head" wire:ignore>
                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Birth Certificate</h6>
                        </div>
                        <div class="row" x-data="{ docPhotoPreview: '', photoName: '' }">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10">
                                        <div class="form-group">
                                            <div>
                                                <label class="form-label" for="birth_certificate">Document</label>
                                                <input class="form-control" type="file" id="birth_certificate"
                                                    accept="image/*" x-ref="birth_certificate"
                                                    x-on:change="
                                                        photoName = $refs.birth_certificate.files[0].name;
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            docPhotoPreview = e.target.result;
                                                        };
                                                        reader.readAsDataURL($refs.birth_certificate.files[0]);
                                                        $wire.upload('birth_certificate', $refs.birth_certificate.files[0]);">
                                                @error('birth_certificate')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-5">
                                <div class="product-list">
                                    <ul class="row" id="product-list">
                                        {{-- PREVIEW SELECTED IMAGE --}}
                                        <template x-if="docPhotoPreview !== ''">
                                            <li class="ps-0 w-100">
                                                <div class="product-view-set">
                                                    <div class="product-views-img" style="max-width: 100%;">
                                                        <img :src="docPhotoPreview" alt="img">
                                                    </div>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
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
                populateEditForm();
                handleLocationDropdowns();

                // const allowedDates = {
                //     "2025-04-05": "date-id-1",
                //     "2025-04-10": "date-id-2",
                //     "2025-04-15": "date-id-3"
                // };

                // $("#datepicker").flatpickr({
                //     dateFormat: "Y-m-d",
                //     disable: [
                //         function(date) {
                //             const formattedDate = date.toISOString().split('T')[0];
                //             return !Object.keys(allowedDates).includes(formattedDate);
                //         }
                //     ],
                //     onChange: function(selectedDates, dateStr, instance) {
                //         if (allowedDates[dateStr]) {
                //             $("#datepicker").attr("data-date-id", allowedDates[
                //                 dateStr]); // Attach ID as a data attribute
                //             console.log("Selected Date ID:", allowedDates[dateStr]); // Debugging
                //         } else {
                //             $("#datepicker").removeAttr("data-date-id"); // Remove if no ID
                //         }
                //     }
                // });
            });


            function populateEditForm() {
                const region = @this.get('region');
                const province = @this.get('province');
                const municipality = @this.get('municipality');
                const barangay = @this.get('barangay');
                const locationData = @json($locationData);

                if (region) {
                    $('#region').val(region).change();
                    const provinceOptions = locationData[region]?.province_list || {};

                    if (Object.keys(provinceOptions).length) {
                        const provinceHtml = Object.keys(provinceOptions).map(prov => 
                            `<option value="${prov}" ${prov === province ? 'selected' : ''}>${prov}</option>`
                        ).join('');
                        $('#province').html(`<option value="">Select Province</option>${provinceHtml}`).prop('disabled', false);

                        if (province) {
                            const municipalities = provinceOptions[province]?.municipality_list || {};
                            if (Object.keys(municipalities).length) {
                                const municipalityHtml = Object.keys(municipalities).map(mun => 
                                    `<option value="${mun}" ${mun === municipality ? 'selected' : ''}>${mun}</option>`
                                ).join('');
                                $('#municipality').html(`<option value="">Select Municipality</option>${municipalityHtml}`).prop('disabled', false);

                                if (municipality) {
                                    const barangays = municipalities[municipality]?.barangay_list || [];
                                    if (barangays.length) {
                                        const barangayHtml = barangays.map(bgy => 
                                            `<option value="${bgy}" ${bgy === barangay ? 'selected' : ''}>${bgy}</option>`
                                        ).join('');
                                        $('#barangay').html(`<option value="">Select Barangay</option>${barangayHtml}`).prop('disabled', false);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            function handleInputChange(e) {

                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);

                }
                getBranchSchedules(e);
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

            const getBranchSchedules = (e) => {
                console.log("hello" + e.target);
                if ($(e.target).is('.branch')) {
                    @this.call('getSchedules').then(schedules => {
                        console.log(schedules);

                        const allowedDates = {};
                        const tooltips = {};

                        schedules.forEach(schedule => {
                            const dateKey = schedule.interview_date.split(' ')[0];
                            allowedDates[dateKey] = schedule.schedule_id;

                            const formattedTime = `${new Date('1970-01-01T' + schedule.available_start_time).toLocaleTimeString(
                                'en-US', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hour12: true
                                })} - ${new Date('1970-01-01T' + schedule.available_end_time).toLocaleTimeString(
                                'en-US', {
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    hour12: true
                                })}`;
                            tooltips[dateKey] =
                                `Available: ${schedule.available_slots} slots  |  Time: ${formattedTime}`;
                        });

                        console.log(allowedDates, tooltips);

                        $('#datepicker').attr('placeholder', 'Select a valid date');

                        $("#datepicker").flatpickr({
                            dateFormat: "Y-m-d",
                            disable: [
                                function(date) {
                                    const formattedDate = date.getFullYear() + '-' +
                                        String(date.getMonth() + 1).padStart(2, '0') + '-' +
                                        String(date.getDate()).padStart(2, '0');
                                    return !Object.keys(allowedDates).includes(formattedDate);
                                }
                            ],
                            onDayCreate: function(dObj, dStr, fp, dayElem) {
                                const date = dayElem.dateObj;
                                const formattedDate = date.getFullYear() + '-' +
                                    String(date.getMonth() + 1).padStart(2, '0') + '-' +
                                    String(date.getDate()).padStart(2, '0');

                                if (tooltips[formattedDate]) {
                                    dayElem.setAttribute('data-tippy-content', tooltips[formattedDate]);
                                    dayElem.classList.add('has-tooltip');
                                }
                            },
                            onChange: function(selectedDates, dateStr, instance) {
                                console.log("Selected Date String:", dateStr);
                                console.log("Allowed Dates Object:", allowedDates);

                                if (allowedDates[dateStr]) {
                                    $("#datepicker").attr("data-date-id", allowedDates[dateStr]);

                                    tooltipInit();

                                    @this.set('schedule_id', allowedDates[dateStr]);
                                } else {
                                    $("#datepicker").removeAttr("data-date-id");
                                    console.log("Date not in allowedDates");

                                    tooltipInit();
                                }
                            }
                        });

                        tooltipInit();
                    });
                }

                const tooltipInit = () => {
                    tippy('.has-tooltip', {
                        allowHTML: true,
                        placement: 'top',
                        theme: 'light',
                    });
                };
            }
        </script>
    @endpush
</div>
