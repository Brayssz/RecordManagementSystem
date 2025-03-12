<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Profile</h4>
            <h6>User Profile</h6>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent="saveProfile">
                <div class="profile-set">
                    <div class="profile-head">

                    </div>

                    <div class="profile-top">
                        <div class="profile-content">
                            <div class="profile-contentimg" x-data="{ photoPreview: @entangle('photoPreview'), photoName: '' }">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" alt="">
                                </template>
                                <template x-if="!photoPreview">
                                    <img src="img/no-profile.png" alt="">
                                </template>
                                <div class="profileupload">
                                    <input type="file" id="imgInp" wire:model="photo" x-ref="photo"
                                        x-on:change="
                                                photoName = $refs.photo.files[0].name;
                                                const reader = new FileReader();
                                                reader.onload = (e) => {
                                                    photoPreview = e.target.result;
                                                };
                                                reader.readAsDataURL($refs.photo.files[0]);
                                            ">
                                    <a href="javascript:void(0);">
                                        <img src="img/icons/edit-set.svg" alt="img">
                                    </a>
                                </div>
                            </div>
                            <div class="profile-contentname">
                                <h2>
                                    {{ Auth::user()->first_name . ' ' . (Auth::user()->middle_name != null ? substr(Auth::user()->middle_name, 0, 1) . '. ' : '') . Auth::user()->last_name }}
                                </h2>

                                <h4>Updates Your Photo and Personal Details.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 col-md-6">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="first_name">First Name</label>
                                    <input type="text" class="form-control" placeholder="Enter first name"
                                        id="first_name" wire:model.lazy="first_name">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="middle_name">Middle Name</label>
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
                                    <input type="text" class="form-control" placeholder="Enter last name" id="last_name"
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
                            <input type="email" class="form-control" placeholder="e.g., name@mail.com" id="email"
                                wire:model.lazy="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control" placeholder="Enter your username" id="username"
                                wire:model.lazy="username">
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            <label class="form-label" for="contact_number">Contact Number</label>
                            <input type="text" id="contact_number" class="form-control"
                                placeholder="e.g., +63 999 999 9999" wire:model.lazy="contact_number">
                            @error('contact_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
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
                </div>

                <div class="other-info">
                    <div class="card-title-head" wire:ignore>
                        <h6><span><i data-feather="info" class="feather-edit"></i></span>Other Information</h6>
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
                        <h6><span><i data-feather="info" class="feather-edit"></i></span>Password</h6>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 input-blocks">
                            <label for="password">Password</label>
                            <div class="mb-3 pass-group">
                                <input type="password" class="pass-input" id="password" wire:model.lazy="password"
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
                                <input type="password" class="pass-inputa" id="password_confirmation"
                                    wire:model.lazy="password_confirmation" placeholder="Confirm your password">
                                <span class="fas toggle-passworda fa-eye-slash"></span>
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /product list -->
</div>
