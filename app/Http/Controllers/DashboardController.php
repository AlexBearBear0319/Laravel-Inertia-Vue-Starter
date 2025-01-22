<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $listings = $request->user()->listings()->get();

        return Inertia::render('Dashboard', [
            'listings' => $listings,
        ]);
    }
}
