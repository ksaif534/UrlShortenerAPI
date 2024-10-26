<?php

use App\Services\API\CheckExistingShortUrl;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('redirect-url-v2', '2BqeD3');
    // return view('welcome');
});

Route::prefix('v1')->get('/shorten/{shortUrl}', function (string $shortUrl, CheckExistingShortUrl $existingShortUrl) {
    $url = $existingShortUrl->redirect($shortUrl);

    return redirect($url->long_url);
})->name('redirect-url-v1');

Route::prefix('v2')->get('/shorten/{shortUrl}', function (string $shortUrl, CheckExistingShortUrl $existingShortUrl) {
    $url = $existingShortUrl->redirect($shortUrl);

    $url->increment('visit_count');

    return redirect($url->long_url);
})->name('redirect-url-v2');
