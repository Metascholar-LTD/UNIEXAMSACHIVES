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

                <!-- Chat Header Style Memo Info -->
                <div class="chat-header">
                    <div class="chat-header-top">
                        <div class="chat-header-left">
                            <div class="memo-status">
                                <span class="status-badge status-active">
                                    Active Discussion
                                </span>
                            </div>
                        </div>
                        <div class="chat-header-right">
                            <div class="memo-stats-inline">
                                <span class="stat-badge">{{ $replies->total() }} Replies</span>
                                <span class="stat-badge">{{ $recipient->campaign->reference }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="chat-header-separator"></div>
                    
                    <div class="chat-header-bottom">
                        <div class="chat-title">
                            <h4>{{ $recipient->campaign->subject }}</h4>
                        </div>
                        <div class="chat-participants">
                            <img src="{{ $recipient->campaign->creator->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                 alt="{{ $recipient->campaign->creator->first_name }}" 
                                 class="participant-avatar"
                                 title="{{ $recipient->campaign->creator->first_name }} {{ $recipient->campaign->creator->last_name }}">
                            <span class="recipients-count">{{ $recipient->campaign->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Memo Details Section -->
                <div class="memo-details-section">
                    <div class="memo-details-content">
                        <div class="memo-details-single-row">
                            <div class="memo-detail-item-inline">
                                <label>From:</label>
                                <span class="memo-sender">
                                    <img src="{{ $recipient->campaign->creator->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                         alt="{{ $recipient->campaign->creator->first_name }}" class="sender-avatar">
                                    {{ $recipient->campaign->creator->first_name }} {{ $recipient->campaign->creator->last_name }}
                                </span>
                            </div>
                            
                            <div class="memo-detail-item-inline">
                                <label>Created:</label>
                                <span class="memo-date">{{ $recipient->campaign->created_at->format('M d, Y H:i') }}</span>
                            </div>
                            
                            <div class="memo-detail-item-inline">
                                <label>Reference:</label>
                                <span class="memo-reference">{{ $recipient->campaign->reference }}</span>
                            </div>
                        </div>
                        
                        @if($recipient->campaign->message)
                        <div class="memo-details-row">
                            <div class="memo-detail-item full-width">
                                <label>Message:</label>
                                <div class="memo-message-content">
                                    {!! $recipient->campaign->message !!}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($recipient->campaign->attachments && count($recipient->campaign->attachments) > 0)
                        <div class="memo-details-row">
                            <div class="memo-detail-item full-width">
                                <label>Attachments:</label>
                                <div class="memo-attachments">
                                    @foreach($recipient->campaign->attachments as $index => $attachment)
                                        <div class="attachment-item">
                                            <div class="attachment-icon">
                                                @if(str_contains($attachment['type'], 'image'))
                                                    <i class="icofont-image"></i>
                                                @elseif(str_contains($attachment['type'], 'pdf'))
                                                    <i class="icofont-file-pdf"></i>
                                                @elseif(str_contains($attachment['type'], 'word'))
                                                    <i class="icofont-file-document"></i>
                                                @elseif(str_contains($attachment['type'], 'excel') || str_contains($attachment['type'], 'spreadsheet'))
                                                    <i class="icofont-file-excel"></i>
                                                @else
                                                    <i class="icofont-file"></i>
                                                @endif
                                            </div>
                                            <div class="attachment-info">
                                                <span class="attachment-name">{{ $attachment['name'] }}</span>
                                                <span class="attachment-size">{{ number_format($attachment['size'] / 1024, 1) }} KB</span>
                                            </div>
                                            <div class="attachment-actions">
                                                <a href="{{ route('dashboard.memo.attachment.view', ['campaign' => $recipient->campaign->id, 'index' => $index]) }}" 
                                                   class="attachment-view" 
                                                   target="_blank" 
                                                   title="View {{ $attachment['name'] }}">
                                                    <i class="icofont-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.memo.attachment.download', ['campaign' => $recipient->campaign->id, 'index' => $index]) }}" 
                                                   class="attachment-download" 
                                                   title="Download {{ $attachment['name'] }}">
                                                    <i class="icofont-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>


                <!-- Chat Messages Container -->
                <div class="chat-container">
                    <div class="chat-messages" id="chat-messages">
                        @if($replies->count() > 0)
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
                                                            <img src="{{ route('dashboard.memo.reply.view-attachment', ['reply' => $reply->id, 'index' => $index]) }}" 
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
                        @else
                            <div class="text-center py-5">
                                <i class="icofont-chat text-muted" style="font-size: 3rem;"></i>
                                <h5 class="text-muted mt-3">No replies yet</h5>
                                <p class="text-muted">Be the first to reply to this memo!</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($replies->count() > 0)
                <div class="d-flex justify-content-center mt-3">
                    {{ $replies->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Chat Header Styles */
.chat-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 8px 8px 0 0;
    margin-bottom: 0;
    padding: 0;
}

.chat-header-top {
    padding: 20px 20px 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.chat-header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.chat-header-separator {
    height: 1px;
    background: #e9ecef;
    margin: 0 20px;
}

.chat-header-bottom {
    padding: 15px 20px 20px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-title {
    display: flex;
    align-items: center;
    gap: 8px;
}

.chat-title h4 {
    margin: 0;
    color: #333;
    font-size: 1.1rem;
    font-weight: 600;
}

.chat-participants {
    display: flex;
    gap: 6px;
    align-items: center;
}

.participant-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.recipients-count {
    color: #1976d2;
    font-weight: 500;
    background: #e3f2fd;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    margin-left: 8px;
    white-space: nowrap;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-active { 
    background: #e8f5e8; 
    color: #388e3c; 
}

.memo-stats-inline {
    display: flex;
    gap: 8px;
    align-items: center;
}

.stat-badge {
    background: #e3f2fd;
    color: #1976d2;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Memo Details Section */
.memo-details-section {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
}

.memo-details-content {
    padding: 20px;
}

.memo-details-row {
    display: flex;
    gap: 30px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.memo-details-row:last-child {
    margin-bottom: 0;
}

.memo-details-single-row {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    flex-wrap: wrap;
    align-items: center;
}

.memo-detail-item-inline {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
}

.memo-detail-item-inline label {
    display: inline-block;
    font-weight: 600;
    color: #2c3e50;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    font-size: 0.75rem;
    margin-bottom: 0;
    margin-right: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 4px 8px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.memo-detail-item {
    flex: 1;
    min-width: 200px;
}

.memo-detail-item.full-width {
    flex: 100%;
    min-width: 100%;
}

.memo-detail-item label {
    display: inline-block;
    font-weight: 600;
    color: #2c3e50;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    font-size: 0.75rem;
    margin-bottom: 5px;
    margin-right: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 4px 8px;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.memo-sender, .memo-assignee {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    color: #333;
}

.sender-avatar, .assigner-avatar, .assignee-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #e9ecef;
}

.memo-date {
    color: #666;
    font-size: 0.9rem;
}

.memo-reference {
    color: #1976d2;
    font-weight: 500;
    background: #e3f2fd;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
}

.memo-message-content {
    background: #F0F7FF;
    border: 1px solid #e9ecef;
    border-radius: 6px;
    padding: 15px;
    color: #333;
    line-height: 1.6;
    font-size: 0.95rem;
}

.memo-attachments {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.attachment-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.attachment-item:hover {
    background: #e9ecef;
    border-color: #dee2e6;
}

.attachment-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #1976d2;
    color: white;
    border-radius: 8px;
    font-size: 1.2rem;
}

.attachment-info {
    flex: 1;
    min-width: 0;
}

.attachment-name {
    display: block;
    font-weight: 500;
    color: #333;
    font-size: 0.9rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.attachment-size {
    display: block;
    color: #666;
    font-size: 0.8rem;
    margin-top: 2px;
}

.attachment-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.attachment-view,
.attachment-download {
    color: #1976d2;
    font-size: 1.1rem;
    padding: 8px;
    border-radius: 6px;
    transition: all 0.2s ease;
    text-decoration: none;
}

.attachment-view:hover,
.attachment-download:hover {
    background: #e3f2fd;
    color: #1565c0;
}

/* Chat Container Styles */
.chat-container {
    background: #fff;
    border: 1px solid #e9ecef;
    border-top: none;
    height: 400px;
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
// Download image function
function downloadImage(downloadUrl, fileName) {
    console.log('Download function called with:', downloadUrl, fileName);
    
    // Prevent event bubbling
    event.preventDefault();
    event.stopPropagation();
    
    // Prevent multiple simultaneous downloads
    if (window.downloadInProgress) {
        console.log('Download already in progress, ignoring click');
        return;
    }
    
    window.downloadInProgress = true;
    
    try {
        // Create a temporary link element for download
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.download = fileName || 'image';
        link.style.display = 'none';
        
        // Append to body, click, and remove
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        console.log('Download initiated successfully');
        
        // Reset the flag after a short delay
        setTimeout(() => {
            window.downloadInProgress = false;
        }, 1000);
        
    } catch (e) {
        console.error('Error downloading image:', e);
        // Reset the flag immediately on error
        window.downloadInProgress = false;
        // Fallback: open in new tab
        window.open(downloadUrl, '_blank');
    }
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
