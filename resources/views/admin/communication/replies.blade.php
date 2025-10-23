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
                        
                        {{-- Chat Header --}}
                        <div class="chat-header">
                            {{-- Top Section: Back Button --}}
                            <div class="chat-header-top">
                                <div class="chat-header-left">
                                    <a href="{{ route('admin.communication.index') }}" class="responsive-btn back-btn">
                                        <div class="svgWrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="svgIcon">
                                                <path stroke="#fff" stroke-width="2" d="M19 12H5m7-7-7 7 7 7"></path>
                                            </svg>
                                            <div class="text">Back</div>
                                        </div>
                                    </a>
                                </div>
                                <div class="chat-header-right">
                                    <div class="memo-stats">
                                        <span class="stat-badge">{{ $replies->total() }} Replies</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Separator Line --}}
                            <div class="chat-header-separator"></div>
                            
                            {{-- Bottom Section: Subject and Details --}}
                            <div class="chat-header-bottom">
                                <div class="chat-title">
                                    Subject: <h4>{{ $campaign->subject }}</h4>
                                </div>
                                <div class="chat-details">
                                    <div class="detail-item">
                                        <i class="icofont-user"></i>
                                        <span>From: {{ $campaign->creator->first_name }} {{ $campaign->creator->last_name }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="icofont-calendar"></i>
                                        <span>{{ $campaign->created_at->format('M d, Y \a\t h:i A') }}</span>
                                    </div>
                                    <div class="detail-item">
                                        <i class="icofont-tag"></i>
                                        <span>Ref: {{ $campaign->reference }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Chat Messages Container --}}
                        <div class="chat-container">
                            <div class="chat-messages" id="chat-messages">
                                @if($replies->count() > 0)
                                    @foreach($replies as $reply)
                                        <div class="message message-received">
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
                                                                {{-- Image Attachment - Show as file card with download --}}
                                                                <div class="attachment-file-card">
                                                                    <div class="file-icon">
                                                                        <i class="icofont-image"></i>
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
                                    <div class="no-messages">
                                        <div class="no-messages-icon">
                                            <i class="icofont-chat"></i>
                                        </div>
                                        <h4>No replies yet</h4>
                                        <p>No one has replied to this memo yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

<style>
/* Chat Header Styles */
.chat-header {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow: hidden;
}

.chat-header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.chat-header-left .responsive-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    color: white;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 8px;
    background: rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.chat-header-left .responsive-btn:hover {
    background: rgba(255,255,255,0.3);
    color: white;
}

.chat-header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-badge {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.chat-header-separator {
    height: 1px;
    background: rgba(255,255,255,0.2);
}

.chat-header-bottom {
    padding: 20px;
    background: #f8f9fa;
}

.chat-title h4 {
    margin: 0;
    color: #333;
    font-size: 1.25rem;
}

.chat-details {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 10px;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 0.9rem;
}

.detail-item i {
    color: #007bff;
}

/* Chat Container Styles */
.chat-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    height: 600px;
    display: flex;
    flex-direction: column;
}

.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f9fa;
}

/* Message Styles */
.message {
    display: flex;
    margin-bottom: 20px;
    align-items: flex-start;
    gap: 12px;
}

.message-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.message-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.message-content {
    flex: 1;
    background: white;
    border-radius: 12px;
    padding: 12px 16px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    max-width: 70%;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.message-sender {
    font-weight: 600;
    color: #333;
    font-size: 0.9rem;
}

.message-time {
    color: #999;
    font-size: 0.8rem;
}

.message-text {
    color: #333;
    line-height: 1.5;
    word-wrap: break-word;
}

/* Attachment Styles */
.message-attachments {
    margin-top: 12px;
}

.attachment-file-card {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 12px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.attachment-file-card:hover {
    background: #e9ecef;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.file-icon {
    font-size: 1.5rem;
    color: #007bff;
    margin-right: 12px;
}

.file-info {
    flex: 1;
}

.file-name {
    font-weight: 500;
    color: #333;
    font-size: 0.9rem;
}

.file-size {
    color: #666;
    font-size: 0.8rem;
}

.file-download-btn {
    color: #007bff;
    text-decoration: none;
    padding: 6px;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.file-download-btn:hover {
    background: #007bff;
    color: white;
}

/* No Messages State */
.no-messages {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.no-messages-icon {
    font-size: 4rem;
    color: #ccc;
    margin-bottom: 20px;
}

.no-messages h4 {
    color: #666;
    margin-bottom: 10px;
}

.no-messages p {
    color: #999;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chat-header-top {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .chat-details {
        flex-direction: column;
        gap: 10px;
    }
    
    .message-content {
        max-width: 85%;
    }
    
    .chat-container {
        height: 500px;
    }
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
