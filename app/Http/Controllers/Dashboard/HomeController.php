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
use Mailjet\LaravelMailjet\Facades\Mailjet;
use \Mailjet\Resources;

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
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ], [
            'profile_picture.image' => 'The profile picture must be an image file.',
            'profile_picture.mimes' => 'The profile picture must be a JPEG, PNG, JPG, or GIF file.',
            'profile_picture.max' => 'The profile picture must not be larger than 2MB.',
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
                        Storage::disk('public')->delete($user->profile_picture);
                    } catch (\Exception $e) {
                        // Log error but continue
                        \Log::warning('Failed to delete old profile picture: ' . $e->getMessage());
                    }
                }

                // Store new profile picture
                $path = $file->store('profile_pictures', 'public');
                $user->profile_picture = $path;
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
        $user->update(['is_approve' => true]);
        // Mail::to($user->email)->send(new Approval());
        if (env('MAIL_MAILER') == 'mailjet') {
            $mj = Mailjet::getClient();
            $body = [
            'FromEmail' => "support@turnitincompany.com",
            'FromName' => "University Exams Archive System",
            'Subject' => "Account Successfully Approved",
            'MJ-TemplateID' => 6346512,
            'MJ-TemplateLanguage' => true,
            'Recipients' => [['Email' => $user->email]],
            ];
            $response =  $mj->post(Resources::$Email, ['body' => $body]);
        }
        return redirect()->route('dashboard.users')->with('success', 'User approved successfully');
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

        return redirect('/');
    }
}
