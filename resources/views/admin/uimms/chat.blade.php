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
                        {{-- Chat Header --}}
                        <div class="chat-header">
                            {{-- Top Section: Buttons --}}
                            <div class="chat-header-top">
                            <div class="chat-header-left">
                                    <a href="{{ route('dashboard.uimms.portal') }}" class="responsive-btn back-btn">
                                        <div class="svgWrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="svgIcon">
                                                <path stroke="#fff" stroke-width="2" d="M19 12H5m7-7-7 7 7 7"></path>
                                            </svg>
                                            <div class="text">Back</div>
                                        </div>
                                    </a>
                            </div>
                            <div class="chat-header-right">
                                <div class="memo-status">
                                    <span class="status-badge status-{{ $memo->memo_status ?? 'pending' }}">
                                        {{ $memo->memo_status ?? 'pending' }}
                                    </span>
                                </div>
                                <div class="chat-actions">
                                    <button class="btn btn-sm btn-outline-primary" onclick="showAssignModal()">
                                        <i class="icofont-user"></i> Assign
                                    </button>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-success" onclick="updateMemoStatus('completed')">
                                            <i class="icofont-check-circled"></i> Complete
                                        </button>
                                        <button class="btn btn-sm btn-outline-warning" onclick="showSuspendModal()">
                                            <i class="icofont-pause"></i> Suspend
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick="updateMemoStatus('archived')">
                                            <i class="icofont-archive"></i> Archive
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Separator Line --}}
                            <div class="chat-header-separator"></div>
                            
                            {{-- Bottom Section: Subject and Participants --}}
                            <div class="chat-header-bottom">
                                <div class="chat-title">
                                    Subject: <h4>{{ $memo->subject }}</h4>
                                </div>
                                <div class="chat-participants">
                                    @foreach($memo->recipients as $participant)
                                        <img src="{{ $participant->user->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                             alt="{{ $participant->user->first_name }}" 
                                             class="participant-avatar"
                                             title="{{ $participant->user->first_name }} {{ $participant->user->last_name }}">
                                    @endforeach
                                    <span class="recipients-count">{{ $memo->recipients->count() }} Recipients</span>
                                </div>
                            </div>
                        </div>

                        {{-- Memo Details Section --}}
                        <div class="memo-details-section">
                            <div class="memo-details-content">
                                <div class="memo-details-single-row">
                                    <div class="memo-detail-item-inline">
                                        <label>From:</label>
                                        <span class="memo-sender">
                                            <img src="{{ $memo->creator->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                                 alt="{{ $memo->creator->first_name }}" class="sender-avatar">
                                            {{ $memo->creator->first_name }} {{ $memo->creator->last_name }}
                                        </span>
                                    </div>
                                    
                                    <div class="memo-detail-item-inline">
                                        <label>Created:</label>
                                        <span class="memo-date">{{ $memo->created_at->format('M d, Y H:i') }}</span>
                                    </div>
                                    
                                    @if($canParticipate && $memo->workflow_history && count($memo->workflow_history) > 0)
                                        @php
                                            $lastAssignment = collect($memo->workflow_history)
                                                ->where('action', 'assigned')
                                                ->sortByDesc('timestamp')
                                                ->first();
                                        @endphp
                                        @if($lastAssignment)
                                            <div class="memo-detail-item-inline">
                                                <label>Assigned By:</label>
                                                <span class="memo-assigner">
                                                    @php
                                                        $assigner = \App\Models\User::find($lastAssignment['user_id']);
                                                    @endphp
                                                    @if($assigner)
                                                        <img src="{{ $assigner->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                                             alt="{{ $assigner->first_name }}" class="assigner-avatar">
                                                        {{ $assigner->first_name }} {{ $assigner->last_name }}
                                                    @else
                                                        <span class="text-muted">Unknown</span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    @endif
                                    
                                    <div class="memo-detail-item-inline">
                                        <label>Assigned To:</label>
                                        <span class="memo-assignee">
                                            @if($memo->currentAssignee)
                                                <img src="{{ $memo->currentAssignee->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                                     alt="{{ $memo->currentAssignee->first_name }}" class="assignee-avatar">
                                                {{ $memo->currentAssignee->first_name }} {{ $memo->currentAssignee->last_name }}
                                            @else
                                                <span class="text-muted">Not assigned</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                @if($memo->message)
                                <div class="memo-details-row">
                                    <div class="memo-detail-item full-width">
                                        <label>Message:</label>
                                        <div class="memo-message-content">
                                            {!! nl2br(e($memo->message)) !!}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($memo->attachments && count($memo->attachments) > 0)
                                <div class="memo-details-row">
                                    <div class="memo-detail-item full-width">
                                        <label>Attachments:</label>
                                        <div class="memo-attachments">
                                            @foreach($memo->attachments as $index => $attachment)
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
                                                        <a href="{{ route('dashboard.uimms.chat.attachment.view', ['memo' => $memo->id, 'index' => $index]) }}" 
                                                           class="attachment-view" 
                                                           target="_blank" 
                                                           title="View {{ $attachment['name'] }}">
                                                            <i class="icofont-eye"></i>
                                                        </a>
                                                        <a href="{{ route('dashboard.uimms.chat.attachment.download', ['memo' => $memo->id, 'index' => $index]) }}" 
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

                        {{-- Chat Messages Container --}}
                        <div class="chat-container">
                            <div class="chat-messages" id="chat-messages">
                                @foreach($memo->replies as $message)
                                    <div class="message {{ $message->user_id === auth()->id() ? 'message-sent' : 'message-received' }}">
                                        <div class="message-avatar">
                                            <img src="{{ $message->user->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                                 alt="{{ $message->user->first_name }}">
                                        </div>
                                        <div class="message-content">
                                            <div class="message-header">
                                                <span class="message-sender">{{ $message->user->first_name }} {{ $message->user->last_name }}</span>
                                                @if($message->reply_mode === 'specific' && $message->specific_recipients)
                                                    @php
                                                        $recipientNames = [];
                                                        foreach($message->specific_recipients as $recipientId) {
                                                            $participant = $memo->active_participants->firstWhere('user.id', $recipientId);
                                                            if($participant) {
                                                                $recipientNames[] = $participant['user']['first_name'] . ' ' . $participant['user']['last_name'];
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="reply-to-indicator">to {{ implode(', ', $recipientNames) }}</span>
                                                @elseif($message->reply_mode === 'all')
                                                    <span class="reply-to-indicator">to All</span>
                                                @endif
                                                <span class="message-time">{{ $message->created_at->format('M d, Y H:i') }}</span>
                                            </div>
                                            <div class="message-text">{!! nl2br(e($message->message)) !!}</div>
                                            @if($message->attachments && count($message->attachments) > 0)
                                                <div class="message-attachments">
                                                    @foreach($message->attachments as $attachment)
                                                        <a href="{{ asset('storage/' . $attachment['path']) }}" 
                                                           class="attachment-link" 
                                                           target="_blank">
                                                            <i class="icofont-paperclip"></i> {{ $attachment['name'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Chat Input --}}
                        @if($canParticipate)
                        <div class="chat-input-container">
                    <!-- Reply Mode Selector -->
                    <div class="reply-mode-selector">
                        <button type="button" class="reply-mode-btn active" data-mode="all">
                            <i class="icofont-users"></i>
                            All
                        </button>
                        <button type="button" class="reply-mode-btn" data-mode="specific">
                            <i class="icofont-user"></i>
                            Comment-to
                        </button>
                        
                        <!-- Inline Recipients Selector (hidden by default) -->
                        <div class="inline-recipients-selector" id="inline-recipients-selector" style="display: none;">
                            <div class="recipients-dropdown">
                                <div class="recipients-input-wrapper">
                                    <input type="text" 
                                           id="recipients-search" 
                                           placeholder="Search or select recipients..." 
                                           autocomplete="off">
                                    <div class="recipients-dropdown-icon">
                                        <i class="icofont-caret-down"></i>
                                    </div>
                                </div>
                                <div class="recipients-dropdown-menu" id="recipients-dropdown-menu">
                                    <!-- Recipients will be populated by JavaScript -->
                                </div>
                            </div>
                            <div class="selected-recipients" id="selected-recipients">
                                <!-- Selected recipients will appear here -->
                            </div>
                        </div>
                    </div>
                    
                            <form id="chat-form" enctype="multipart/form-data">
                                @csrf
                        <input type="hidden" name="reply_mode" id="reply-mode" value="all">
                        <input type="hidden" name="specific_recipients" id="specific-recipients" value="">
                        <div class="telegram-style-input">
                                    <button type="button" class="attachment-btn" onclick="document.getElementById('file-input').click()">
                                        <svg viewBox="0 0 24 24" class="attachment-icon">
                                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66L9.64 16.2a2 2 0 0 1-2.83-2.83l8.49-8.49"></path>
                                        </svg>
                                    </button>
                                    
                                    <div class="input-field-wrapper">
                                        <textarea id="message-input" 
                                                  name="message" 
                                                  placeholder="Type your message..." 
                                                  rows="1" 
                                                  required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="send-btn">
                                        <svg viewBox="0 0 24 24" class="send-icon">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22,2 15,22 11,13 2,9"></polygon>
                                        </svg>
                                    </button>
                                    
                                    <input type="file" id="file-input" name="attachments[]" multiple style="display: none;">
                                </div>
                            </form>
                        </div>
                        @else
                        {{-- Blocked Chat State for Inactive Participants --}}
                        <div class="chat-blocked-container">
                            <div class="chat-blocked-content">
                                <div class="blocked-icon">
                                    <i class="icofont-lock"></i>
                                </div>
                                <div class="blocked-message">
                                    <h4>Chat Assigned</h4>
                                    <p>This memo has been assigned to <strong>{{ $memo->currentAssignee ? $memo->currentAssignee->first_name . ' ' . $memo->currentAssignee->last_name : 'another user' }}</strong>.</p>
                                    <p class="blocked-subtitle">You can no longer participate unless reassigned to you</p>
                                </div>
                                <div class="blocked-actions">
                                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                        <i class="icofont-arrow-left"></i> Back to Portal
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Assignment Modal --}}
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Memo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="assign-form">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Assign to User</label>
                        <select name="assignee_id" class="form-select" required>
                            <option value="">Select a user...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Office/Department (Optional)</label>
                        <input type="text" name="office" class="form-control" placeholder="e.g., Finance Department">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assignment Message (Optional)</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="Add a message explaining the assignment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Assign Memo</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Suspend Modal --}}
<div class="modal fade" id="suspendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Suspend Memo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="suspend-form">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Reason for Suspension</label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Explain why this memo is being suspended..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Suspend Memo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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

.status-pending { background: #e3f2fd; color: #1976d2; }
.status-suspended { background: #fff8e1; color: #f57c00; }
.status-completed { background: #e8f5e8; color: #388e3c; }
.status-archived { background: #f5f5f5; color: #616161; }

.chat-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

/* Assign Button - Neumorphic Style */
.chat-actions .btn-outline-primary {
    background-color: #e4e4e4;
    border: none;
    border-radius: 10px;
    box-shadow: inset 5px 5px 5px #c4c4c4,
                inset -5px -5px 5px #ffffff;
    color: #007bff;
    cursor: pointer;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 13px;
    font-weight: bold;
    margin: 3px;
    padding: 10px 15px;
    text-transform: uppercase;
    transition: all 0.2s ease;
    text-align: center;
    min-width: 80px;
}

.chat-actions .btn-outline-primary:hover {
    background-color: #007bff;
    color: #e4e4e4;
    box-shadow: none;
}

.chat-actions .btn-outline-primary i {
    color: #007bff;
    width: 20px;
    height: 20px;
    margin-right: 5px;
    font-size: 16px;
}

.chat-actions .btn-outline-primary:hover i {
    color: #e4e4e4;
}

/* Neumorphic Button Styling for Complete, Suspend, Archive */
.chat-actions .btn-outline-success,
.chat-actions .btn-outline-warning,
.chat-actions .btn-outline-secondary {
    background-color: #e4e4e4;
    border: none;
    border-radius: 10px;
    box-shadow: inset 5px 5px 5px #c4c4c4,
                inset -5px -5px 5px #ffffff;
    color: #333;
    cursor: pointer;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 13px;
    font-weight: bold;
    margin: 3px;
    padding: 10px 15px;
    text-transform: uppercase;
    transition: all 0.2s ease;
    text-align: center;
    min-width: 80px;
}

.chat-actions .btn-outline-success:hover,
.chat-actions .btn-outline-warning:hover,
.chat-actions .btn-outline-secondary:hover {
    box-shadow: none;
}

.chat-actions .btn-outline-success i,
.chat-actions .btn-outline-warning i,
.chat-actions .btn-outline-secondary i {
    width: 20px;
    height: 20px;
    margin-right: 5px;
    font-size: 16px;
}

/* Complete Button */
.chat-actions .btn-outline-success {
    color: #28a745;
}

.chat-actions .btn-outline-success:hover {
    background-color: #28a745;
    color: #e4e4e4;
}

.chat-actions .btn-outline-success i {
    color: #28a745;
}

.chat-actions .btn-outline-success:hover i {
    color: #e4e4e4;
}

/* Suspend Button */
.chat-actions .btn-outline-warning {
    color: #ffc107;
}

.chat-actions .btn-outline-warning:hover {
    background-color: #ffc107;
    color: #e4e4e4;
}

.chat-actions .btn-outline-warning i {
    color: #ffc107;
}

.chat-actions .btn-outline-warning:hover i {
    color: #e4e4e4;
}

/* Archive Button */
.chat-actions .btn-outline-secondary {
    color: #6c757d;
}

.chat-actions .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #e4e4e4;
}

.chat-actions .btn-outline-secondary i {
    color: #6c757d;
}

.chat-actions .btn-outline-secondary:hover i {
    color: #e4e4e4;
}

/* Responsive Button Styling for Back Button */
.responsive-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 8px 16px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.15);
    transition: all 0.2s ease;
    flex-shrink: 0;
    min-width: 80px;
    text-decoration: none;
}

.responsive-btn:hover {
    text-decoration: none;
}

.responsive-btn:active {
    transform: translate(1px, 1px);
    box-shadow: 1px 1px 6px rgba(0, 0, 0, 0.15);
}

.responsive-btn .svgWrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.responsive-btn .svgIcon {
    width: 14px;
    height: 14px;
}

.responsive-btn .text {
    color: white;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

/* Back Button - Keep Current Grey Color */
.back-btn {
    background: linear-gradient(135deg, #6c757d 0%, #545b62 100%);
}

.back-btn:hover {
    background: linear-gradient(135deg, #545b62 0%, #3d4449 100%);
    box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2);
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
    display: inline-block; /* Badge style for all labels */
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

.memo-detail-item.inline-label label {
    margin-bottom: 0;
}

.memo-subject {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    line-height: 1.4;
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

.memo-recipients-count {
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
    background: #007bff;
    color: white;
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
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.attachment-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 8px;
    background: rgba(255,255,255,0.2);
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.85rem;
}

.chat-input-container {
    background: #f8f9fa;
    border: none;
    border-radius: 0 0 8px 8px;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.chat-input-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text x="10" y="20" font-size="12" fill="rgba(0,0,0,0.03)">x² + y² = r²</text><text x="60" y="40" font-size="10" fill="rgba(0,0,0,0.02)">∫f(x)dx</text><text x="20" y="70" font-size="14" fill="rgba(0,0,0,0.02)">α + β = γ</text><text x="70" y="90" font-size="8" fill="rgba(0,0,0,0.01)">∂/∂x</text></svg>');
    opacity: 0.5;
    pointer-events: none;
}

/* Blocked Chat State Styles */
.chat-blocked-container {
    background: #f8f9fa;
    border: none;
    border-radius: 0 0 8px 8px;
    padding: 40px 20px;
    text-align: center;
    border-top: 1px solid #e9ecef;
}

.chat-blocked-content {
    max-width: 400px;
    margin: 0 auto;
}

.blocked-icon {
    font-size: 3rem;
    color: #6c757d;
    margin-bottom: 20px;
}

.blocked-message h4 {
    color: #495057;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.blocked-message p {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 10px;
}

.blocked-subtitle {
    font-size: 0.9rem;
    color: #868e96;
    font-style: italic;
}

.blocked-actions {
    margin-top: 25px;
}

.blocked-actions .btn {
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.blocked-actions .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Reply Mode Selector */
.reply-mode-selector {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 15px;
    position: relative;
    z-index: 2;
    flex-wrap: wrap;
}

.reply-mode-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 20px;
    color: #333;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.reply-mode-btn:hover {
    background: #e3f2fd;
    border-color: #1976d2;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.reply-mode-btn.active {
    background: #1976d2;
    color: white;
    border-color: #1976d2;
    box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
}

.reply-mode-btn i {
    font-size: 0.9rem;
}

/* Inline Recipients Selector */
.inline-recipients-selector {
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
}

.recipients-dropdown {
    position: relative;
    min-width: 250px;
}

.recipients-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.recipients-input-wrapper input {
    width: 100%;
    padding: 8px 35px 8px 12px;
    border: 2px solid #e3f2fd;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.95);
    font-size: 0.85rem;
    color: #333;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.recipients-input-wrapper input:focus {
    outline: none;
    border-color: #1976d2;
    box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    background: white;
}

.recipients-dropdown-icon {
    position: absolute;
    right: 10px;
    color: #666;
    pointer-events: none;
    transition: transform 0.3s ease;
}

.recipients-dropdown.active .recipients-dropdown-icon {
    transform: rotate(180deg);
}

.recipients-dropdown-menu {
    position: fixed;
    background: white;
    border: 1px solid #e3f2fd;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 9999;
    display: none;
    width: 320px;
}

.recipients-dropdown-menu.dropdown-up {
    /* Positioning will be handled by JavaScript */
}

.recipients-dropdown.active .recipients-dropdown-menu {
    display: block;
    animation: slideDown 0.2s ease-out;
}

.recipients-dropdown.active .recipients-dropdown-menu.dropdown-up {
    animation: slideUp 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.recipient-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f5f5f5;
    min-height: 50px;
    width: 100%;
    box-sizing: border-box;
}

.recipient-option:last-child {
    border-bottom: none;
}

.recipient-option:hover {
    background: #f8f9ff;
}

.recipient-option.selected {
    background: #e3f2fd;
    color: #1976d2;
}

.recipient-option img {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.recipient-option .recipient-info {
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.recipient-option .recipient-name {
    font-weight: 500;
    font-size: 0.85rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

.recipient-option .recipient-email {
    font-size: 0.75rem;
    color: #666;
    margin-top: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.2;
}

.recipient-option .recipient-check {
    color: #1976d2;
    font-size: 0.9rem;
    opacity: 0;
    transition: opacity 0.2s ease;
}

.recipient-option.selected .recipient-check {
    opacity: 1;
}

/* Selected Recipients Display */
.selected-recipients {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    max-width: 300px;
}

.selected-recipient-tag {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px;
    background: #1976d2;
    color: white;
    border-radius: 16px;
    font-size: 0.75rem;
    font-weight: 500;
    animation: slideIn 0.2s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.selected-recipient-tag img {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.selected-recipient-tag .remove-recipient {
    cursor: pointer;
    margin-left: 4px;
    opacity: 0.7;
    transition: opacity 0.2s ease;
}

.selected-recipient-tag .remove-recipient:hover {
    opacity: 1;
}

/* Reply-to Indicator */
.reply-to-indicator {
    background: #e3f2fd;
    color: #1976d2;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    margin: 0 8px;
    border: 1px solid #bbdefb;
}

.telegram-style-input {
    display: flex;
    align-items: center;
    background: #f0f8ff;
    border: 2px solid #e3f2fd;
    border-radius: 25px;
    padding: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 1;
}

.attachment-btn {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-right: 8px;
}

.attachment-btn:hover {
    background: #e9ecef;
    border-color: #dee2e6;
}

.attachment-icon {
    width: 20px;
    height: 20px;
    stroke: #6c757d;
    stroke-width: 2;
    fill: none;
}

.input-field-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    background: transparent;
    border-radius: 20px;
    padding: 8px 12px;
    position: relative;
}

.input-field-wrapper textarea {
    flex: 1;
    border: none;
    background: transparent;
    resize: none;
    outline: none;
    font-size: 14px;
    line-height: 1.4;
    max-height: 120px;
    min-height: 20px;
    color: #333;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.input-field-wrapper textarea::placeholder {
    color: #666;
}


.send-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(25, 118, 210, 0.3);
    margin-left: 8px;
}

.send-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(25, 118, 210, 0.4);
    background: linear-gradient(135deg, #1565c0 0%, #0d47a1 100%);
}

.send-icon {
    width: 20px;
    height: 20px;
    stroke: white;
    stroke-width: 2;
    fill: none;
}

.typing-indicator {
    padding: 10px 20px;
    font-style: italic;
    color: #666;
    font-size: 0.9rem;
}
</style>

<script>
const memoId = {{ $memo->id }};
let messageInterval;

// Auto-resize textarea
document.getElementById('message-input').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

// Reply Mode Functionality
let selectedRecipients = [];
let memoParticipants = [];

// Initialize reply mode functionality
function initializeReplyMode() {
    // Get memo participants from the page data
    memoParticipants = @json($memo->active_participants ?? []);
    
    // Fallback: if active_participants is empty, try to get from recipients
    if (!memoParticipants || memoParticipants.length === 0) {
        memoParticipants = @json($memo->recipients ?? []);
        
        // Transform recipients to match expected format
        if (memoParticipants && memoParticipants.length > 0) {
            memoParticipants = memoParticipants.map(recipient => ({
                user: recipient.user,
                is_active_participant: true
            }));
        }
    }
    
    
    // Set up reply mode button handlers
    document.querySelectorAll('.reply-mode-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const mode = this.dataset.mode;
            setReplyMode(mode);
        });
    });
    
    // Populate recipients list
    populateRecipientsList();
}

function setReplyMode(mode) {
    // Update button states
    document.querySelectorAll('.reply-mode-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-mode="${mode}"]`).classList.add('active');
    
    // Update hidden input
    document.getElementById('reply-mode').value = mode;
    
    // Show/hide inline recipients selector
    const inlineRecipientsSelector = document.getElementById('inline-recipients-selector');
    if (mode === 'specific') {
        inlineRecipientsSelector.style.display = 'flex';
        // Focus on the search input
        setTimeout(() => {
            document.getElementById('recipients-search').focus();
        }, 100);
    } else {
        inlineRecipientsSelector.style.display = 'none';
        selectedRecipients = [];
        updateSpecificRecipientsInput();
        updateSelectedRecipientsDisplay();
    }
}

function populateRecipientsList() {
    const dropdownMenu = document.getElementById('recipients-dropdown-menu');
    dropdownMenu.innerHTML = '';
    
    memoParticipants.forEach(participant => {
        if (participant.user && participant.user.id !== {{ Auth::id() }}) {
            const recipientOption = document.createElement('div');
            recipientOption.className = 'recipient-option';
            recipientOption.dataset.userId = participant.user.id;
            recipientOption.innerHTML = `
                <img src="${participant.user.profile_picture_url || '/profile_pictures/default-profile.png'}" 
                     alt="${participant.user.first_name}">
                <div class="recipient-info">
                    <div class="recipient-name">${participant.user.first_name} ${participant.user.last_name}</div>
                    <div class="recipient-email">${participant.user.email || ''}</div>
                </div>
                <i class="icofont-check recipient-check"></i>
            `;
            
            recipientOption.addEventListener('click', function() {
                toggleRecipientSelection(participant.user.id, this);
            });
            
            dropdownMenu.appendChild(recipientOption);
        }
    });
}

function toggleRecipientSelection(userId, element) {
    const index = selectedRecipients.indexOf(userId);
    if (index > -1) {
        selectedRecipients.splice(index, 1);
        element.classList.remove('selected');
    } else {
        selectedRecipients.push(userId);
        element.classList.add('selected');
    }
    updateSpecificRecipientsInput();
    updateSelectedRecipientsDisplay();
}

function updateSpecificRecipientsInput() {
    document.getElementById('specific-recipients').value = selectedRecipients.join(',');
}

function updateSelectedRecipientsDisplay() {
    const selectedRecipientsContainer = document.getElementById('selected-recipients');
    selectedRecipientsContainer.innerHTML = '';
    
    selectedRecipients.forEach(userId => {
        const participant = memoParticipants.find(p => p.user && p.user.id == userId);
        if (participant) {
            const tag = document.createElement('div');
            tag.className = 'selected-recipient-tag';
            tag.innerHTML = `
                <img src="${participant.user.profile_picture_url || '/profile_pictures/default-profile.png'}" 
                     alt="${participant.user.first_name}">
                <span>${participant.user.first_name}</span>
                <i class="icofont-close remove-recipient" onclick="removeRecipient(${userId})"></i>
            `;
            selectedRecipientsContainer.appendChild(tag);
        }
    });
}

function removeRecipient(userId) {
    const index = selectedRecipients.indexOf(userId);
    if (index > -1) {
        selectedRecipients.splice(index, 1);
        updateSpecificRecipientsInput();
        updateSelectedRecipientsDisplay();
        
        // Update dropdown option
        const option = document.querySelector(`[data-user-id="${userId}"]`);
        if (option) {
            option.classList.remove('selected');
        }
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeReplyMode();
    initializeDropdownFunctionality();
});

function initializeDropdownFunctionality() {
    const searchInput = document.getElementById('recipients-search');
    const dropdown = document.querySelector('.recipients-dropdown');
    const dropdownMenu = document.getElementById('recipients-dropdown-menu');
    
    // Smart positioning function
    function positionDropdown() {
        const inputRect = searchInput.getBoundingClientRect();
        const viewportHeight = window.innerHeight;
        const viewportWidth = window.innerWidth;
        const dropdownHeight = 200; // max-height from CSS
        const dropdownWidth = 320; // fixed width from CSS
        const spaceBelow = viewportHeight - inputRect.bottom;
        const spaceAbove = inputRect.top;
        
        // Calculate horizontal position (center align with input)
        let left = inputRect.left;
        let right = 'auto';
        
        // Adjust if dropdown would go off screen
        if (left + dropdownWidth > viewportWidth) {
            left = 'auto';
            right = viewportWidth - inputRect.right;
        }
        
        // Remove existing positioning classes
        dropdownMenu.classList.remove('dropdown-up');
        
        // Set horizontal position
        dropdownMenu.style.left = typeof left === 'number' ? left + 'px' : left;
        dropdownMenu.style.right = right;
        dropdownMenu.style.width = dropdownWidth + 'px';
        
        // Check if there's enough space below
        if (spaceBelow < dropdownHeight && spaceAbove > spaceBelow) {
            // Position above the input
            dropdownMenu.style.top = (inputRect.top - dropdownHeight - 4) + 'px';
            dropdownMenu.classList.add('dropdown-up');
        } else {
            // Position below the input (default)
            dropdownMenu.style.top = (inputRect.bottom + 4) + 'px';
        }
    }
    
    // Toggle dropdown on input focus/click
    searchInput.addEventListener('focus', function() {
        dropdown.classList.add('active');
        populateRecipientsList();
        // Position dropdown after a short delay to ensure it's rendered
        setTimeout(positionDropdown, 10);
    });
    
    searchInput.addEventListener('click', function() {
        dropdown.classList.add('active');
        populateRecipientsList();
        setTimeout(positionDropdown, 10);
    });
    
    // Reposition on window resize
    window.addEventListener('resize', function() {
        if (dropdown.classList.contains('active')) {
            positionDropdown();
        }
    });
    
    // Reposition on scroll (since we're using fixed positioning)
    window.addEventListener('scroll', function() {
        if (dropdown.classList.contains('active')) {
            positionDropdown();
        }
    });
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const options = dropdownMenu.querySelectorAll('.recipient-option');
        
        options.forEach(option => {
            const name = option.querySelector('.recipient-name').textContent.toLowerCase();
            const email = option.querySelector('.recipient-email').textContent.toLowerCase();
            
            if (name.includes(searchTerm) || email.includes(searchTerm)) {
                option.style.display = 'flex';
            } else {
                option.style.display = 'none';
            }
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
    
    // Prevent dropdown from closing when clicking inside
    dropdownMenu.addEventListener('click', function(e) {
        e.stopPropagation();
    });
}

// Send message
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const messageInput = document.getElementById('message-input');
    
    if (!messageInput.value.trim()) return;
    
    // Show typing indicator
    showTypingIndicator();
    
    fetch(`/dashboard/uimms/chat/${memoId}/message`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            addMessageToChat(data.message);
            messageInput.value = '';
            messageInput.style.height = 'auto';
            hideTypingIndicator();
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        hideTypingIndicator();
        alert('Error sending message. Please try again.');
    });
});

// Add message to chat
function addMessageToChat(message) {
    const messagesContainer = document.getElementById('chat-messages');
    
    // Determine reply mode display
    let replyModeDisplay = '';
    if (message.reply_mode === 'specific' && message.specific_recipients) {
        const recipientIds = message.specific_recipients.split(',');
        const recipientNames = recipientIds.map(id => {
            const participant = memoParticipants.find(p => p.user && p.user.id == id);
            return participant ? `${participant.user.first_name} ${participant.user.last_name}` : 'Unknown';
        });
        replyModeDisplay = `<span class="reply-to-indicator">to ${recipientNames.join(', ')}</span>`;
    } else if (message.reply_mode === 'all') {
        replyModeDisplay = `<span class="reply-to-indicator">to All</span>`;
    }
    
    const messageHtml = `
        <div class="message message-sent">
            <div class="message-avatar">
                <img src="${message.user.profile_picture_url || '/profile_pictures/default-profile.png'}" 
                     alt="${message.user.first_name}">
            </div>
            <div class="message-content">
                <div class="message-header">
                    <span class="message-sender">${message.user.first_name} ${message.user.last_name}</span>
                    ${replyModeDisplay}
                    <span class="message-time">${new Date(message.created_at).toLocaleString()}</span>
                </div>
                <div class="message-text">${message.message.replace(/\n/g, '<br>')}</div>
            </div>
        </div>
    `;
    
    messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
    scrollToBottom();
}

// Show typing indicator
function showTypingIndicator() {
    const messagesContainer = document.getElementById('chat-messages');
    const typingHtml = `
        <div class="typing-indicator" id="typing-indicator">
            <i class="icofont-spinner-alt icofont-spin"></i> Sending message...
        </div>
    `;
    messagesContainer.insertAdjacentHTML('beforeend', typingHtml);
    scrollToBottom();
}

// Hide typing indicator
function hideTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

// Scroll to bottom
function scrollToBottom() {
    const container = document.querySelector('.chat-container');
    container.scrollTop = container.scrollHeight;
}

// Assignment functions
function showAssignModal() {
    new bootstrap.Modal(document.getElementById('assignModal')).show();
}

document.getElementById('assign-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(`/dashboard/uimms/chat/${memoId}/assign`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('assignModal')).hide();
            location.reload(); // Refresh to show new participant
        }
    })
    .catch(error => {
        console.error('Error assigning memo:', error);
        alert('Error assigning memo. Please try again.');
    });
});

// Suspend functions
function showSuspendModal() {
    new bootstrap.Modal(document.getElementById('suspendModal')).show();
}

document.getElementById('suspend-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    formData.append('status', 'suspended');
    
    updateMemoStatus('suspended', formData.get('reason'));
    bootstrap.Modal.getInstance(document.getElementById('suspendModal')).hide();
});

// Update memo status
function updateMemoStatus(status, reason = null) {
    const formData = new FormData();
    formData.append('status', status);
    if (reason) formData.append('reason', reason);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch(`/dashboard/uimms/chat/${memoId}/status`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Refresh to show updated status
        }
    })
    .catch(error => {
        console.error('Error updating status:', error);
        alert('Error updating memo status. Please try again.');
    });
}

// Auto-refresh messages every 5 seconds
messageInterval = setInterval(() => {
    fetch(`/dashboard/uimms/chat/${memoId}/messages`)
        .then(response => response.json())
        .then(messages => {
            // Check if there are new messages and update accordingly
            // This is a simplified version - you might want to implement more sophisticated logic
        })
        .catch(error => console.error('Error refreshing messages:', error));
}, 5000);

// Scroll to bottom on load
window.addEventListener('load', scrollToBottom);

// Clean up interval on page unload
window.addEventListener('beforeunload', () => {
    if (messageInterval) {
        clearInterval(messageInterval);
    }
});
</script>
@endsection
