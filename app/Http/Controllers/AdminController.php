<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

//4.16mins youtube video
class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('listings')
            ->filter(request(['search']))
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/AdminDashboard', [
            'users' => $users,
            'status' => session('status')
        ]);
    }

    public function role(Request $request, User $user){

        $request->validate(['role' => 'string|required']);

        $user->update(['role' => $request->role]);

        return redirect()
            ->route('admin.index')
            ->with('status', "User role changed to {$request->role} successfully.");
    }
}
