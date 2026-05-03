<?php
namespace FutureX\AppPage\Http\Controllers;

use Illuminate\Http\Request;
use FutureX\AppPage\Models\AppPageVisit;

class TrackDurationController
{
    public function store(Request $request)
    {
        $visitId  = (int) $request->input('visit_id');
        $duration = (int) $request->input('duration', 0);

        if (!$visitId || $duration <= 0) {
            return response()->noContent();
        }

        AppPageVisit::where('id', $visitId)
            ->update(['duration' => $duration]);

        return response()->noContent();
    }
}
