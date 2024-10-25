<?php

namespace App\Services\API;

use App\Models\Url;
use Illuminate\Support\Facades\Auth;

class ShortenLongUrl
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function shorten(array $validated, $shortUrlGenerator): ?Url
    {
        return Url::create([
            'user_id' => Auth::user()->id,
            'long_url' => $validated['long_url'],
            'short_url' => $shortUrlGenerator,
        ]);
    }
}
