<?php

namespace App\Livewire\Content;

use Livewire\Component;
use
    App\Utils\GetUsertype;
use App\Utils\GetProfilePhoto;
use Illuminate\Support\Facades\Auth;

class Layout extends Component
{
    public $position = GetUsertype::getUserType();

    public $profilePhoto = GetProfilePhoto::getProfilePhotoUrl();

    public $user = Auth::guard($position)->user();

    public function render()
    {
        return view('livewire.content.layout');
    }
}
