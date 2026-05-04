<?php
namespace FutureX\AppPage\Http\Controllers;

use Illuminate\Http\Request;
use FutureX\AppPage\Models\AppPageVisit;

class TrackDurationController
{
    public function store(Request $request)
    {
        // Read from JSON body instead of query string
        $data = $request->json()->all();
        $visitId  = $data['visit_id'] ?? null;
        $duration = $data['duration'] ?? 0;
        if (!$visitId || $duration <= 0) {
            return response()->noContent();
        }
        // Update the visit record
        AppPageVisit::where('id', $visitId)
            ->whereNull('duration') // Only update if not already set
            ->update(['duration' => $duration]);
        return response()->noContent();
    }
}
