<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendCampaignEmail;
use App\Mail\CampaignEmail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignRecipient;
use App\Models\User;
use App\Services\ResendMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class AdvanceCommunicationController extends Controller
{
    private function checkAdminAccess()
    {
        // Inverted: only non-admin users are allowed to access communication pages
        if (!auth()->check() || auth()->user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdminAccess();
        
        // Get filter parameter
        $statusFilter = $request->get('status', 'all');
        
        // Build query based on filter
        $query = EmailCampaign::with(['creator', 'recipients'])->recentFirst();
        
        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }
        
        $campaigns = $query->paginate(10);

        $totalCampaigns = EmailCampaign::count();
        $sentCampaigns = EmailCampaign::byStatus('sent')->count();
        $draftCampaigns = EmailCampaign::byStatus('draft')->count();
        $scheduledCampaigns = EmailCampaign::byStatus('scheduled')->count();
        $sendingCampaigns = EmailCampaign::byStatus('sending')->count();
        $failedCampaigns = EmailCampaign::byStatus('failed')->count();
        $totalUsers = User::where('is_approve', true)->count();

        return view('admin.communication.index', compact(
            'campaigns', 
            'totalCampaigns', 
            'sentCampaigns', 
            'draftCampaigns',
            'scheduledCampaigns',
            'sendingCampaigns',
            'failedCampaigns',
            'totalUsers',
            'statusFilter'
        ));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        $users = User::where('is_approve', true)
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->orderBy('first_name')
                    ->get();

        return view('admin.communication.create', compact('users'));
    }

    public function store(Request $request)
    {
        $this->checkAdminAccess();
        
        // Determine if this is a draft or send action
        $isDraft = $request->input('action') === 'draft';
        
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:500',
            'message' => 'required|string',
            'recipient_type' => 'required|in:all,selected',
            'selected_users' => 'required_if:recipient_type,selected|array',
            'selected_users.*' => 'exists:users,id',
            'attachments.*' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,jpg,png,gif,zip',
            'send_immediately' => 'boolean',
            'scheduled_at' => $isDraft ? 'nullable|date' : 'nullable|required_if:send_immediately,false|date|after:now',
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

        // Get recipients
        $recipientUsers = $request->recipient_type === 'all' 
            ? User::where('is_approve', true)->get()
            : User::whereIn('id', $request->selected_users)->where('is_approve', true)->get();

        // Create campaign
        $campaign = EmailCampaign::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'attachments' => $attachmentPaths,
            'recipient_type' => $request->recipient_type,
            'selected_users' => $request->recipient_type === 'selected' ? $recipientUsers->pluck('id')->toArray() : null,
            'status' => $isDraft ? 'draft' : 'sending',
            'scheduled_at' => $isDraft ? null : ($request->scheduled_at ?? now()),
            'total_recipients' => $recipientUsers->count(),
            'created_by' => auth()->id(),
        ]);

        // If this is a draft, save and return immediately - NO EMAIL PROCESSING
        if ($isDraft) {
            return redirect()->route('admin.communication.index')
                            ->with('success', 'Memo saved as draft successfully!');
        }

        // ONLY EXECUTE EMAIL SENDING LOGIC FOR NON-DRAFT CAMPAIGNS
        // Create recipient records
        foreach ($recipientUsers as $user) {
            EmailCampaignRecipient::create([
                'comm_campaign_id' => $campaign->id,
                'user_id' => $user->id,
                'status' => 'pending',
            ]);
        }
        
        // Send emails directly using ResendMailService (reliable method)
        $sentCount = 0;
        $failedCount = 0;
        $resendService = new ResendMailService();

        foreach ($recipientUsers as $user) {
            try {

                // Generate HTML content for this recipient (like the job does)
                $htmlContent = view('mails.campaign_simple', [
                    'campaign' => $campaign,
                    'user' => $user,
                    'subject' => $campaign->subject,
                    'message' => $campaign->message,
                ])->render();

                // Prepare attachments for Resend API
                $attachments = [];
                if ($campaign->attachments && is_array($campaign->attachments)) {
                    foreach ($campaign->attachments as $attachment) {
                        $filePath = storage_path('app/public/' . $attachment['path']);
                        if (file_exists($filePath)) {
                            $fileContent = file_get_contents($filePath);
                            if ($fileContent !== false) {
                                $attachments[] = [
                                    'filename' => $attachment['name'],
                                    'content' => base64_encode($fileContent),
                                    'type' => $attachment['type'] ?? mime_content_type($filePath),
                                ];
                            }
                        }
                    }
                }
                
                // Send email using ResendMailService directly (proven to work)
                $result = $resendService->sendEmail(
                    $user->email,
                    $campaign->subject,
                    $htmlContent,
                    config('mail.from.address'),
                    $attachments
                );

                if ($result['success']) {
                    // Mark recipient as sent
                    EmailCampaignRecipient::where('comm_campaign_id', $campaign->id)
                        ->where('user_id', $user->id)
                        ->update([
                            'status' => 'sent',
                            'sent_at' => now()
                        ]);
                    
                    $sentCount++;
                    
                } else {
                    // Mark recipient as failed
                    $error = $result['error'] ?? 'Unknown error';
                    EmailCampaignRecipient::where('comm_campaign_id', $campaign->id)
                        ->where('user_id', $user->id)
                        ->update([
                            'status' => 'failed',
                            'error_message' => 'ResendMailService error: ' . $error
                        ]);
                    
                    $failedCount++;
                    
                }
                
                // Rate limiting delay (Resend allows 2 emails per second)
                usleep(500000); // 0.5 second
                
            } catch (Exception $e) {
                // Mark recipient as failed
                EmailCampaignRecipient::where('comm_campaign_id', $campaign->id)
                    ->where('user_id', $user->id)
                    ->update([
                        'status' => 'failed',
                        'error_message' => $e->getMessage()
                    ]);
                
                $failedCount++;
            }
        }

        // Update campaign final status for sent campaigns
        $campaign->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
        ]);

        return redirect()->route('admin.communication.index')
                        ->with('success', "Memo campaign sent successfully! Sent: {$sentCount}, Failed: {$failedCount}")
                        ->with('memo_delivered', true);
    }

    public function show(EmailCampaign $campaign)
    {
        $this->checkAdminAccess();
        
        $campaign->load(['creator', 'recipients.user']);
        
        return view('admin.communication.show', compact('campaign'));
    }

    public function edit(EmailCampaign $campaign)
    {
        $this->checkAdminAccess();
        
        if ($campaign->status !== 'draft') {
            return redirect()->back()->with('error', 'Only draft memos can be edited.');
        }

        $users = User::where('is_approve', true)
                    ->select('id', 'first_name', 'last_name', 'email')
                    ->orderBy('first_name')
                    ->get();

        return view('admin.communication.edit', compact('campaign', 'users'));
    }

    public function update(Request $request, EmailCampaign $campaign)
    {
        $this->checkAdminAccess();
        
        if ($campaign->status !== 'draft') {
            return redirect()->back()->with('error', 'Only draft memos can be updated.');
        }

        $validator = Validator::make($request->all(), [
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
            'subject' => $request->subject,
            'message' => $request->message,
            'attachments' => $attachmentPaths,
            'recipient_type' => $request->recipient_type,
            'selected_users' => $request->recipient_type === 'selected' ? $recipients : null,
            'total_recipients' => count($recipients),
        ]);

        // For drafts, we don't create recipient records until they're ready to send
        // Recipient records will be created when the draft is actually sent

        return redirect()->route('admin.communication.show', $campaign)
                        ->with('success', 'Memo updated successfully!');
    }

    public function destroy(EmailCampaign $campaign)
    {
        $this->checkAdminAccess();

        // Delete attachment files
        if ($campaign->attachments) {
            foreach ($campaign->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $campaign->delete();

        return redirect()->route('admin.communication.index')
                        ->with('success', 'Memo deleted successfully!');
    }

    public function send(EmailCampaign $campaign)
    {
        $this->checkAdminAccess();
        
        if ($campaign->status !== 'draft' && $campaign->status !== 'scheduled') {
            return redirect()->back()->with('error', 'Memo cannot be sent in current status.');
        }

        // Determine recipients based on campaign settings
        $recipientUsers = $campaign->recipient_type === 'all' 
            ? User::where('is_approve', true)->get()
            : User::whereIn('id', $campaign->selected_users)->where('is_approve', true)->get();

        // Ensure recipient records exist (create if draft or missing)
        if ($campaign->status === 'draft' || $campaign->recipients()->count() === 0) {
            foreach ($recipientUsers as $user) {
                EmailCampaignRecipient::firstOrCreate([
                    'comm_campaign_id' => $campaign->id,
                    'user_id' => $user->id,
                ], [
                    'status' => 'pending',
                ]);
            }

            $campaign->update(['total_recipients' => $recipientUsers->count()]);
        }

        // Mark as sending
        $campaign->update([
            'status' => 'sending',
            'scheduled_at' => now(),
        ]);

        // Send emails synchronously (no queue dependency) using ResendMailService
        $sentCount = 0;
        $failedCount = 0;
        $resendService = new ResendMailService();

        foreach ($recipientUsers as $user) {
            try {
                // Generate HTML content for this recipient
                $htmlContent = view('mails.campaign_simple', [
                    'campaign' => $campaign,
                    'user' => $user,
                    'subject' => $campaign->subject,
                    'message' => $campaign->message,
                ])->render();

                // Prepare attachments
                $attachments = [];
                if ($campaign->attachments && is_array($campaign->attachments)) {
                    foreach ($campaign->attachments as $attachment) {
                        $filePath = storage_path('app/public/' . $attachment['path']);
                        if (file_exists($filePath)) {
                            $fileContent = file_get_contents($filePath);
                            if ($fileContent !== false) {
                                $attachments[] = [
                                    'filename' => $attachment['name'],
                                    'content' => base64_encode($fileContent),
                                    'type' => $attachment['type'] ?? mime_content_type($filePath),
                                ];
                            }
                        }
                    }
                }

                // Send email
                $result = $resendService->sendEmail(
                    $user->email,
                    $campaign->subject,
                    $htmlContent,
                    config('mail.from.address'),
                    $attachments
                );

                if ($result['success']) {
                    EmailCampaignRecipient::where('comm_campaign_id', $campaign->id)
                        ->where('user_id', $user->id)
                        ->update([
                            'status' => 'sent',
                            'sent_at' => now()
                        ]);
                    $sentCount++;
                } else {
                    $error = $result['error'] ?? 'Unknown error';
                    EmailCampaignRecipient::where('comm_campaign_id', $campaign->id)
                        ->where('user_id', $user->id)
                        ->update([
                            'status' => 'failed',
                            'error_message' => 'ResendMailService error: ' . $error
                        ]);
                    $failedCount++;
                }

                // Rate limiting delay
                usleep(500000);

            } catch (Exception $e) {
                EmailCampaignRecipient::where('comm_campaign_id', $campaign->id)
                    ->where('user_id', $user->id)
                    ->update([
                        'status' => 'failed',
                        'error_message' => $e->getMessage()
                    ]);
                $failedCount++;
            }
        }

        // Finalize campaign status
        $campaign->update([
            'status' => 'sent',
            'sent_at' => now(),
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
        ]);

        return redirect()->back()->with('success', "Memo campaign sent successfully! Sent: {$sentCount}, Failed: {$failedCount}");
    }

    public function removeAttachment(EmailCampaign $campaign, $attachmentIndex)
    {
        $this->checkAdminAccess();
        
        if ($campaign->status !== 'draft') {
            return response()->json(['error' => 'Only draft emails can be modified.'], 400);
        }

        $attachments = $campaign->attachments ?? [];
        
        if (isset($attachments[$attachmentIndex])) {
            // Delete file from storage
            Storage::disk('public')->delete($attachments[$attachmentIndex]['path']);
            
            // Remove from array
            unset($attachments[$attachmentIndex]);
            
            // Re-index array
            $attachments = array_values($attachments);
            
            // Update email
            $campaign->update(['attachments' => $attachments]);
            
            return response()->json(['success' => 'Attachment removed successfully.']);
        }

        return response()->json(['error' => 'Attachment not found.'], 404);
    }

    public function downloadAttachment(EmailCampaign $campaign, $attachmentIndex)
    {
        $this->checkAdminAccess();
        
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
        $this->checkAdminAccess();
        
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
        $this->checkAdminAccess();
        
        $stats = [
            'total_campaigns' => EmailCampaign::count(),
            'sent_campaigns' => EmailCampaign::byStatus('sent')->count(),
            'draft_campaigns' => EmailCampaign::byStatus('draft')->count(),
            'scheduled_campaigns' => EmailCampaign::byStatus('scheduled')->count(),
            'total_emails_sent' => EmailCampaignRecipient::where('status', 'sent')->count(),
            'total_users' => User::where('is_approve', true)->count(),
        ];

        // Get recent email activity
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