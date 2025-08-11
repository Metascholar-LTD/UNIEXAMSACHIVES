<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendCampaignEmail;
use App\Mail\CampaignEmail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignRecipient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdvanceCommunicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $campaigns = EmailCampaign::with(['creator', 'recipients'])
                                ->recentFirst()
                                ->paginate(10);

        $totalCampaigns = EmailCampaign::count();
        $sentCampaigns = EmailCampaign::byStatus('sent')->count();
        $pendingCampaigns = EmailCampaign::whereIn('status', ['draft', 'scheduled', 'sending'])->count();
        $totalUsers = User::where('is_approve', true)->count();

        return view('admin.communication.index', compact(
            'campaigns', 
            'totalCampaigns', 
            'sentCampaigns', 
            'pendingCampaigns',
            'totalUsers'
        ));
    }

    public function create()
    {
        $users = User::where('is_approve', true)
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->orderBy('first_name')
                    ->get();

        return view('admin.communication.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:500',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,selected',
            'selected_users' => 'required_if:recipient_type,selected|array',
            'selected_users.*' => 'exists:users,id',
            'attachments.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,jpg,png,gif,zip',
            'send_immediately' => 'boolean',
            'scheduled_at' => 'nullable|required_if:send_immediately,false|date|after:now',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email_attachments', 'public');
                $attachmentPaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType(),
                ];
            }
        }

        // Determine recipients
        $recipients = $request->recipient_type === 'all' 
            ? User::where('is_approve', true)->pluck('id')->toArray()
            : $request->selected_users;

        $status = $request->boolean('send_immediately') ? 'sending' : 'scheduled';
        $scheduledAt = $request->boolean('send_immediately') ? now() : $request->scheduled_at;

        // Create campaign
        $campaign = EmailCampaign::create([
            'title' => $request->title,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachments' => $attachmentPaths,
            'recipient_type' => $request->recipient_type,
            'selected_users' => $request->recipient_type === 'selected' ? $recipients : null,
            'status' => $status,
            'scheduled_at' => $scheduledAt,
            'total_recipients' => count($recipients),
            'created_by' => auth()->id(),
        ]);

        // Create recipient records
        foreach ($recipients as $userId) {
            EmailCampaignRecipient::create([
                'advanced_email_campaign_id' => $campaign->id,
                'user_id' => $userId,
                'status' => 'pending',
            ]);
        }

        // Dispatch email sending job if immediate
        if ($request->boolean('send_immediately')) {
            SendCampaignEmail::dispatch($campaign);
        }

        return redirect()->route('admin.communication.index')
                        ->with('success', 'Email campaign created successfully!');
    }

    public function show(EmailCampaign $campaign)
    {
        $campaign->load(['creator', 'recipients.user']);
        
        return view('admin.communication.show', compact('campaign'));
    }

    public function edit(EmailCampaign $campaign)
    {
        if ($campaign->status !== 'draft') {
            return redirect()->back()->with('error', 'Only draft campaigns can be edited.');
        }

        $users = User::where('is_approve', true)
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->orderBy('first_name')
                    ->get();

        return view('admin.communication.edit', compact('campaign', 'users'));
    }

    public function update(Request $request, EmailCampaign $campaign)
    {
        if ($campaign->status !== 'draft') {
            return redirect()->back()->with('error', 'Only draft campaigns can be updated.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:500',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,selected',
            'selected_users' => 'required_if:recipient_type,selected|array',
            'selected_users.*' => 'exists:users,id',
            'attachments.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,jpg,png,gif,zip',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle new file uploads
        $attachmentPaths = $campaign->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email_attachments', 'public');
                $attachmentPaths[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType(),
                ];
            }
        }

        // Remove old recipients
        $campaign->recipients()->delete();

        // Determine new recipients
        $recipients = $request->recipient_type === 'all' 
            ? User::where('is_approve', true)->pluck('id')->toArray()
            : $request->selected_users;

        // Update campaign
        $campaign->update([
            'title' => $request->title,
            'subject' => $request->subject,
            'message' => $request->message,
            'attachments' => $attachmentPaths,
            'recipient_type' => $request->recipient_type,
            'selected_users' => $request->recipient_type === 'selected' ? $recipients : null,
            'total_recipients' => count($recipients),
        ]);

        // Create new recipient records
        foreach ($recipients as $userId) {
            EmailCampaignRecipient::create([
                'advanced_email_campaign_id' => $campaign->id,
                'user_id' => $userId,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('admin.communication.show', $campaign)
                        ->with('success', 'Campaign updated successfully!');
    }

    public function destroy(EmailCampaign $campaign)
    {
        if ($campaign->status === 'sending') {
            return redirect()->back()->with('error', 'Cannot delete campaign while sending.');
        }

        // Delete attachment files
        if ($campaign->attachments) {
            foreach ($campaign->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $campaign->delete();

        return redirect()->route('admin.communication.index')
                        ->with('success', 'Campaign deleted successfully!');
    }

    public function send(EmailCampaign $campaign)
    {
        if ($campaign->status !== 'draft' && $campaign->status !== 'scheduled') {
            return redirect()->back()->with('error', 'Campaign cannot be sent in current status.');
        }

        $campaign->update([
            'status' => 'sending',
            'scheduled_at' => now(),
        ]);

        SendCampaignEmail::dispatch($campaign);

        return redirect()->back()->with('success', 'Campaign is being sent!');
    }

    public function removeAttachment(EmailCampaign $campaign, $attachmentIndex)
    {
        if ($campaign->status !== 'draft') {
            return response()->json(['error' => 'Only draft campaigns can be modified.'], 400);
        }

        $attachments = $campaign->attachments ?? [];
        
        if (isset($attachments[$attachmentIndex])) {
            // Delete file from storage
            Storage::disk('public')->delete($attachments[$attachmentIndex]['path']);
            
            // Remove from array
            unset($attachments[$attachmentIndex]);
            
            // Re-index array
            $attachments = array_values($attachments);
            
            // Update campaign
            $campaign->update(['attachments' => $attachments]);
            
            return response()->json(['success' => 'Attachment removed successfully.']);
        }

        return response()->json(['error' => 'Attachment not found.'], 404);
    }

    public function downloadAttachment(EmailCampaign $campaign, $attachmentIndex)
    {
        $attachments = $campaign->attachments ?? [];
        
        if (isset($attachments[$attachmentIndex])) {
            $attachment = $attachments[$attachmentIndex];
            $filePath = storage_path('app/public/' . $attachment['path']);
            
            if (file_exists($filePath)) {
                return response()->download($filePath, $attachment['name']);
            }
        }

        return redirect()->back()->with('error', 'Attachment not found.');
    }

    public function getUsersAjax(Request $request)
    {
        $search = $request->get('search', '');
        
        $users = User::where('is_approve', true)
                    ->where(function($query) use ($search) {
                        $query->where('first_name', 'LIKE', "%{$search}%")
                              ->orWhere('last_name', 'LIKE', "%{$search}%")
                              ->orWhere('email', 'LIKE', "%{$search}%");
                    })
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->limit(20)
                    ->get()
                    ->map(function($user) {
                        return [
                            'id' => $user->id,
                            'text' => $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ')'
                        ];
                    });

        return response()->json($users);
    }

    public function statistics()
    {
        $stats = [
            'total_campaigns' => EmailCampaign::count(),
            'sent_campaigns' => EmailCampaign::byStatus('sent')->count(),
            'draft_campaigns' => EmailCampaign::byStatus('draft')->count(),
            'scheduled_campaigns' => EmailCampaign::byStatus('scheduled')->count(),
            'total_emails_sent' => EmailCampaignRecipient::where('status', 'sent')->count(),
            'total_users' => User::where('is_approve', true)->count(),
        ];

        // Get recent campaign activity
        $recentActivity = EmailCampaign::with('creator')
                                    ->recentFirst()
                                    ->limit(5)
                                    ->get();

        // Get monthly statistics
        $monthlyStats = EmailCampaign::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
                                   ->where('created_at', '>=', Carbon::now()->subMonths(12))
                                   ->groupBy('month')
                                   ->orderBy('month')
                                   ->get();

        return view('admin.communication.statistics', compact('stats', 'recentActivity', 'monthlyStats'));
    }
}