<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    protected $fillable = [
        'user_id',
        'long_url',
        'short_url',
        'visit_count',
    ];

    /**
     * Generate Short URL
     *
     * @return string $shortUrl
     */
    public static function generateShortUrl($length = 6): string
    {
        do {
            $shortUrl = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
        } while (self::where('short_url', $shortUrl)->exists());

        return $shortUrl;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
