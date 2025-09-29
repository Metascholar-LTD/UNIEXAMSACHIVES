<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\Approval;
use App\Models\Academic;
use App\Models\Department;
use App\Models\File;
use App\Models\Message;
use App\Models\EmailCampaignRecipient;
use App\Models\EmailCampaign;
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
        $userId = Auth::id();
        $memos = EmailCampaignRecipient::with(['campaign'])
            ->where('user_id', $userId)
            ->orderBy('created_at','desc')
            ->get();

        return view('admin.message',[
            'messages' => $memos,
        ]);
    }

    public function readMemo(EmailCampaignRecipient $recipient)
    {
        abort_unless($recipient->user_id === Auth::id(), 403);
        $recipient->load('campaign');
        
        // Debug: Log the current state
        \Log::info('Reading memo', [
            'recipient_id' => $recipient->id,
            'user_id' => Auth::id(),
            'is_read_before' => $recipient->is_read,
        ]);
        
        // Always mark as read when viewing (force update)
        $updateResult = $recipient->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        
        // Clear any potential cache and reload from database
        $recipient->refresh();
        
        // Debug: Log the result
        \Log::info('Memo update result', [
            'recipient_id' => $recipient->id,
            'update_result' => $updateResult,
            'is_read_after' => $recipient->is_read,
        ]);
        
        return view('admin.view_message', [
            'message' => (object) [
                'id' => $recipient->id,
                'title' => $recipient->campaign->subject,
                'body' => $recipient->campaign->message,
                'created_at' => $recipient->created_at,
                'attachments' => $recipient->campaign->attachments,
            ]
        ]);
    }

    public function markAllMemosRead()
    {
        $userId = Auth::id();
        EmailCampaignRecipient::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back();
    }

    public function markSingleMemoAsRead(EmailCampaignRecipient $recipient)
    {
        abort_unless($recipient->user_id === Auth::id(), 403);
        
        $recipient->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Memo marked as read successfully!');
    }

    public function unreadMemoCount()
    {
        $userId = Auth::id();
        $unreadCount = EmailCampaignRecipient::where('user_id', $userId)
            ->where('is_read', false)
            ->count();
        
        // Debug: Log the API call
        \Log::info('Unread count API called', [
            'user_id' => $userId,
            'unread_count' => $unreadCount,
            'timestamp' => now()->toISOString()
        ]);
        
        return response()->json([
            'unread' => $unreadCount,
            'debug' => [
                'user_id' => $userId,
                'timestamp' => now()->toISOString()
            ]
        ]);
    }

    public function recentMemos()
    {
        $recentMemos = EmailCampaignRecipient::with('campaign')
            ->where('user_id', Auth::id())
            ->orderBy('created_at','desc')
            ->limit(5)
            ->get();

        $memos = $recentMemos->map(function($rm) {
            return [
                'id' => $rm->id,
                'subject' => \Str::limit($rm->campaign->subject, 40),
                'created_at' => $rm->created_at->diffForHumans(),
                'is_read' => $rm->is_read,
                'url' => route('dashboard.memo.read', $rm->id)
            ];
        });

        return response()->json([
            'memos' => $memos
        ]);
    }

    // Debug method - remove this after testing
    public function debugMemos()
    {
        $userId = Auth::id();
        $memos = EmailCampaignRecipient::with('campaign')
            ->where('user_id', $userId)
            ->get();
        
        return response()->json([
            'user_id' => $userId,
            'total_memos' => $memos->count(),
            'unread_memos' => $memos->where('is_read', false)->count(),
            'all_memos' => $memos->map(function($memo) {
                return [
                    'id' => $memo->id,
                    'subject' => $memo->campaign->subject,
                    'is_read' => $memo->is_read,
                    'read_at' => $memo->read_at,
                    'created_at' => $memo->created_at
                ];
            })
        ]);
    }

    public function downloadMemoAttachment(EmailCampaignRecipient $recipient, $index)
    {
        // Ensure the user can only download attachments from their own memos
        abort_unless($recipient->user_id === Auth::id(), 403);
        
        $recipient->load('campaign');
        $attachments = $recipient->campaign->attachments;
        
        // Check if the attachment index is valid
        if (!isset($attachments[$index])) {
            abort(404, 'Attachment not found.');
        }
        
        $attachment = $attachments[$index];
        $filePath = storage_path('app/public/' . $attachment['path']);
        
        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found on server.');
        }
        
        // Return file download response
        return response()->download($filePath, $attachment['name']);
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
            
            // Send password update confirmation email
            $emailSent = false;
            if (env('MAIL_MAILER') == 'resend') {
                try {
                    $resendService = new ResendMailService();
                    
                    $htmlContent = view('mails.password_updated', [
                        'firstname' => $user->first_name,
                        'email' => $user->email
                    ])->render();
                    
                    \Log::info('Attempting to send password update confirmation email', [
                        'user_email' => $user->email,
                        'mail_service' => 'resend'
                    ]);
                    
                    $response = $resendService->sendEmail(
                        $user->email,
                        'Password Updated Successfully - Your Account is Now Secure',
                        $htmlContent,
                        'cug@academicdigital.space'
                    );
                    
                    if ($response['success']) {
                        $emailSent = true;
                        \Log::info('Password update confirmation email sent successfully', [
                            'user_email' => $user->email,
                            'message_id' => $response['message_id'] ?? 'N/A'
                        ]);
                    } else {
                        \Log::error('Failed to send password update confirmation email', [
                            'user_email' => $user->email,
                            'error' => $response['error'] ?? 'Unknown error',
                            'response' => $response
                        ]);
                    }
                } catch (\Exception $e) {
                    \Log::error('Exception while sending password update confirmation email', [
                        'user_email' => $user->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            $message = $emailSent 
                ? 'Password updated successfully! Your account is now more secure. A confirmation email has been sent.'
                : 'Password updated successfully! Your account is now more secure.';
                
            return redirect()->back()->with('success', $message);
            
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
        try {
            // Generate a temporary password for the user (firstname + 5 random numbers)
            $randomNumbers = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
            $temporaryPassword = strtolower($user->first_name) . $randomNumbers;
            
            \Log::info('Starting user approval process', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'temporary_password' => $temporaryPassword
            ]);
            
            // Update user with temporary password and approval status
            $user->update([
                'is_approve' => true,
                'password' => Hash::make($temporaryPassword),
                'password_changed' => false
            ]);
            
            \Log::info('User database updated successfully', [
                'user_id' => $user->id,
                'is_approve' => $user->is_approve,
                'password_changed' => $user->password_changed
            ]);
            
            // Send approval email with credentials
            $emailSent = false;
            if (env('MAIL_MAILER') == 'resend') {
                $resendService = new ResendMailService();
                
                $htmlContent = view('mails.approval', [
                    'firstname' => $user->first_name,
                    'email' => $user->email,
                    'temporaryPassword' => $temporaryPassword
                ])->render();
                
                \Log::info('Attempting to send approval email', [
                    'user_email' => $user->email,
                    'mail_service' => 'resend'
                ]);
                
                $response = $resendService->sendEmail(
                    $user->email,
                    'Account Successfully Approved - Your Login Credentials',
                    $htmlContent,
                    'cug@academicdigital.space'
                );
                
                if ($response['success']) {
                    $emailSent = true;
                    \Log::info('Approval email sent successfully', [
                        'user_email' => $user->email,
                        'message_id' => $response['message_id'] ?? 'N/A'
                    ]);
                } else {
                    \Log::error('Failed to send approval email', [
                        'user_email' => $user->email,
                        'error' => $response['error'] ?? 'Unknown error',
                        'response' => $response
                    ]);
                }
            } else {
                \Log::warning('Mail mailer is not set to resend', [
                    'current_mailer' => env('MAIL_MAILER'),
                    'user_email' => $user->email
                ]);
            }
            
            $message = $emailSent 
                ? 'User approved successfully and credentials sent via email'
                : 'User approved successfully, but email failed to send. Please check logs and notify user manually.';
                
            return redirect()->route('dashboard.users')->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Error during user approval process', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('dashboard.users')->with('error', 'Failed to approve user. Please try again or check the logs.');
        }
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
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('frontend.welcome')->with('success', 'You have been logged out successfully.');
    }
}
