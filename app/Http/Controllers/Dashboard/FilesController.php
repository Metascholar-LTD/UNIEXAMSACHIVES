<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'depositor_name' => 'required|string',
            'email' => 'required|string|email',
            'phone_number' => 'required|string',
            'file_title' => 'required|string',
            'file_format' => 'required|string',
            'year_created' => 'required|date',
            'year_deposit' => 'required|date',
            'document_file' => 'required|file',
            'unit' => 'required|string',
        ]);

        if ($request->hasFile('document_file')) {
            $file_path = $request->file('document_file')->store('public/files');
            $validatedData['document_file'] = $file_path;
        }
        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['document_id'] = random_int(1000000000, 9999999999);
        File::create($validatedData);
        return redirect()->route('dashboard')->with('success', 'File has been deposited successfully.');
    }


    public function edit(File $file)
    {
        return view('admin.edit_file', [
            'file' => $file,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'depositor_name' => 'required|string',
            'email' => 'required|string|email',
            'phone_number' => 'required|string',
            'file_title' => 'required|string',
            'file_format' => 'required|string',
            'year_created' => 'required|date',
            'year_deposit' => 'required|date',
            'document_file' => 'nullable|file', // Changed to nullable
            'unit' => 'required|string',
        ]);

        $file = File::findOrFail($id);

        // Handle file update if new file is uploaded
        if ($request->hasFile('document_file')) {
            // Delete old file if it exists
            if ($file->document_file && Storage::exists($file->document_file)) {
                Storage::delete($file->document_file);
            }
            
            // Store new file
            $file_path = $request->file('document_file')->store('public/files');
            $validatedData['document_file'] = $file_path;
        } else {
            // Keep existing file if no new file uploaded
            $validatedData['document_file'] = $file->document_file;
        }

        // Update the file record
        $file->update($validatedData);

        return redirect()->route('dashboard')
            ->with('success', 'File has been updated successfully.');
    }

    public function uploadedFile(){
        return view('admin.files',[
            'files' => File::where('user_id', Auth::id())->get(),
        ]);
    }
    public function allUploadedFile(){
        return view('admin.all_files',[
            'files' => File::all(),
        ]);
    }

    public function approvedFiles(){
        $files = File::where('user_id', Auth::user()->id)
        ->where('is_approve', 1)->get();
        return view('admin.approved_files',compact('files'));
    }

    public function allApprovedFiles(){
        $files = File::where('is_approve', 1)->get();
        return view('admin.all_approved_files',compact('files'));
    }

    public function pendingFiles(){
        $files = File::where('user_id', Auth::user()->id)
        ->where('is_approve', 0)->get();
        return view('admin.pending_files',compact('files'));
    }

    public function allPendingFiles(){
        $files = File::where('is_approve', 0)->get();
        return view('admin.all_pending_files',compact('files'));
    }

    public function approve(File $file)
    {
        $file->update(['is_approve' => true]);

        return redirect()->route('dashboard.all.upload.file')->with('success', 'File approved successfully');
    }

    public function destroy(File $file)
    {
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully');
    }

}
