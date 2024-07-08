<?php

namespace App\Traits;

trait DeviceIdentifier
{
    /**
     * Get a unique identifier for the device.
     *
     * @return string
     */
    public function deviceIdentifier()
    {
        return hash('sha256', request()->userAgent()); // Using a hashed user-agent as device identifier for better security
    }
}