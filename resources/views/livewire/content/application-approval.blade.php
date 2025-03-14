<div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.view-application', function() {
                var applicationId = $(this).data('applicationid');

                // Add your logic to handle view application
                console.log('View application with ID:', applicationId);
            });
    
            $(document).on('click', '.approve-application', function() {
                var applicationId = $(this).data('applicationid');

                @this.set('application_id', applicationId);

                @this.call('approveApplication').then(() => {
                    // Handle success
                });
                // Add your logic to handle approve application
                console.log('Approve application with ID:', applicationId);
            });
    
            $(document).on('click', '.reject-application', function() {
                var applicationId = $(this).data('applicationid');

                @this.set('application_id', applicationId);

                @this.call('rejectApplication').then(() => {
                    // Handle success
                });
                // Add your logic to handle reject application
                console.log('Reject application with ID:', applicationId);
            });
        });
    </script>
        
    @endpush

</div>
