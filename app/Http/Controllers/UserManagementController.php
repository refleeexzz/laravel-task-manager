<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'unauthorized action.');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->canManageUsers()) {
            abort(403, 'unauthorized action.');
        }

        if ($user->email === 'kabotura000@gmail.com') {
            return redirect()->back()->with('error', 'Cannot change main admin role');
        }

        $validated = $request->validate([
            'role' => 'required|in:admin,editor,reader',
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->back()->with('success', 'User role updated successfully');
    }
}
