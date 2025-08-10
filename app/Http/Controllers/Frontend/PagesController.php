<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Registration;
use Mailjet\LaravelMailjet\Facades\Mailjet;
use \Mailjet\Resources;

class PagesController extends Controller
{
    public function index(Request $request){
        // dd('hey');
        $currentDate = Carbon::now()->toDateString();
        $ipAddress = $request->ip();
        Visit::firstOrCreate(['visited_at' => $currentDate,  'ip_address' => $ipAddress]);
        return view('frontend.pages.login');
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
        return view('frontend.pages.login');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'is_admin' => 1,
            'password' => Hash::make($validatedData['password']),
        ]);

        #send mail to user
        if (env('MAIL_MAILER') == 'mailjet') {
            $mj = Mailjet::getClient();
            $body = [
            'FromEmail' => "support@turnitincompany.com",
            'FromName' => "University Exams Archive System",
            'Subject' => "Registration Successful",
            'MJ-TemplateID' => 6346415,
            'MJ-TemplateLanguage' => true,
            'Recipients' => [['Email' => $request['email']]],
            'Vars' => ["firstname" => $validatedData['first_name']]
            ];
            $response =  $mj->post(Resources::$Email, ['body' => $body]);
        }

        return redirect()->route('frontend.login')->with('success', 'Registration successful, Please wait while your account is been approve');
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !password_verify($credentials['password'], $user->password)) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        if ($user->is_admin && !$user->is_approve) {
            return redirect()->back()->with('error', 'Your account is not yet approved.');
        }

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Login successful');
    }
}
