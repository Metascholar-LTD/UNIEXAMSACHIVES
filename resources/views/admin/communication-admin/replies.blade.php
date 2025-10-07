@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="dashboard__inner">
                <div class="dashboard__inner__head">
                    <div class="dashboard__inner__head__left">
                        <h2 class="dashboard__inner__head__title">Memo Replies</h2>
                        <p class="dashboard__inner__head__subtitle">View all replies for this memo</p>
                    </div>
                    <div class="dashboard__inner__head__right">
                        <a href="{{ route('admin.communication-admin.index') }}" class="btn btn-secondary">
                            <i class="icofont-arrow-left"></i> Back to Memos
                        </a>
                    </div>
                </div>

                <!-- Original Memo Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="icofont-document"></i> Original Memo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h6 class="text-primary">{{ $campaign->subject }}</h6>
                                <p class="text-muted mb-2">
                                    <i class="icofont-user"></i> From: {{ $campaign->creator->first_name }} {{ $campaign->creator->last_name }}
                                </p>
                                <p class="text-muted mb-3">
                                    <i class="icofont-calendar"></i> {{ $campaign->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                                <div class="memo-content">
                                    {!! nl2br(e($campaign->message)) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="memo-stats">
                                    <div class="stat-item">
                                        <span class="stat-label">Total Replies:</span>
                                        <span class="stat-value">{{ $replies->total() }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Reference:</span>
                                        <span class="stat-value">{{ $campaign->reference }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Recipients:</span>
                                        <span class="stat-value">{{ $campaign->total_recipients }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Replies List -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="icofont-comments"></i> All Replies ({{ $replies->total() }})
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($replies->count() > 0)
                            <div class="replies-list">
                                @foreach($replies as $reply)
                                    <div class="reply-item mb-4 p-3 border rounded">
                                        <div class="reply-header d-flex justify-content-between align-items-start mb-2">
                                            <div class="reply-author">
                                                <h6 class="mb-1">
                                                    <i class="icofont-user"></i> {{ $reply->user->first_name }} {{ $reply->user->last_name }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="icofont-calendar"></i> {{ $reply->created_at->format('M d, Y \a\t h:i A') }}
                                                </small>
                                            </div>
                                            <div class="reply-status">
                                                @if($reply->is_read)
                                                    <span class="badge bg-success">Read</span>
                                                @else
                                                    <span class="badge bg-warning">Unread</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="reply-content mb-3">
                                            {!! nl2br(e($reply->message)) !!}
                                        </div>
                                        
                                        @if($reply->attachments && count($reply->attachments) > 0)
                                            <div class="reply-attachments">
                                                <h6 class="mb-2">Attachments:</h6>
                                                <div class="attachments-list">
                                                    @foreach($reply->attachments as $attachment)
                                                        <div class="attachment-item d-flex align-items-center mb-2">
                                                            <i class="icofont-file me-2"></i>
                                                            <span class="attachment-name">{{ $attachment['name'] }}</span>
                                                            <span class="attachment-size ms-2 text-muted">({{ number_format($attachment['size'] / 1024, 1) }} KB)</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $replies->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="icofont-comments text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No replies yet</h5>
                                <p class="text-muted">No one has replied to this memo yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.memo-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.memo-stats {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.stat-label {
    font-weight: 500;
    color: #6c757d;
}

.stat-value {
    font-weight: 600;
    color: #007bff;
}

.reply-item {
    background: #f8f9fa;
    border-left: 4px solid #28a745 !important;
}

.reply-header {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 10px;
}

.reply-content {
    background: white;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.attachments-list {
    background: white;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

.attachment-item {
    padding: 5px 0;
    border-bottom: 1px solid #f8f9fa;
}

.attachment-item:last-child {
    border-bottom: none;
}

.attachment-name {
    font-weight: 500;
    color: #007bff;
}

.attachment-size {
    font-size: 0.875rem;
}
</style>
@endsection
