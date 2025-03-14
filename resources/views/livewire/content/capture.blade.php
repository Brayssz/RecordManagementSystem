<div>
    <h2>Laravel 12 Livewire Webcam Capture</h2>

    <div id="my_camera"></div>
    <button id="captureButton">Capture</button>

    @if ($imageData)
        <div id="results">
            <img src="{{ $imageData }}" alt="Captured Image">
        </div>
        <button wire:click="saveImage">Save Image</button>
    @endif

    @if (session()->has('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif
    

    @push('scripts')
    <script>
        $(document).ready(function() {

            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'png',
                png_quality: 90
            });
            Webcam.attach('#my_camera');

            document.querySelector('#captureButton').addEventListener('click', function() {
                console.log('Capture Button Clicked');

                Webcam.snap(function(data_uri) {
                    console.log('Captured Image:', data_uri);
                    @this.set('imageData', data_uri);
                });
            });
        });
    </script>
    @endpush

</div>
