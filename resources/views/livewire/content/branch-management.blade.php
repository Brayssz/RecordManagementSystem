<div class="modal fade" id="branch-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-xl custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            @if ($submit_func == "add-branch")
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
                                            <h6><span><i data-feather="info" class="feather-edit"></i></span>Branch Information</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input type="email" class="form-control" placeholder="e.g., name@mail.com" id="email" wire:model.lazy="email">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="contact_number">Mobile Number</label>
                                                    <input type="text" id="contact_number" class="form-control phMobile not_pass" placeholder="e.g., +63 999 999 9999" wire:model.lazy="contact_number">
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
                                                            <select class="select" id="status" name="status" wire:model="status">
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
                                                <h6><span><i data-feather="info" class="feather-edit"></i></span>Other Information</h6>
                                            </div>
                                            <div class="row">
                                                @foreach (['region', 'province', 'municipality', 'barangay', 'street', 'postal_code'] as $field)
                                                    <div class="col-lg-4 col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                                                            <input type="text" class="form-control" id="{{ $field }}" wire:model.lazy="{{ $field }}" placeholder="Enter your {{ $field }}">
                                                            @error($field)
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer-btn mb-4 mt-0">
                                <button type="button" class="btn btn-cancel me-2" data-bs-dismiss="modal">Cancel</button>
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

            function openEditBranchModal() {
                const branchId = $(this).data('branchid');
              
                @this.set('submit_func', 'edit-branch');
                @this.call('getBranch', branchId).then(() => {
                    initSelect();
                    $('#branch-modal').modal('show');
                });
            }
        </script>
    @endpush
</div>
