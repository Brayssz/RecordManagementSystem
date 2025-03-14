<?php

namespace App\Livewire\Content;

use Livewire\Component;
use App\Utils\GetUserType;
use App\Utils\GetProfilePhoto;
use Illuminate\Support\Facades\Auth;

class Layout extends Component
{
    public $position;
    public $profilePhoto;
    public $user;

    public function __construct()
    {
        $this->position = GetUserType::getUserType();
        $this->profilePhoto = GetProfilePhoto::getProfilePhotoUrl();
        $this->user = Auth::guard($this->position)->user();
    }

    public function render()
    {
        return view('livewire.content.layout');
    }
}
