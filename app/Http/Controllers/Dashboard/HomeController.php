<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\Approval;
use App\Models\Academic;
use App\Models\Department;
use App\Models\File;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\ResendMailService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function dashboard(){
        $currentTime = Carbon::now();
        $twentyFourHoursAgo = $currentTime->subHours(24);
        $dailyVisitCount = Visit::where('visited_at', '>=', $twentyFourHoursAgo)->count();
        $numberOfExamsToFetch = 2;
        $files = File::all();
        return view('admin.dashboard',[
            'total_papers' => Exam::count(),
            'total_users' => User::count(),
            'total_approved_papers' => Exam::where('is_approve', 1)->count(),
            'total_pending_papers' => Exam::where('is_approve', 0)->count(),
            'dailyVisits' => $dailyVisitCount,
            'totalVisits' => Visit::all()->count(),
            'admin_total_papers' => Exam::where('user_id', Auth::user()->id)->count(),
            'admin_pending_papers' => Exam::where('user_id', Auth::user()->id)->where('is_approve', 0)->count(),
            'admin_approve_papers' => Exam::where('user_id', Auth::user()->id)->where('is_approve', 1)->count(),
            'recentlyUploadedExams' => Exam::orderBy('created_at', 'desc')->take($numberOfExamsToFetch)->get(),
            'total_files' => $files->count(),
            'total_approved_files' => $files->where('is_approve', 1)->count(),
            'total_pending_files' => $files->where('is_approve', 0)->count(),
            'admin_total_files' => File::where('user_id', Auth::user()->id)->count(),
            'admin_pending_files' => File::where('user_id', Auth::user()->id)->where('is_approve', 0)->count(),
            'admin_approve_files' => File::where('user_id', Auth::user()->id)->where('is_approve', 1)->count(),
        ]);
    }

    public function create(){
        return view('admin.deposition_form',[
            'departments' => Department::all(),
            'years' => Academic::all(),
        ]);
    }

    public function createFile(){
        return view('admin.file_form');
    }

    public function document(){
        //super admin
        $allExams = Exam::where('is_approve', 1)->get();
        $files = File::where('is_approve', 1)->get();
        $exams = Exam::where('is_approve', 1)->get();

        if (Auth::user()->is_admin == 1) {
            $allExams = Exam::where(['is_approve' => 1,'user_id' => Auth::user()->id])->get();
            $files = File::where(['is_approve' => 1,'user_id' => Auth::user()->id])->get();
            $exams = Exam::where(['is_approve' => 1,'user_id' => Auth::user()->id])->get();

        }

        $results = [
            'exams' => $allExams,
            'files' => $files,
        ];

        $uniqueFaculties = $exams->pluck('faculty')->unique()->values()->all();
        $uniqueTags = $exams->pluck('tags')->unique()->values()->all();
        $uniqueSemesters = $exams->pluck('semester')->unique()->values()->all();

        return view('admin.documents',[
            'exams' => $results,
            'faculties' => $uniqueFaculties,
            'tags' => $uniqueTags,
            'semesters' => $uniqueSemesters,
            'years' => Exam::select(DB::raw('YEAR(created_at) as year'))->distinct()->pluck('year'),

        ]);
    }

    public function uploadedDocument(){
        $exams = Exam::where('user_id', Auth::user()->id)->get();
        return view('admin.uploaded_documents',compact('exams'));
    }

    public function allUploadedDocument(){
        $exams = Exam::all();
        return view('admin.all_uploaded_documents',compact('exams'));
    }

    public function approvedExams(){
        $exams = Exam::where('user_id', Auth::user()->id)
        ->where('is_approve', 1)->get();
        return view('admin.approved_exams',compact('exams'));
    }

    public function allApprovedExams(){
        $exams = Exam::where('is_approve', 1)->get();
        return view('admin.all_approved_exams',compact('exams'));
    }

    public function pendingExams(){
        $exams = Exam::where('user_id', Auth::user()->id)
        ->where('is_approve', 0)->get();
        return view('admin.pending_exams',compact('exams'));
    }

    public function allPendingExams(){
        $exams = Exam::where('is_approve', 0)->get();
        return view('admin.all_pending_exams',compact('exams'));
    }



    public function message(){
        return view('admin.message',[
            'messages' => Message::all(),
        ]);
    }

    public function profile(){

        return view('admin.profile',[
            'data' => User::findOrFail(Auth::user()->id),
        ]);
    }

    public function settings(){
        return view('admin.settings',[
            'data' => User::findOrFail(Auth::user()->id)
        ]);
    }


    public function updateUserInfo(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ], [
            'profile_picture.image' => 'The profile picture must be an image file.',
            'profile_picture.mimes' => 'The profile picture must be a JPEG, PNG, JPG, or GIF file.',
            'profile_picture.max' => 'The profile picture must not be larger than 5MB.',
        ]);

        try {
            // Fetch authenticated user
            $user = Auth::user();

            // Update user information
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                
                // Additional validation
                if (!$file->isValid()) {
                    return redirect()->back()->withErrors(['profile_picture' => 'The uploaded file is not valid.'])->withInput();
                }

                // Delete old profile picture if exists
                if ($user->profile_picture) {
                    try {
                        $oldPath = public_path('profile_pictures/' . basename($user->profile_picture));
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    } catch (\Exception $e) {
                        // Log error but continue
                        \Log::warning('Failed to delete old profile picture: ' . $e->getMessage());
                    }
                }

                // Generate unique filename
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Store new profile picture in public/profile_pictures directory
                $file->move(public_path('profile_pictures'), $filename);
                $user->profile_picture = $filename;
            }

            // Save user
            $user->save();

            // Refresh the authenticated user session
            Auth::setUser($user);

            return redirect()->back()->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Profile update failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update profile. Please try again.'])->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'The new password confirmation does not match.',
            'new_password.min' => 'The new password must be at least 8 characters.',
        ]);

        try {
            $user = Auth::user();
            
            // Verify current password
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }
            
            // Update password and mark as changed
            $user->update([
                'password' => Hash::make($request->input('new_password')),
                'password_changed' => true
            ]);
            
            return redirect()->back()->with('success', 'Password updated successfully! Your account is now more secure.');
            
        } catch (\Exception $e) {
            \Log::error('Password update failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update password. Please try again.'])->withInput();
        }
    }

    public function createMessage(){
        return view('admin.create_message');
    }

    public function users(){
        return view('admin.users',[
            'users' => User::all(),
        ]);
    }

    public function approve(User $user)
    {
        // Generate a temporary password for the user
        $temporaryPassword = Str::random(10);
        
        // Update user with temporary password and approval status
        $user->update([
            'is_approve' => true,
            'password' => Hash::make($temporaryPassword),
            'password_changed' => false
        ]);
        
        // Send approval email with credentials
        if (env('MAIL_MAILER') == 'resend') {
            $resendService = new ResendMailService();
            
            $htmlContent = view('mails.approval', [
                'firstname' => $user->first_name,
                'email' => $user->email,
                'temporaryPassword' => $temporaryPassword
            ])->render();
            
            $response = $resendService->sendEmail(
                $user->email,
                'Account Successfully Approved - Your Login Credentials',
                $htmlContent,
                'cug@academicdigital.space'
            );
            
            if (!$response['success']) {
                \Log::error('Failed to send approval email', $response);
            }
        }
        
        return redirect()->route('dashboard.users')->with('success', 'User approved successfully and credentials sent via email');
    }

    public function disapprove(User $user)
    {
        $user->update(['is_approve' => false]);

        return redirect()->route('dashboard.users')->with('success', 'User disapproved successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard.users')->with('success', 'User deleted successfully');
    }

    public function requests()
    {
        $requests = User::where('admin_access_requested', true)
                       ->whereNull('admin_access_approved_at')
                       ->orderBy('admin_access_requested_at', 'desc')
                       ->get();

        return view('admin.requests', [
            'requests' => $requests
        ]);
    }

    public function approveAccess(User $user)
    {
        $user->update([
            'admin_access_approved_at' => now(),
            'admin_access_approved_by' => Auth::id(),
            'is_admin' => false  // Change from admin to regular user
        ]);

        // Send approval email
        if (env('MAIL_MAILER') == 'resend') {
            $resendService = new ResendMailService();
            
            $htmlContent = view('mails.access_approved', [
                'firstname' => $user->first_name,
                'email' => $user->email
            ])->render();
            
            $response = $resendService->sendEmail(
                $user->email,
                'Access to Advance Communication System Approved',
                $htmlContent,
                'cug@academicdigital.space'
            );
            
            if (!$response['success']) {
                \Log::error('Failed to send access approval email', $response);
            }
        }

        return redirect()->route('dashboard.requests')->with('success', 'Access request approved successfully. User has been changed from admin to regular user and now has access to the advance communication system. They have been notified via email.');
    }

    public function rejectAccess(User $user)
    {
        $user->update([
            'admin_access_rejected_at' => now(),
            'admin_access_rejected_by' => Auth::id(),
            'admin_access_rejected_reason' => request('rejection_reason', 'No reason provided')
        ]);

        // Send rejection email
        if (env('MAIL_MAILER') == 'resend') {
            $resendService = new ResendMailService();
            
            $htmlContent = view('mails.access_rejected', [
                'firstname' => $user->first_name,
                'email' => $user->email,
                'reason' => request('rejection_reason', 'No reason provided')
            ])->render();
            
            $response = $resendService->sendEmail(
                $user->email,
                'Access to Advance Communication System - Request Status',
                $htmlContent,
                'cug@academicdigital.space'
            );
            
            if (!$response['success']) {
                \Log::error('Failed to send access rejection email', $response);
            }
        }

        return redirect()->route('dashboard.requests')->with('success', 'Access request rejected successfully. User has been notified via email.');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('frontend.welcome')->with('success', 'You have been logged out successfully.');
    }
}
