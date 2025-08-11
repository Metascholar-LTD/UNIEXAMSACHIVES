@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<div class="dashboardarea sp_bottom_100">
    <div class="container-fluid full__width__padding">
        <div class="row">
            @include('components.create_section')
        </div>
    </div>
    <div class="dashboard">
        <div class="container-fluid full__width__padding">
            <div class="row">
                @include('components.sidebar')

                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h4>Campaign Details: {{ $campaign->title }}</h4>
                            <div class="dashboard__section__actions">
                                <a href="{{route('admin.communication.index')}}" class="default__button">
                                    <i class="icofont-arrow-left"></i> Back to Campaigns
                                </a>
                                @if($campaign->status === 'draft')
                                    <a href="{{ route('admin.communication.edit', $campaign) }}" class="default__button">
                                        <i class="icofont-edit"></i> Edit Campaign
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="row">
                            <!-- Campaign Information -->
                            <div class="col-xl-8">
                                <div class="dashboard__form__wraper">
                                    <div class="campaign-header">
                                        <div class="campaign-status-badge">
                                            <span class="campaign-status status-{{ $campaign->status }}">
                                                @switch($campaign->status)
                                                    @case('draft')
                                                        <i class="icofont-edit"></i> Draft
                                                        @break
                                                    @case('scheduled')
                                                        <i class="icofont-clock-time"></i> Scheduled
                                                        @break
                                                    @case('sending')
                                                        <i class="icofont-spinner"></i> Sending
                                                        @break
                                                    @case('sent')
                                                        <i class="icofont-check-circled"></i> Sent
                                                        @break
                                                    @case('failed')
                                                        <i class="icofont-close-circled"></i> Failed
                                                        @break
                                                @endswitch
                                            </span>
                                        </div>
                                        
                                        <div class="campaign-meta">
                                            <div class="meta-item">
                                                <i class="icofont-calendar"></i>
                                                <strong>Created:</strong> {{ $campaign->created_at->format('F j, Y \a\t g:i A') }}
                                            </div>
                                            <div class="meta-item">
                                                <i class="icofont-user"></i>
                                                <strong>Created by:</strong> {{ $campaign->creator->first_name }} {{ $campaign->creator->last_name }}
                                            </div>
                                            @if($campaign->scheduled_at)
                                                <div class="meta-item">
                                                    <i class="icofont-clock-time"></i>
                                                    <strong>Scheduled:</strong> {{ $campaign->scheduled_at->format('F j, Y \a\t g:i A') }}
                                                </div>
                                            @endif
                                            @if($campaign->sent_at)
                                                <div class="meta-item">
                                                    <i class="icofont-send-mail"></i>
                                                    <strong>Sent:</strong> {{ $campaign->sent_at->format('F j, Y \a\t g:i A') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="campaign-details">
                                        <div class="detail-section">
                                            <h5><i class="icofont-info-circle"></i> Campaign Information</h5>
                                            <div class="detail-item">
                                                <strong>Subject:</strong>
                                                <p>{{ $campaign->subject }}</p>
                                            </div>
                                            <div class="detail-item">
                                                <strong>Message:</strong>
                                                <div class="message-content">
                                                    {!! nl2br(e($campaign->message)) !!}
                                                </div>
                                            </div>
                                        </div>

                                        @if($campaign->attachments && count($campaign->attachments) > 0)
                                            <div class="detail-section">
                                                <h5><i class="icofont-attachment"></i> Attachments</h5>
                                                <div class="attachments-list">
                                                    @foreach($campaign->attachments as $index => $attachment)
                                                        <div class="attachment-item">
                                                            <div class="attachment-info">
                                                                <i class="icofont-file-alt"></i>
                                                                <span class="attachment-name">{{ $attachment['name'] }}</span>
                                                                <span class="attachment-size">({{ number_format($attachment['size'] / 1024, 1) }} KB)</span>
                                                            </div>
                                                            <div class="attachment-actions">
                                                                <a href="{{ route('admin.communication.download-attachment', [$campaign, $index]) }}" 
                                                                   class="btn btn-sm btn-primary">
                                                                    <i class="icofont-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Recipients Details -->
                                @if($campaign->recipients->isNotEmpty())
                                    <div class="dashboard__form__wraper">
                                        <div class="detail-section">
                                            <h5><i class="icofont-users"></i> Recipients Details</h5>
                                            
                                            <div class="recipients-filters mb-3">
                                                <button class="btn btn-sm btn-outline-primary active" onclick="filterRecipients('all')">
                                                    All ({{ $campaign->recipients->count() }})
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" onclick="filterRecipients('sent')">
                                                    Sent ({{ $campaign->recipients->where('status', 'sent')->count() }})
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" onclick="filterRecipients('pending')">
                                                    Pending ({{ $campaign->recipients->where('status', 'pending')->count() }})
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="filterRecipients('failed')">
                                                    Failed ({{ $campaign->recipients->where('status', 'failed')->count() }})
                                                </button>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-striped recipients-table">
                                                    <thead>
                                                        <tr>
                                                            <th>User</th>
                                                            <th>Email</th>
                                                            <th>Status</th>
                                                            <th>Sent At</th>
                                                            <th>Error Message</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($campaign->recipients as $recipient)
                                                            <tr class="recipient-row" data-status="{{ $recipient->status }}">
                                                                <td>
                                                                    <strong>{{ $recipient->user->first_name }} {{ $recipient->user->last_name }}</strong>
                                                                </td>
                                                                <td>{{ $recipient->user->email }}</td>
                                                                <td>
                                                                    <span class="badge badge-{{ $recipient->status === 'sent' ? 'success' : ($recipient->status === 'failed' ? 'danger' : 'warning') }}">
                                                                        {{ ucfirst($recipient->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    {{ $recipient->sent_at ? $recipient->sent_at->format('M j, Y g:i A') : '-' }}
                                                                </td>
                                                                <td>
                                                                    @if($recipient->error_message)
                                                                        <span class="text-danger" title="{{ $recipient->error_message }}">
                                                                            {{ Str::limit($recipient->error_message, 50) }}
                                                                        </span>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Campaign Statistics -->
                            <div class="col-xl-4">
                                <div class="dashboard__form__wraper">
                                    <h5><i class="icofont-chart-bar-graph"></i> Campaign Statistics</h5>
                                    
                                    <div class="stats-grid">
                                        <div class="stat-item">
                                            <div class="stat-icon">
                                                <i class="icofont-users-alt-3"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="stat-number">{{ $campaign->total_recipients }}</div>
                                                <div class="stat-label">Total Recipients</div>
                                            </div>
                                        </div>

                                        <div class="stat-item">
                                            <div class="stat-icon text-success">
                                                <i class="icofont-check-circled"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="stat-number">{{ $campaign->sent_count }}</div>
                                                <div class="stat-label">Successfully Sent</div>
                                            </div>
                                        </div>

                                        <div class="stat-item">
                                            <div class="stat-icon text-danger">
                                                <i class="icofont-close-circled"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="stat-number">{{ $campaign->failed_count }}</div>
                                                <div class="stat-label">Failed</div>
                                            </div>
                                        </div>

                                        @if($campaign->status === 'sent')
                                            <div class="stat-item">
                                                <div class="stat-icon text-info">
                                                    <i class="icofont-chart-line"></i>
                                                </div>
                                                <div class="stat-content">
                                                    <div class="stat-number">{{ $campaign->success_rate }}%</div>
                                                    <div class="stat-label">Success Rate</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @if($campaign->status === 'sending' || $campaign->status === 'sent')
                                        <div class="progress-section">
                                            <h6>Delivery Progress</h6>
                                            <div class="progress mb-2">
                                                <div class="progress-bar bg-success" 
                                                     style="width: {{ $campaign->progress_percentage }}%"
                                                     aria-valuenow="{{ $campaign->progress_percentage }}" 
                                                     aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                {{ $campaign->sent_count }} of {{ $campaign->total_recipients }} sent 
                                                ({{ $campaign->progress_percentage }}%)
                                            </small>
                                        </div>
                                    @endif

                                    @if(in_array($campaign->status, ['draft', 'scheduled']))
                                        <div class="campaign-actions">
                                            <form method="POST" action="{{ route('admin.communication.send', $campaign) }}" 
                                                  onsubmit="return confirm('Are you sure you want to send this campaign now?')">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block">
                                                    <i class="icofont-send-mail"></i> Send Campaign Now
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    @if($campaign->status !== 'sending')
                                        <div class="danger-zone mt-4">
                                            <h6 class="text-danger">Danger Zone</h6>
                                            <form method="POST" action="{{ route('admin.communication.destroy', $campaign) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this campaign? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="icofont-trash"></i> Delete Campaign
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.campaign-header {
    padding: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    margin-bottom: 30px;
}

.campaign-status-badge {
    margin-bottom: 15px;
}

.campaign-status {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.campaign-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 10px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-section {
    margin-bottom: 30px;
}

.detail-section h5 {
    color: #495057;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

.detail-item {
    margin-bottom: 15px;
}

.detail-item strong {
    display: block;
    margin-bottom: 5px;
    color: #495057;
}

.message-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 4px solid #007bff;
    white-space: pre-wrap;
}

.attachments-list {
    display: grid;
    gap: 10px;
}

.attachment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.attachment-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.attachment-name {
    font-weight: 600;
}

.attachment-size {
    color: #6c757d;
    font-size: 12px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.stat-item {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #dee2e6;
}

.stat-icon {
    font-size: 24px;
    margin-bottom: 10px;
    color: #6c757d;
}

.stat-number {
    font-size: 24px;
    font-weight: bold;
    color: #495057;
}

.stat-label {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.progress-section {
    margin-bottom: 30px;
}

.progress-section h6 {
    margin-bottom: 10px;
    color: #495057;
}

.recipients-filters {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.recipients-filters .btn.active {
    background-color: #007bff;
    color: white;
}

.recipients-table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
}

.danger-zone {
    padding-top: 20px;
    border-top: 1px solid #dee2e6;
}

.danger-zone h6 {
    margin-bottom: 10px;
}

.campaign-actions {
    margin-top: 20px;
}

@media (max-width: 768px) {
    .campaign-meta {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .recipients-filters {
        flex-direction: column;
    }
    
    .recipients-filters .btn {
        width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh for sending campaigns
    @if($campaign->status === 'sending')
        setInterval(function() {
            location.reload();
        }, 10000); // Refresh every 10 seconds
    @endif
    
    // Auto-dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});

function filterRecipients(status) {
    const rows = document.querySelectorAll('.recipient-row');
    const buttons = document.querySelectorAll('.recipients-filters .btn');
    
    // Update button states
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter rows
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection