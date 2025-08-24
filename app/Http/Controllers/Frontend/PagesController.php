<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Registration;
use App\Services\ResendMailService;

class PagesController extends Controller
{
    // New welcome/landing page method
    public function welcome(Request $request){
        $currentDate = Carbon::now()->toDateString();
        $ipAddress = $request->ip();
        Visit::firstOrCreate(['visited_at' => $currentDate,  'ip_address' => $ipAddress]);
        
        return view('frontend.pages.welcome');
    }

    // Keep the old index method for backward compatibility (if needed)
    public function index(Request $request){
        return $this->welcome($request);
    }

    public function about(){
        return view('frontend.pages.about');
    }

    public function news(){
        return view('frontend.pages.news');
    }

    public function leaderships(){
        return view('frontend.pages.leadership');
    }

    public function faqs(){
        return view('frontend.pages.faqs');
    }

    public function login(){
        // Redirect authenticated users to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        $departments = Department::orderBy('name')->get();
        return view('frontend.pages.login', compact('departments'));
    }

    public function adminLogin(){
        // Redirect authenticated users to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        $departments = Department::orderBy('name')->get();
        return view('frontend.pages.admin_login', compact('departments'));
    }

    public function adminLoginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        // Only allow non-admin users (advance communication users) to login through admin route
        if ($user->is_admin) {
            return redirect()->back()->with('error', 'This login portal is only for advance communication system users. Please use the regular login.');
        }

        if (!$user->is_approve) {
            return redirect()->back()->with('error', 'Your account is not yet approved.');
        }

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Login successful');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'is_admin' => 1,
            'password' => Hash::make($validatedData['password']),
            'department_id' => $validatedData['department_id'],
        ]);

        #send mail to user
        if (env('MAIL_MAILER') == 'resend') {
            $resendService = new ResendMailService();
            
            $htmlContent = view('mails.registration', [
                'firstname' => $validatedData['first_name'],
                'email' => $request['email']
            ])->render();
            
            $response = $resendService->sendEmail(
                $request['email'],
                'Registration Successful',
                $htmlContent,
                'cug@academicdigital.space'
            );
            
            if (!$response['success']) {
                \Log::error('Failed to send registration email', $response);
            }
        }

        return redirect()->route('frontend.login')->with('success', 'Registration successful! Please wait while your account is being approved.');
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        // Block advance communication users from using regular login
        if (!$user->is_admin) {
            return redirect()->back()->with('error', 'Advance communication system users must use the admin portal at /admin. Please use that login instead.');
        }

        if ($user->is_admin && !$user->is_approve) {
            return redirect()->back()->with('error', 'Your account is not yet approved.');
        }

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Login successful');
    }
}
