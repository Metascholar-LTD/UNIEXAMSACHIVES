<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SystemDocumentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminSystemDocumentationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role === 'employee') {
                return redirect()->route('dashboard.system-documentation')
                    ->with('error', 'Access denied. Only administrators can manage documents.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of system documentation (with management for admins)
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $documents = SystemDocumentation::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
        
        return view('admin.system-documentation.manage', compact('documents'));
    }

    /**
     * Store a newly created documentation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
            $destinationPath = 'system-documentation';
            $file->move(public_path($destinationPath), $fileName);
            
            $filePath = $destinationPath . '/' . $fileName;
            $fileType = strtolower($file->getClientOriginalExtension());
            $fileSize = $this->formatBytes($file->getSize());

            SystemDocumentation::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'file_path' => $filePath,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'created_by' => Auth::id(),
            ]);

            return redirect()->route('dashboard.system-documentation.manage')
                ->with('success', 'Document uploaded successfully.');
        }

        return redirect()->route('dashboard.system-documentation.manage')
            ->with('error', 'Failed to upload document.');
    }

    /**
     * Update the specified documentation
     */
    public function update(Request $request, $id)
    {
        $document = SystemDocumentation::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $document->title = $validated['title'];
        $document->description = $validated['description'];

        // Handle file replacement if new file is uploaded
        if ($request->hasFile('document_file')) {
            // Delete old file
            $oldFilePath = public_path($document->file_path);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            // Upload new file
            $file = $request->file('document_file');
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $file->getClientOriginalName());
            $destinationPath = 'system-documentation';
            $file->move(public_path($destinationPath), $fileName);
            
            $document->file_path = $destinationPath . '/' . $fileName;
            $document->file_type = strtolower($file->getClientOriginalExtension());
            $document->file_size = $this->formatBytes($file->getSize());
        }

        $document->save();

        return redirect()->route('dashboard.system-documentation.manage')
            ->with('success', 'Document updated successfully.');
    }

    /**
     * Remove the specified documentation
     */
    public function destroy($id)
    {
        $document = SystemDocumentation::findOrFail($id);
        
        // Delete file from storage
        $filePath = public_path($document->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $documentTitle = $document->title;
        $document->delete();

        return redirect()->route('dashboard.system-documentation.manage')
            ->with('success', "Document '{$documentTitle}' deleted successfully.");
    }

    /**
     * Preview document (for PDFs)
     */
    public function preview($id)
    {
        $document = SystemDocumentation::findOrFail($id);
        
        if (!$document->isPdf()) {
            return redirect()->route('dashboard.system-documentation.manage')
                ->with('error', 'Only PDF files can be previewed.');
        }

        $filePath = public_path($document->file_path);
        
        if (!file_exists($filePath)) {
            return redirect()->route('dashboard.system-documentation.manage')
                ->with('error', 'File not found.');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($document->file_path) . '"'
        ]);
    }

    /**
     * Download document
     */
    public function download($id)
    {
        $document = SystemDocumentation::findOrFail($id);
        
        $filePath = public_path($document->file_path);
        
        if (!file_exists($filePath)) {
            return redirect()->route('dashboard.system-documentation.manage')
                ->with('error', 'File not found.');
        }

        return response()->download($filePath, $document->title . '.' . $document->file_type);
    }

    /**
     * Format bytes to human readable size
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
