<?php

namespace FutureX\AppPage\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use FutureX\AppPage\Models\AppPage;
use FutureX\AppPage\Models\AppPageVisit;
use Illuminate\Support\Str;
use Stevebauman\Location\Facades\Location;
class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('app-page')) {

            $app = AppPage::where('is_active', true)->first();

            $sessionId = $request->session()->get('fx_session');
            if (!$sessionId) {
                $sessionId = Str::uuid();
                $request->session()->put('fx_session', $sessionId);
            }


            $location = null;

            try {
                $ip = $request->ip();

                if (!in_array($ip, ['127.0.0.1', '::1'])) {
                    $location = Location::get($ip);
                }
            } catch (\Throwable $e) {
                $location = null;
            }

            // ✅ Create visit BEFORE the view renders
            $visit = AppPageVisit::create([
                'app_page_id' => $app?->id,
                'ip'          => $request->ip(),
                'country'     => $location?->countryName ?? 'unknown',
                'device'      => $this->getDevice($request),
                'browser'     => $request->userAgent(),
                'referrer'    => $request->headers->get('referer'),
                'session_id'  => $sessionId,
            ]);


            $request->session()->put('fx_visit_id', $visit->id);
            $request->session()->save();
        }


        return $next($request);
    }

    private function getDevice($request)
    {
        $agent = $request->userAgent();

        if (str_contains($agent, 'Mobile')) {
            return 'mobile';
        }

        return 'desktop';
    }
}
