<div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize any necessary JavaScript here
            });

            $(document).on('click', '.download-documents', function() {
                
            });

            $(document).on('click', '.request-documents', function() {
                const applicationId = $(this).data('applicationid');
                console.log('Requesting documents');

                confirmAlert('Request Documents', 'Are you sure you want to request these documents for this application?', function() {
                    @this.call('requestDocuments', applicationId);
                }, "Confirm");
            });
        </script>
    @endpush
</div>
