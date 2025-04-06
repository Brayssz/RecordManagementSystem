<div>
    @push('scripts')
    <script>
        $(document).ready(function () {
           getInterviewCount();
           getDocumentRequestCount();
           setInterval(getInterviewCount, 1000); // Call every second
        });

        const getInterviewCount = () => {       
            @this.call('getInterviewCount').then(count => {
                $('.interview-notif').text(count);
            });
        };

        const getDocumentRequestCount = () => {       
            @this.call('getDocumentRequestCount').then(count => {
                $('.request-notif').text(count);
            });
        };
    </script>
    @endpush
</div>
