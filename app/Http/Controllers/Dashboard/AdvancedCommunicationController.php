<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\Broadcast;
use App\Models\Communication;
use App\Models\CommunicationAttachment;
use App\Models\CommunicationRecipient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdvancedCommunicationController extends Controller
{
    public function index()
    {
        $communications = Communication::orderByDesc('created_at')->paginate(20);
        return view('admin.comms.index', compact('communications'));
    }

    public function create()
    {
        return view('admin.comms.compose');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body_html' => 'nullable|string',
            'body_text' => 'nullable|string',
            'selection_mode' => 'required|in:all,custom',
            'recipients' => 'array',
            'recipients.*' => 'integer|exists:users,id',
            'attachments.*' => 'file|max:20480',
        ]);

        $communication = null;
        DB::transaction(function () use ($request, $validated, &$communication) {
            $communication = Communication::create([
                'subject' => $validated['subject'],
                'body_html' => $validated['body_html'] ?? null,
                'body_text' => $validated['body_text'] ?? null,
                'selection_mode' => $validated['selection_mode'],
                'sent_by' => Auth::id(),
                'status' => 'queued',
            ]);

            $query = User::query()->where('is_admin', 1)->where('is_approve', 1);
            if ($validated['selection_mode'] === 'custom') {
                $ids = $validated['recipients'] ?? [];
                $query->whereIn('id', $ids);
            }
            $users = $query->get(['id', 'email']);
            foreach ($users as $user) {
                CommunicationRecipient::create([
                    'communication_id' => $communication->id,
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);
            }

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('public/communications');
                    CommunicationAttachment::create([
                        'communication_id' => $communication->id,
                        'path' => $path,
                        'filename' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }
        });

        $this->dispatchSend($communication);

        return redirect()->route('comms.index')->with('success', 'Communication queued and sending started.');
    }

    public function show(Communication $communication)
    {
        $communication->load(['recipients' => function ($q) {
            $q->orderByDesc('id');
        }, 'attachments']);
        return view('admin.comms.show', compact('communication'));
    }

    public function searchUsers(Request $request)
    {
        $q = trim($request->input('q', ''));
        $users = User::query()
            ->where('is_admin', 1)
            ->where('is_approve', 1)
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('first_name', 'like', "%$q%")
                        ->orWhere('last_name', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%");
                });
            })
            ->limit(20)
            ->get(['id', 'first_name', 'last_name', 'email']);

        return response()->json($users);
    }

    private function dispatchSend(Communication $communication): void
    {
        $communication->load(['recipients', 'attachments']);

        foreach ($communication->recipients as $recipient) {
            try {
                $body = $communication->body_html ?? $communication->body_text ?? '';
                $mailable = new Broadcast($communication->subject, $body);
                foreach ($communication->attachments as $attach) {
                    $fullPath = Storage::path($attach->path);
                    $mailable->attach($fullPath, [
                        'as' => $attach->filename,
                        'mime' => $attach->mime,
                    ]);
                }
                Mail::to($recipient->email)->send($mailable);
                $recipient->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } catch (\Throwable $e) {
                $recipient->update([
                    'status' => 'failed',
                    'failed_at' => now(),
                    'error_message' => substr($e->getMessage(), 0, 500),
                ]);
            }
        }

        $failed = $communication->recipients()->where('status', 'failed')->exists();
        $communication->update(['status' => $failed ? 'failed' : 'sent']);
    }
}


