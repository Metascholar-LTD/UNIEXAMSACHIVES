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
     * Display a listing of committees/boards
     */
    public function index()
    {
        // Only admin can access
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $committees = Committee::with('users')->withCount('users')->orderBy('created_at', 'desc')->get();
        $users = User::where('is_approve', true)->orderBy('first_name')->get();
        
        return view('admin.committees.index', compact('committees', 'users'));
    }

    /**
     * Store a newly created committee/board
     */
    public function store(Request $request)
    {
        // Only admin can create
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

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
        // Only admin can update
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

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
        // Only admin can delete
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $committee->delete();

        return redirect()->route('committees.index')
            ->with('success', 'Committee/Board deleted successfully.');
    }

    /**
     * Add users to a committee/board
     */
    public function addUsers(Request $request, Committee $committee)
    {
        // Only admin can add users
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

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
        // Only admin can remove users
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized access.');
        }

        $committee->users()->detach($user->id);

        return redirect()->back()
            ->with('success', 'User removed from committee/board successfully.');
    }
}

