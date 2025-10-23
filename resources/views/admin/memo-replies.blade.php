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
                            <h4>💬 Memo Replies: {{ $recipient->campaign->subject }}</h4>
                            <p class="text-muted mb-3">
                                <i class="icofont-users"></i> All recipients can see these replies
                            </p>
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
                        <p class="dashboard__inner__head__subtitle">View all replies for this memo</p>
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
                        <p class="text-muted mb-2">
                            <i class="icofont-info-circle"></i> Your reply will be visible to all recipients of this memo
                        </p>
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

                <!-- Chat-style Replies List -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="icofont-chat"></i> All Replies ({{ $replies->total() }})
                        </h5>
                        <p class="text-muted mb-0">
                            <i class="icofont-users"></i> All recipients can see these replies
                        </p>
                    </div>
                    <div class="card-body p-0">
                        @if($replies->count() > 0)
                            <div class="chat-container">
                                <div class="chat-messages">
                                    @foreach($replies as $reply)
                                        <div class="message {{ $reply->user_id === auth()->id() ? 'message-sent' : 'message-received' }}">
                                            <div class="message-avatar">
                                                <img src="{{ $reply->user->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                                     alt="{{ $reply->user->first_name }}">
                                            </div>
                                            <div class="message-content">
                                                <div class="message-header">
                                                    <span class="message-sender">{{ $reply->user->first_name }} {{ $reply->user->last_name }}</span>
                                                    <span class="message-time">{{ $reply->created_at->format('M d, Y H:i') }}</span>
                                                </div>
                                                <div class="message-text">{!! nl2br(e($reply->message)) !!}</div>
                                                @if($reply->attachments && count($reply->attachments) > 0)
                                                    <div class="message-attachments">
                                                        @foreach($reply->attachments as $index => $attachment)
                                                            @php
                                                                $isImage = str_contains($attachment['type'] ?? '', 'image');
                                                                $isPdf = str_contains($attachment['type'] ?? '', 'pdf');
                                                                $isWord = str_contains($attachment['type'] ?? '', 'word') || str_contains($attachment['type'] ?? '', 'document');
                                                                $isExcel = str_contains($attachment['type'] ?? '', 'excel') || str_contains($attachment['type'] ?? '', 'spreadsheet');
                                                                $fileSize = isset($attachment['size']) ? number_format($attachment['size'] / 1024, 1) . ' KB' : 'Unknown size';
                                                            @endphp
                                                            
                                                            @if($isImage)
                                                                {{-- Image Attachment - Show preview --}}
                                                                <div class="attachment-image-wrapper" onclick="downloadImage('{{ route('dashboard.memo.reply.download-attachment', ['reply' => $reply->id, 'index' => $index]) }}', '{{ $attachment['name'] }}')">
                                                                    <img src="{{ route('dashboard.memo.reply.download-attachment', ['reply' => $reply->id, 'index' => $index]) }}" 
                                                                         alt="{{ $attachment['name'] }}"
                                                                         class="attachment-image">
                                                                    <div class="image-overlay">
                                                                        <i class="icofont-download"></i>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                {{-- File Attachment - Show file card --}}
                                                                <div class="attachment-file-card">
                                                                    <div class="file-icon">
                                                                        @if($isPdf)
                                                                            <i class="icofont-file-pdf"></i>
                                                                        @elseif($isWord)
                                                                            <i class="icofont-file-document"></i>
                                                                        @elseif($isExcel)
                                                                            <i class="icofont-file-excel"></i>
                                                                        @else
                                                                            <i class="icofont-file-alt"></i>
                                                                        @endif
                                                                    </div>
                                                                    <div class="file-info">
                                                                        <div class="file-name">{{ $attachment['name'] }}</div>
                                                                        <div class="file-size">{{ $fileSize }}</div>
                                                                    </div>
                                                                    <a href="{{ route('dashboard.memo.reply.download-attachment', ['reply' => $reply->id, 'index' => $index]) }}" 
                                                                       class="file-download-btn"
                                                                       title="Download">
                                                                        <i class="icofont-download"></i>
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="d-flex justify-content-center p-3">
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

/* Chat-style Replies Styling */
.chat-container {
    background: #fff;
    border: 1px solid #e9ecef;
    border-top: none;
    height: 500px;
    overflow-y: auto;
    padding: 20px;
}

.chat-messages {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.message {
    display: flex;
    gap: 12px;
    max-width: 70%;
}

.message-sent {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message-received {
    align-self: flex-start;
}

.message-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.message-content {
    background: #f8f9fa;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
}

.message-sent .message-content {
    background: #d1e7dd;
    color: #333;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
    font-size: 0.8rem;
    opacity: 0.8;
}

.message-text {
    line-height: 1.4;
}

.message-attachments {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

/* WhatsApp-style Image Attachment */
.attachment-image-wrapper {
    position: relative;
    max-width: 280px;
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s ease;
}

.attachment-image-wrapper:hover {
    transform: scale(1.02);
}

.attachment-image-wrapper:hover .image-overlay {
    opacity: 1;
}

.attachment-image {
    width: 100%;
    height: auto;
    max-height: 300px;
    object-fit: cover;
    display: block;
    border-radius: 12px;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.image-overlay i {
    color: white;
    font-size: 2rem;
}

/* WhatsApp-style File Attachment */
.attachment-file-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 12px;
    max-width: 300px;
    transition: all 0.2s ease;
}

.message-sent .attachment-file-card {
    background: rgba(0, 0, 0, 0.08);
}

.message-received .attachment-file-card {
    background: rgba(0, 0, 0, 0.05);
}

.file-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border-radius: 50%;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.file-icon .icofont-file-pdf {
    color: #dc3545;
}

.file-icon .icofont-file-document {
    color: #0066cc;
}

.file-icon .icofont-file-excel {
    color: #28a745;
}

.file-icon .icofont-file-alt {
    color: #6c757d;
}

.file-info {
    flex: 1;
    min-width: 0;
}

.file-name {
    font-size: 0.9rem;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}

.file-size {
    font-size: 0.75rem;
    opacity: 0.7;
}

.file-download-btn {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    color: inherit;
    text-decoration: none;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.file-download-btn:hover {
    background: rgba(0, 0, 0, 0.2);
    transform: scale(1.1);
}

.file-download-btn i {
    font-size: 1.1rem;
}
</style>

<script>
function downloadImage(url, filename) {
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
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
