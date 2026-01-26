<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of licenses
     */
    public function index()
    {
        $licenses = License::orderBy('name')->orderBy('created_at')->get();
        
        return view('super-admin.licenses.index', compact('licenses'));
    }

    /**
     * Store a newly created license
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        License::create($validated);

        return redirect()->route('super-admin.system-licences')
            ->with('success', 'License created successfully.');
    }

    /**
     * Update the specified license
     */
    public function update(Request $request, $id)
    {
        $license = License::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $license->update($validated);

        return redirect()->route('super-admin.system-licences')
            ->with('success', 'License updated successfully.');
    }

    /**
     * Toggle license active status
     */
    public function toggleStatus($id)
    {
        $license = License::findOrFail($id);
        $license->is_active = !$license->is_active;
        $license->save();

        $status = $license->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('super-admin.system-licences')
            ->with('success', "License {$status} successfully.");
    }

    /**
     * Remove the specified license
     */
    public function destroy($id)
    {
        $license = License::findOrFail($id);
        $licenseName = $license->name;
        $license->delete();

        return redirect()->route('super-admin.system-licences')
            ->with('success', "License '{$licenseName}' deleted successfully.");
    }
}
