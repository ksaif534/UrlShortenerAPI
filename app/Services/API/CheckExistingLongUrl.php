<?php

namespace App\Services\API;

use App\Models\Url;

class CheckExistingLongUrl
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Check Existing Long URL
     *
     * @return \App\Models\Url $longUrl
     */
    public function check(array $validated): ?Url
    {
        return Url::where('long_url', $validated['long_url'])->first();
    }
}
