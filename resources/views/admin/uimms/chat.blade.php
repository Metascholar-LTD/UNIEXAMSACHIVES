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
                                    <h4>{{ $memo->subject }}</h4>
                                </div>
                                <div class="chat-participants">
                                    @foreach($memo->recipients as $participant)
                                        <img src="{{ $participant->user->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                             alt="{{ $participant->user->first_name }}" 
                                             class="participant-avatar"
                                             title="{{ $participant->user->first_name }} {{ $participant->user->last_name }}">
                                    @endforeach
                                </div>
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
                        <div class="chat-input-container">
                            <form id="chat-form" enctype="multipart/form-data">
                                @csrf
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
    border-radius: 50%;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-right: 8px;
}

.attachment-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.attachment-icon {
    width: 20px;
    height: 20px;
    stroke: #1976d2;
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
    const messageHtml = `
        <div class="message message-sent">
            <div class="message-avatar">
                <img src="${message.user.profile_picture_url || '/profile_pictures/default-profile.png'}" 
                     alt="${message.user.first_name}">
            </div>
            <div class="message-content">
                <div class="message-header">
                    <span class="message-sender">${message.user.first_name} ${message.user.last_name}</span>
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
