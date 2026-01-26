<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    /**
     * Display a listing of licenses (view-only for regular users/admins)
     */
    public function index()
    {
        $licenses = License::orderBy('name')->orderBy('created_at')->get();
        
        return view('admin.licenses.index', compact('licenses'));
    }
}
