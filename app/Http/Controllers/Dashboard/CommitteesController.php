<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteesController extends Controller
{
    /**
     * Check if user has permission to manage committees
     * Only UI "User" users (database role='admin') can manage committees
     */
    private function checkAdminPermission()
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isSuperAdmin()) {
            abort(403, 'Unauthorized access. Only administrators can manage committees and boards.');
        }
    }

    /**
     * Display a listing of committees/boards
     */
    public function index()
    {
        $this->checkAdminPermission();

        $committees = Committee::with('users')->withCount('users')->orderBy('created_at', 'desc')->get();
        $users = User::where('is_approve', true)->orderBy('first_name')->get();
        
        return view('admin.committees.index', compact('committees', 'users'));
    }

    /**
     * Store a newly created committee/board
     */
    public function store(Request $request)
    {
        $this->checkAdminPermission();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Committee::create($request->all());

        return redirect()->route('committees.index')
            ->with('success', 'Committee/Board created successfully.');
    }

    /**
     * Update the specified committee/board
     */
    public function update(Request $request, Committee $committee)
    {
        $this->checkAdminPermission();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $committee->update($request->all());

        return redirect()->route('committees.index')
            ->with('success', 'Committee/Board updated successfully.');
    }

    /**
     * Remove the specified committee/board
     */
    public function destroy(Committee $committee)
    {
        $this->checkAdminPermission();

        $committee->delete();

        return redirect()->route('committees.index')
            ->with('success', 'Committee/Board deleted successfully.');
    }

    /**
     * Add users to a committee/board
     */
    public function addUsers(Request $request, Committee $committee)
    {
        $this->checkAdminPermission();

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $committee->users()->syncWithoutDetaching($request->user_ids);

        return redirect()->back()
            ->with('success', 'Users added to committee/board successfully.');
    }

    /**
     * Remove a user from a committee/board
     */
    public function removeUser(Committee $committee, User $user)
    {
        $this->checkAdminPermission();

        $committee->users()->detach($user->id);

        return redirect()->back()
            ->with('success', 'User removed from committee/board successfully.');
    }
}

