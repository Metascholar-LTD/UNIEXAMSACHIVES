<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoldersController extends Controller
{
    public function index()
    {
        $folders = Folder::where('user_id', Auth::id())
            ->withCount('files')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.folders.index', compact('folders'));
    }

    public function create()
    {
        return view('admin.folders.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $validatedData['user_id'] = Auth::id();
        
        $folder = Folder::create($validatedData);

        return redirect()->route('dashboard.folders.show', $folder)
            ->with('success', 'Folder created successfully.');
    }

    public function show(Folder $folder)
    {
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to folder.');
        }

        $folder->load('files');
        $availableFiles = File::where('user_id', Auth::id())
            ->where('is_approve', 1)
            ->whereDoesntHave('folders', function ($query) use ($folder) {
                $query->where('folder_id', $folder->id);
            })
            ->get();

        return view('admin.folders.show', compact('folder', 'availableFiles'));
    }

    public function edit(Folder $folder)
    {
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to folder.');
        }

        return view('admin.folders.edit', compact('folder'));
    }

    public function update(Request $request, Folder $folder)
    {
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to folder.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $folder->update($validatedData);

        return redirect()->route('dashboard.folders.show', $folder)
            ->with('success', 'Folder updated successfully.');
    }

    public function destroy(Folder $folder)
    {
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to folder.');
        }

        $folder->delete();

        return redirect()->route('dashboard.folders.index')
            ->with('success', 'Folder deleted successfully.');
    }

    public function addFiles(Request $request, Folder $folder)
    {
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to folder.');
        }

        $validatedData = $request->validate([
            'file_ids' => 'required|array',
            'file_ids.*' => 'exists:files,id',
        ]);

        $files = File::whereIn('id', $validatedData['file_ids'])
            ->where('user_id', Auth::id())
            ->where('is_approve', 1)
            ->get();

        $folder->files()->attach($files->pluck('id'));

        return redirect()->route('dashboard.folders.show', $folder)
            ->with('success', count($files) . ' file(s) added to folder successfully.');
    }

    public function removeFile(Folder $folder, File $file)
    {
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to folder.');
        }

        $folder->files()->detach($file->id);

        return redirect()->route('dashboard.folders.show', $folder)
            ->with('success', 'File removed from folder successfully.');
    }
}