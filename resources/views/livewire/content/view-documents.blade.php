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
                        <form>
                            @csrf
                            <div class="row" x-data="{ photoPreview: @entangle('photoPreview'), photoName: '' }">
                                <div class="col-lg-12" style="display: none;">
                                    <div class="form-group">
                                        <div class="image-upload ">
                                            <input class="avatar" type="file" id="file-input" accept="image/*"
                                                wire:model.live="photo" x-ref="photo"
                                                x-on:change="
                                                            photoName = $refs.photo.files[0].name;
                                                            const reader = new FileReader();
                                                            reader.onload = (e) => {
                                                                photoPreview = e.target.result;
                                                            };
                                                            reader.readAsDataURL($refs.photo.files[0]);
                                                        ">
                                            <div class="image-uploads">
                                                <div class="d-flex justify-content-center">
                                                    <img src="assets/img/icons/upload.svg" alt="img">
                                                </div>

                                                <h4>Drag and drop a file to upload</h4>
                                            </div>
                                            @error('photo')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="product-list">
                                        <ul class="row" id="product-list">
                                            <template x-if="photoPreview !== ''">
                                                <li class="ps-0 w-100">
                                                    <div class="productviewset">
                                                        <div class="productviewsimg rounded-4" style="max-width: 100%;">
                                                            <img :src="photoPreview" alt="img" class="rounded-4">
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
                            </div>

                            <div class="modal-footer-btn mb-4 mt-0">
                                <button type="button" class="btn btn-submit" data-bs-dismiss="modal">Close</button>
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
                
            });

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


            function displayDocumentModal() {
                @this.call('getDocument').then(() => {
                    hideLoader();
                    var photoPreview = @this.get('photoPreview');
                    console.log('Photo Preview:', photoPreview);
                    if (photoPreview !== '') {
                        $('#document-modal').modal('show');
                    } else {
                        messageAlert('No photo available', 'No photo available for this document.');
                    }
                    
                });
                
            }

            

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
