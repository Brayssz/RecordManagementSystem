<div class="modal fade" id="branch-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-xl custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            @if ($submit_func == 'add-branch')
                                <h4>Add Branch</h4>
                            @else
                                <h4>Edit Branch</h4>
                            @endif
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="submit_branch">
                            @csrf
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="new-employee-field">
                                        <div class="card-title-head" wire:ignore>
                                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Branch
                                                Information</h6>
                                        </div>
                                        <div class="row">
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
                                                    <label class="form-label" for="contact_number">Mobile Number</label>
                                                    <input type="text" id="contact_number"
                                                        class="form-control phMobile not_pass"
                                                        placeholder="e.g., +63 999 999 9999"
                                                        wire:model.lazy="contact_number">
                                                    @error('contact_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if ($submit_func == 'edit-branch')
                                                <div class="col-lg-4 col-md-6 status-group">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="status">Status</label>
                                                        <div wire:ignore>
                                                            <select class="select" id="status" name="status"
                                                                wire:model="status">
                                                                <option value=''>Choose</option>
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
                                                            name="municipality" wire:model.lazy="municipality" disabled>
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
                handleBranchActions();
                initializeComponents();
                
            });

            function initializeComponents() {
                initSelect();
                updateTotalBranches();
                handleLocationDropdowns();
            }

            function updateTotalBranches() {
                const totalBranch = @js($total_branch);
                $('.branch_total').text(totalBranch);
            }

            function handleBranchActions() {
                $(document).on('change', '[id]', handleInputChange);
                $(document).on('click', '.add-branch', openAddBranchModal);
                $(document).on('click', '.edit-branch', openEditBranchModal);
            }

            function handleInputChange(e) {
                if ($(e.target).is('select') || $(e.target).is('.not_pass')) {
                    const property = e.target.id;
                    const value = e.target.value;
                    @this.set(property, value);

                    console.log(`${property}: ${value}`);
                }
            }

            function openAddBranchModal() {
                @this.set('submit_func', 'add-branch');

                @this.call('resetFields').then(() => {
                    $('#branch-modal').modal('show');
                });
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

            function populateEditForm() {
                const region = @this.get('region');
                const province = @this.get('province');
                const municipality = @this.get('municipality');
                const barangay = @this.get('barangay');

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


            function openEditBranchModal() {
                const branchId = $(this).data('branchid');

                @this.set('submit_func', 'edit-branch');
                @this.call('getBranch', branchId).then(() => {
                    populateEditForm();
                    initSelect();
                    $('#branch-modal').modal('show');
                });
            }
        </script>
    @endpush
</div>
