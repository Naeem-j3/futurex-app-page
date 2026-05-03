<?php

namespace FutureX\AppPage\Http\Controllers;

use Illuminate\Http\Request;
use FutureX\AppPage\Models\AppPage;
use FutureX\AppPage\Models\AppPageClick;
use Stevebauman\Location\Facades\Location;

class ClickController
{
    public function handle(Request $request, $type)
    {
        $app = AppPage::where('is_active', true)->first();
        $location = Location::get($request->ip() !== '127.0.0.1' ? $request->ip() : '8.8.8.8');
        AppPageClick::create([
            'app_page_id' => $app?->id,
            'type' => $type,
            'ip' => $request->ip(),
            'country' => $location?->countryName ?? 'unknown',
        ]);

        $url = match ($type) {
            'google' => $app?->google_play_url,
            'apple' => $app?->apple_store_url,
            'website' => $app?->website_url,
            'download' => $app?->direct_download_url,
            default => '/',
        };

        return redirect($url ?? '/');
    }
}
