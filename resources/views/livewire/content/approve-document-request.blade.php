<div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize any necessary JavaScript here
            });

            $(document).on('click', '.approve-request', function() {
                const requestId = $(this).data('requestid');

                console.log('Approving request with ID:', requestId);

                confirmAlert('Approve Request', 'Are you sure you want to approve this request?', function() {
                    @this.call('approveRequest', requestId);
                }, "Confirm");
            });
        </script>
    @endpush
</div>
