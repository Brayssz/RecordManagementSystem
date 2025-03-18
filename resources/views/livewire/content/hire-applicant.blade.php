<div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $(document).on('click', '.view-application', function() {
                    var applicationId = $(this).data('applicationid');

                    // Add your logic to handle view application
                    console.log('View application with ID:', applicationId);
                });

                $(document).on('click', '.hire-applicant', function() {
                    var applicationId = $(this).data('applicationid');


                    confirmAlert("Hire Applicant?", "You won't be able to revert this.", function() {
                        hire(applicationId);
                    }, 'Hire');

                    // Add your logic to handle approve application
                    // console.log('Approve application with ID:', applicationId);
                });

                const hire = (applicationId) => {
                    // console.log('Hire application with ID:', applicationId);
                    @this.set('application_id', applicationId);

                    @this.call('hireApplicant').then(() => {

                    });
                }


            });
        </script>
    @endpush

</div>
