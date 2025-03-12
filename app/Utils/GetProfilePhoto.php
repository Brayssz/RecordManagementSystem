<?php

namespace App\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GetProfilePhoto
{

    public static function getProfilePhotoUrl(): string
    {
        $profilePhotoDisk = config('filesystems.default', 'public');

        return Auth::user()->profile_photo_path
            ? Storage::disk($profilePhotoDisk)->url(Auth::user()->profile_photo_path)
            : "";
    }
}