<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShortenUrlRequest;
use App\Models\Url;
use App\Services\API\CheckExistingLongUrl;
use App\Services\API\ShortenLongUrl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UrlShortenController extends Controller
{
    /**
     * The List of Url's for user display
     */
    public function index()
    {
        $listOfUrls = DB::table('urls')->where('user_id', Auth::user()->id)->select('long_url')->get();

        return response()->json([
            'listOfUrls' => $listOfUrls,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShortenUrlRequest $request, CheckExistingLongUrl $longUrl, ShortenLongUrl $shortenUrl)
    {
        $validated = $request->validated();

        $existingLongUrl = $longUrl->check($validated);

        if ($existingLongUrl) {
            return response()->json([
                'short_url' => url('/v1/shorten').'/'.$existingLongUrl->short_url,
            ], Response::HTTP_OK);
        }

        $shortUrlGenerator = Url::generateShortUrl();

        $urlResult = $shortenUrl->shorten($validated, $shortUrlGenerator);

        return response()->json([
            'short_url' => url('/v1/shorten').'/'.$shortUrlGenerator,
        ], Response::HTTP_CREATED);
    }
}
