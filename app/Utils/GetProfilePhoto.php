<?php

namespace App\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GetProfilePhoto
{

    public static function getProfilePhotoUrl(): string
    {
        $profilePhotoDisk = config('filesystems.default', 'public');
        $position = GetUsertype::getUserType();
        $user = Auth::guard($position)->user();
        return $user && $user->profile_photo_path
            ? Storage::disk($profilePhotoDisk)->url($user->profile_photo_path)
            : "";
    }
}