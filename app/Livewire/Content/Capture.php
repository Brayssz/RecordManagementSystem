<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class Capture extends Component
{
    public $imageData;

    public function saveImage()
    {
        if ($this->imageData) {
            $image = str_replace('data:image/png;base64,', '', $this->imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = 'webcam_' . time() . '.png';

            Storage::disk('public')->put('webcam/' . $imageName, base64_decode($image));

            session()->flash('message', 'Image saved successfully!');

            // Reset the image
            $this->imageData = null;
        }
    }

    public function render()
    {
        return view('livewire.content.capture');
    }
}
