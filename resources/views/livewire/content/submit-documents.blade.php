<div class="modal fade" id="document-modal" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg custom-modal-two">
        <div class="modal-content">
            <div class="page-wrapper-new p-0">
                <div class="content">
                    <div class="modal-header border-0 custom-modal-header">
                        <div class="page-title">
                            <h4>{{ $document_type }}</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <button class="capture btn btn-submit mb-4 w-100">
                            <i class="fas fa-camera me-2"></i>Capture
                        </button>
                        <form wire:submit.prevent="saveDocumentPhoto">
                            @csrf
                            <div class="row" x-data="{ photoPreview: @entangle('photoPreview'), photoName: '' }">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="image-upload ">
                                            <input class="avatar" type="file" id="file-input" accept="image/*"
                                                wire:model.live="photo_upload" x-ref="photo_upload"
                                                x-on:change="photoName = $refs.photo_upload.files[0].name;
                                                            const reader = new FileReader();
                                                            reader.onload = (e) => {
                                                                photoPreview = e.target.result;
                                                                @this.set('photo', null);
                                                            };
                                                            reader.readAsDataURL($refs.photo_upload.files[0]);
                                                        ">
                                            <div class="image-uploads">
                                                <div class="d-flex justify-content-center">
                                                    <img src="img/icons/upload.svg" alt="img">
                                                </div>

                                                <h4>Drag and drop a file to upload</h4>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="product-list">
                                        <ul class="row" id="product-list">
                                            <template x-if="photoPreview !== ''">
                                                <li class="ps-0 w-100">
                                                    <div class="productviewset">
                                                        <div class="productviewsimg" style="max-width: 100%;">
                                                            <img :src="photoPreview" alt="img">
                                                        </div>

                                                    </div>
                                                </li>
                                            </template>

                                            <template x-if="photoPreview === ''">
                                                <li class="ps-0 w-100">
                                                    <div class="productviewset">
                                                        <div class="productviewsimg" style="max-width: 100%;">
                                                            <div id="my_camera"></div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                                @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="modal-footer-btn mb-4 mt-0">
                                <button type="button" class="btn btn-cancel me-2 "
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-submit save-document">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                populateBranchFilter();
                populateCountryFilter();
            });

            $(document).on('click', '.capture', function() {
                console.log('Capture Button Clicked');

                var preview = @this.get('photoPreview');

                if (preview !== '') {
                    @this.set('photoPreview', '').then(() => {
                        Webcam.reset();
                        showCamera();
                    });
                    @this.set('photo', '');
                } else {
                    Webcam.snap(function(data_uri) {
                        console.log('Captured Image:', data_uri);
                        @this.set('photoPreview', data_uri);
                        @this.set('photo', data_uri);
                        @this.set('photo_upload', null);
                    });
                }
            });

            $('.save-document').on('click', function() {

                confirmAlert("Submit Document",
                    "Are you sure you want to submit this document?",
                    function() {
                        showLoader();
                        submitDocument();
                    }, "Submit");
            });

            const submitDocument = function() {
                @this.call('saveDocumentPhoto').then(() => {
                    hideLoader();
                    let error = @this.get('error');

                    if (error && error.valid) {
                        messageAlert('Invalid Document', error.message);
                        @this.set('error', []);
                    }

                    if (error && error.type === 'medical') {
                        okAlert("Rejected Application",
                            error.message,
                            function() {
                                rejectApplication();
                            }, "Confirm");
                        @this.set('error', []);
                    }

                });
            }

            const rejectApplication = function() {
                @this.call('rejectApplication');
            };



            $(document).on('click', '.submit-documents', function() {
                const applicationId = $(this).data('applicationid');

                @this.call('isDocumentsComplete', applicationId).then(isComplete => {
                    var message = @this.get('message');

                    if (isComplete === true) {
                        confirmAlert("Approve application",
                            "Are you sure you want to submit these documents?",
                            function() {
                                submitDocuments(applicationId);
                            }, "Submit");
                    } else {
                        messageAlert("Incomplete Documents", message);
                    }
                });

            });

            const submitDocuments = function(applicationId) {
                console.log(applicationId);

                @this.call('submitApplication', applicationId).then(() => {
                    // Handle success
                });
            }

            $(document).on('click', '.birth-cert', function() {
                const applicationId = $(this).data('applicationid');
                console.log('Birth Certificate:', applicationId);

                getDocumentPhoto(applicationId, "Birth Certificate");
            });

            function getDocumentPhoto(application_id, document_type) {
                @this.set('application_id', application_id);
                @this.set('document_type', document_type);

                showLoader();
                displayDocumentModal();
            }

            function showCamera() {
                Webcam.set({
                    width: 700,
                    height: 500,
                    image_format: 'png',
                    png_quality: 90
                });
                Webcam.attach('#my_camera');
            }

            function displayDocumentModal() {
                @this.call('getDocument').then(() => {
                    hideLoader();

                    var preview = @this.get('photoPreview');

                    if (preview === '') {
                        showCamera();
                    }

                    console.log('Preview:', preview);
                });
                $('#document-modal').modal('show');
            }

            $('#document-modal').on('hidden.bs.modal', function() {
                // @this.set('photoPreview', '');
                // @this.set('photo', null);
                Webcam.reset();
            });

            $(document).on('click', '.passport', function() {
                const applicationId = $(this).data('applicationid');
                console.log('Passport:', applicationId);

                getDocumentPhoto(applicationId, "Passport");
            });

            $(document).on('click', '.med-cert', function() {
                const applicationId = $(this).data('applicationid');
                console.log('Medical Certificate:', applicationId);

                getDocumentPhoto(applicationId, "Medical Certificate");
            });

            $(document).on('click', '.nbi', function() {
                const applicationId = $(this).data('applicationid');
                console.log('NBI Clearance:', applicationId);

                getDocumentPhoto(applicationId, "NBI Clearance");
            });

            $(document).on('click', '.valid-id', function() {
                const applicationId = $(this).data('applicationid');
                console.log('Valid ID:', applicationId);

                getDocumentPhoto(applicationId, "Valid ID");
            });
        </script>
    @endpush
</div>
