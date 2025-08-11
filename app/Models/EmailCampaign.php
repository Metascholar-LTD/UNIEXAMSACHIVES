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
        'title',
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
    ];

    protected $casts = [
        'attachments' => 'array',
        'selected_users' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class);
    }

    public function sentRecipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class)->where('status', 'sent');
    }

    public function failedRecipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class)->where('status', 'failed');
    }

    public function pendingRecipients(): HasMany
    {
        return $this->hasMany(EmailCampaignRecipient::class)->where('status', 'pending');
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
}