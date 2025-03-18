<div>
    @push('scripts')
    <script>
        $(document).ready(function () {
           getInterviewCount();
           setInterval(getInterviewCount, 1000); // Call every second
        });

        const getInterviewCount = () => {       
            @this.call('getInterviewCount').then(count => {
                $('.badge-notif').text(count);
            });
        };
    </script>
    @endpush
</div>
