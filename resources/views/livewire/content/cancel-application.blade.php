<div>
   @push('scripts')
         <script>
              document.addEventListener('DOMContentLoaded', () => {
                handleInterviewActions();
              });

              function handleInterviewActions() {
                $(document).on('click', '.cancel-application', CancelApplication);
              }

              const CancelApplication = function() {
                var applicationId = $(this).data('applicationid');

                console.log(applicationId);

                @this.set('application_id', applicationId);

                @this.call('checkApplicationStatus').then(response => {
                  if (response) {
                    messageAlert('Invalid Action', "You can't cancel this application because it's already processing.");
                  } else {
                    confirmAlert("Cancel Application?", "Are you sure you want to cancel this application?", function() {
                      @this.call('cancelApplication');
                    }, 'Yes, I want to cancel it');
                  }
                });
              }
    
    
             
         </script>
   
       
   @endpush
</div>
