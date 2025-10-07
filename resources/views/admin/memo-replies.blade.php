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
                {{-- sidebar menu --}}
                @include('components.sidebar')
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="dashboard__section__title">
                            <h4>Memo Replies</h4>
                            <div style="margin-top:8px; display: flex; gap: 8px; align-items: center;">
                                <a href="{{ route('dashboard.message') }}" class="btn btn-sm btn-primary">
                                    <i class="icofont-arrow-left"></i> Back to Memos
                                </a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="dashboard__form">
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
                        <a href="{{ route('dashboard.message') }}" class="btn btn-secondary">
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
                                <h6 class="text-primary">{{ $recipient->campaign->subject }}</h6>
                                <p class="text-muted mb-2">
                                    <i class="icofont-user"></i> From: {{ $recipient->campaign->creator->first_name }} {{ $recipient->campaign->creator->last_name }}
                                </p>
                                <p class="text-muted mb-3">
                                    <i class="icofont-calendar"></i> {{ $recipient->campaign->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                                <div class="memo-content">
                                    {!! nl2br(e($recipient->campaign->message)) !!}
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
                                        <span class="stat-value">{{ $recipient->campaign->reference }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reply Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="icofont-reply"></i> Reply to Memo
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.memo.reply', $recipient->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="message" class="form-label">Your Reply</label>
                                <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" 
                                    rows="4" placeholder="Type your reply here..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="attachments" class="form-label">Attachments (Optional)</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control" multiple 
                                    accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png,.gif">
                                <small class="form-text text-muted">You can upload up to 5 files (max 10MB each)</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="icofont-send"></i> Send Reply
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Replies List -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="icofont-chat"></i> All Replies ({{ $replies->total() }})
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
                                                    @foreach($reply->attachments as $index => $attachment)
                                                        <div class="attachment-item d-flex align-items-center justify-content-between mb-2 p-2 border rounded">
                                                            <div class="d-flex align-items-center">
                                                                <i class="icofont-file me-2"></i>
                                                                <div>
                                                                    <span class="attachment-name">{{ $attachment['name'] }}</span>
                                                                    <br>
                                                                    <small class="attachment-size text-muted">({{ number_format($attachment['size'] / 1024, 1) }} KB)</small>
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('dashboard.memo.reply.download-attachment', ['reply' => $reply->id, 'index' => $index]) }}" 
                                                               class="btn btn-sm btn-primary">
                                                                <i class="icofont-download"></i> Download
                                                            </a>
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
                                <i class="icofont-chat text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No replies yet</h5>
                                <p class="text-muted">Be the first to reply to this memo!</p>
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
    padding: 10px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: white;
    transition: all 0.3s ease;
}

.attachment-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.attachment-name {
    font-weight: 500;
    color: #007bff;
}

.attachment-size {
    font-size: 0.875rem;
}
</style>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
