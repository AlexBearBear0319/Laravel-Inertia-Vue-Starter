<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //check if user is suspended
        $listings = 
            $request->user()->role !== 'suspended' ?
            $request->user()->listings()->latest()->paginate(10) :
            null;

        return Inertia::render('Dashboard', [
            'listings' => $listings,
            'status' => session('status')
        ]);
    }
}
