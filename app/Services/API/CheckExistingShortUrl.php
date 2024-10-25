<?php

namespace App\Services\API;

use App\Models\Url;

class CheckExistingShortUrl
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function redirect(string $shortUrl): ?Url
    {
        return Url::where('short_url', $shortUrl)->firstOrFail();
    }
}
