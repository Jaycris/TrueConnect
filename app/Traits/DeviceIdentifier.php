<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

trait DeviceIdentifier
{
    /**
     * Get a unique identifier for the device.
     *
     * @return string
     */
    protected function deviceIdentifier()
    {
        // Add a random salt to differentiate between normal and private/incognito browsing
        $salt = request()->cookie('device_salt', Str::random(16));
        Cookie::queue('device_salt', $salt, 60); // Store salt in a cookie

        // Use additional browser-specific information
        $userAgent = request()->userAgent();
        // $ipAddress = request()->ip();
        // $browserLanguage = request()->server('HTTP_ACCEPT_LANGUAGE', 'unknown');
        // $screenResolution = request()->server('HTTP_SEC_CH_UA', 'unknown');

        // return hash('sha256', $userAgent . $ipAddress . $browserLanguage . $screenResolution . $salt);
        return hash('sha256', $userAgent . $salt);

    }
}