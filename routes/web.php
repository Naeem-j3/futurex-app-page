<?php

use Illuminate\Support\Facades\Route;
use FutureX\AppPage\Http\Middleware\TrackVisit;
use FutureX\AppPage\Http\Controllers\AppPageController;
use FutureX\AppPage\Http\Controllers\ClickController;
use FutureX\AppPage\Http\Controllers\TrackDurationController;

$prefix = config('app-page.route_prefix', 'app-page');

Route::prefix($prefix)
    ->middleware('web')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->group(function () {

        // Landing Page
        Route::get('/', [AppPageController::class, 'index'])
            ->middleware(TrackVisit::class);

        // Click tracking
        Route::get('/click/{type}', [ClickController::class, 'handle']);

        // Duration tracking
        Route::post('/track-duration', [TrackDurationController::class, 'store']);
    });
