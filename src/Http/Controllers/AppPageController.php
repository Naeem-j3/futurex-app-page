<?php

namespace FutureX\AppPage\Http\Controllers;

use FutureX\AppPage\Models\AppPage;
use Illuminate\Http\Request;

class AppPageController
{
    public function index(Request $request)
    {
        $app = AppPage::where('is_active', true)->first();
        abort_if(is_null($app), 404);
        return view('app-page::index', [
            'app'     => $app,
            'visitId' => $request->session()->get('fx_visit_id'),
        ]);
    }
}
