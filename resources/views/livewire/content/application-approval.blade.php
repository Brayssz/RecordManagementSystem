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

                confirmAlert("Approve Application?", "Are you sure you want to approve this application?", function() {
                    approveApplication(applicationId);
                }, 'Approve');

                // Add your logic to handle approve application
                console.log('Approve application with ID:', applicationId);
            });

            const approveApplication = (applicationId) => {
                @this.set('application_id', applicationId);

                @this.call('approveApplication');
            }
    
            $(document).on('click', '.reject-application', function() {
                var applicationId = $(this).data('applicationid');

                confirmAlert("Reject Application?", "Are you sure you want to reject this application?", function() {
                    rejectApplication(applicationId);
                }, 'Reject');
                // Add your logic to handle reject application
                console.log('Reject application with ID:', applicationId);
            });

            const rejectApplication = (applicationId) => {
                @this.set('application_id', applicationId);

                @this.call('rejectApplication');
            }
        });
    </script>
        
    @endpush

</div>
