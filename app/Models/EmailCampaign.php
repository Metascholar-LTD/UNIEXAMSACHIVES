<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailCampaign extends Model
{
    use HasFactory;

    protected $table = 'comm_campaigns';

    protected $fillable = [
        'subject',
        'message',
        'attachments',
        'recipient_type',
        'selected_users',
        'status',
        'scheduled_at',
        'sent_at',
        'total_recipients',
        'sent_count',
        'failed_count',
        'created_by',
        'reference',
        // UIMMS fields
        'memo_status',
        'current_assignee_id',
        'original_sender_id',
        'assigned_to_office',
        'priority',
        'due_date',
        'completed_at',
        'suspended_at',
        'archived_at',
        'workflow_history',
    ];

    protected $casts = [
        'attachments' => 'array',
        'selected_users' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        // UIMMS casts
        'workflow_history' => 'array',
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'suspended_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // UIMMS Relationships
    public function currentAssignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_assignee_id');
    }

    public function originalSender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'original_sender_id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'comm_campaign_id');
    }

    public function sentRecipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'comm_campaign_id')->where('status', 'sent');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(MemoReply::class, 'campaign_id');
    }

    public function getRepliesCountAttribute()
    {
        return $this->replies()->count();
    }

    public function failedRecipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'comm_campaign_id')->where('status', 'failed');
    }

    public function pendingRecipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'comm_campaign_id')->where('status', 'pending');
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->total_recipients === 0) {
            return 0;
        }
        return round(($this->sent_count / $this->total_recipients) * 100, 2);
    }

    public function getSuccessRateAttribute(): float
    {
        $totalSent = $this->sent_count + $this->failed_count;
        if ($totalSent === 0) {
            return 0;
        }
        return round(($this->sent_count / $totalSent) * 100, 2);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecentFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeScheduledForSending($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_at', '<=', now());
    }

    // UIMMS Methods
    public function activeParticipants(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'comm_campaign_id')
                    ->where('is_active_participant', true);
    }

    public function allParticipants(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'comm_campaign_id');
    }

    public function chatMessages()
    {
        return $this->replies()->with('user')->orderBy('created_at', 'asc');
    }

    public function getLastMessageAttribute()
    {
        return $this->replies()->latest()->first();
    }

    public function getActiveParticipantsCountAttribute()
    {
        return $this->activeParticipants()->count();
    }

    public function isActiveParticipant($userId)
    {
        return $this->activeParticipants()->where('user_id', $userId)->exists();
    }

    public function assignTo($userId, $assignedBy, $office = null)
    {
        // Deactivate current active participants EXCEPT the assigner
        $this->activeParticipants()->where('user_id', '!=', $assignedBy)->update(['is_active_participant' => false]);
        
        // Add new assignee as active participant
        $recipient = $this->recipients()->where('user_id', $userId)->first();
        if (!$recipient) {
            $recipient = $this->recipients()->create([
                'user_id' => $userId,
                'status' => 'sent',
                'is_active_participant' => true,
                'assigned_at' => now(),
                'last_activity_at' => now(),
            ]);
        } else {
            $recipient->update([
                'is_active_participant' => true,
                'assigned_at' => now(),
                'last_activity_at' => now(),
            ]);
        }

        // Ensure the assigner (person who made the assignment) remains an active participant
        $assignerRecipient = $this->recipients()->where('user_id', $assignedBy)->first();
        if (!$assignerRecipient) {
            $assignerRecipient = $this->recipients()->create([
                'user_id' => $assignedBy,
                'status' => 'sent',
                'is_active_participant' => true,
                'assigned_at' => now(),
                'last_activity_at' => now(),
            ]);
        } else {
            $assignerRecipient->update([
                'is_active_participant' => true,
                'last_activity_at' => now(),
            ]);
        }

        // Update memo assignment
        $this->update([
            'current_assignee_id' => $userId,
            'assigned_to_office' => $office,
            'memo_status' => 'pending',
        ]);

        // Add to workflow history
        $this->addToWorkflowHistory('assigned', $assignedBy, $userId, $office);

        return $recipient;
    }

    public function assignToMultiple($userIds, $assignedBy, $office = null)
    {
        // Ensure userIds is an array
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }

        // Deactivate current active participants EXCEPT the assigner
        $this->activeParticipants()->where('user_id', '!=', $assignedBy)->update(['is_active_participant' => false]);
        
        $assignedRecipients = [];
        
        // Add all new assignees as active participants
        foreach ($userIds as $userId) {
            $recipient = $this->recipients()->where('user_id', $userId)->first();
            if (!$recipient) {
                $recipient = $this->recipients()->create([
                    'user_id' => $userId,
                    'status' => 'sent',
                    'is_active_participant' => true,
                    'assigned_at' => now(),
                    'last_activity_at' => now(),
                ]);
            } else {
                $recipient->update([
                    'is_active_participant' => true,
                    'assigned_at' => now(),
                    'last_activity_at' => now(),
                ]);
            }
            $assignedRecipients[] = $recipient;
        }

        // Ensure the assigner (person who made the assignment) remains an active participant
        $assignerRecipient = $this->recipients()->where('user_id', $assignedBy)->first();
        if (!$assignerRecipient) {
            $assignerRecipient = $this->recipients()->create([
                'user_id' => $assignedBy,
                'status' => 'sent',
                'is_active_participant' => true,
                'assigned_at' => now(),
                'last_activity_at' => now(),
            ]);
        } else {
            $assignerRecipient->update([
                'is_active_participant' => true,
                'last_activity_at' => now(),
            ]);
        }

        // Update memo assignment - set first assignee as primary (for backward compatibility)
        $firstAssigneeId = !empty($userIds) ? $userIds[0] : null;
        $this->update([
            'current_assignee_id' => $firstAssigneeId,
            'assigned_to_office' => $office,
            'memo_status' => 'pending',
        ]);

        // Add to workflow history with all assignees
        $assigneesList = implode(', ', $userIds);
        $this->addToWorkflowHistory('assigned_multiple', $assignedBy, $assigneesList, $office);

        return $assignedRecipients;
    }

    public function addToWorkflowHistory($action, $userId, $targetUserId = null, $details = null)
    {
        $history = $this->workflow_history ?? [];
        $history[] = [
            'action' => $action,
            'user_id' => $userId,
            'target_user_id' => $targetUserId,
            'details' => $details,
            'timestamp' => now()->toISOString(),
        ];
        
        $this->update(['workflow_history' => $history]);
    }

    public function markAsCompleted($userId)
    {
        $this->update([
            'memo_status' => 'completed',
            'completed_at' => now(),
        ]);

        $this->addToWorkflowHistory('completed', $userId);
    }

    public function markAsSuspended($userId, $reason = null)
    {
        $this->update([
            'memo_status' => 'suspended',
            'suspended_at' => now(),
        ]);

        $this->addToWorkflowHistory('suspended', $userId, null, $reason);
    }

    public function markAsUnsuspended($userId)
    {
        $this->update([
            'memo_status' => 'pending',
            'suspended_at' => null,
        ]);

        $this->addToWorkflowHistory('unsuspended', $userId);
    }

    public function markAsArchived($userId)
    {
        $this->update([
            'memo_status' => 'archived',
            'archived_at' => now(),
        ]);

        $this->addToWorkflowHistory('archived', $userId);
    }

    // UIMMS Scopes
    public function scopeByMemoStatus($query, $status)
    {
        return $query->where('memo_status', $status);
    }

    public function scopePendingMemos($query)
    {
        return $query->where('memo_status', 'pending');
    }

    public function scopeSuspendedMemos($query)
    {
        return $query->where('memo_status', 'suspended');
    }

    public function scopeCompletedMemos($query)
    {
        return $query->where('memo_status', 'completed');
    }

    public function scopeArchivedMemos($query)
    {
        return $query->where('memo_status', 'archived');
    }

    public function scopeAssignedTo($query, $userId)
    {
        return $query->where('current_assignee_id', $userId);
    }

    public function scopeCreatedBy($query, $userId)
    {
        return $query->where('created_by', $userId);
    }

    /**
     * Get the user who suspended this memo
     */
    public function getSuspendedBy()
    {
        if ($this->memo_status !== 'suspended') {
            return null;
        }

        $workflowHistory = $this->workflow_history ?? [];
        
        // Find the most recent 'suspended' action
        foreach (array_reverse($workflowHistory) as $entry) {
            if ($entry['action'] === 'suspended') {
                return $entry['user_id'];
            }
        }

        return null;
    }

    /**
     * Check if the given user can unsuspend this memo
     */
    public function canUnsuspend($userId)
    {
        if ($this->memo_status !== 'suspended') {
            return false;
        }

        $suspendedBy = $this->getSuspendedBy();
        return $suspendedBy && $suspendedBy == $userId;
    }
}