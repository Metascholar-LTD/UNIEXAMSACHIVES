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
                            <div class="chat-header-left">
                                <a href="{{ route('dashboard.uimms.portal') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="icofont-arrow-left"></i> Back to Portal
                                </a>
                                <div class="chat-title">
                                    <h4>{{ $memo->subject }}</h4>
                                    <div class="chat-participants">
                                        @foreach($memo->activeParticipants as $participant)
                                            <img src="{{ $participant->user->profile_picture_url ?? asset('profile_pictures/default-profile.png') }}" 
                                                 alt="{{ $participant->user->first_name }}" 
                                                 class="participant-avatar"
                                                 title="{{ $participant->user->first_name }} {{ $participant->user->last_name }}">
                                        @endforeach
                                    </div>
                                </div>
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

                        {{-- Chat Messages Container --}}
                        <div class="chat-container">
                            <div class="chat-messages" id="chat-messages">
                                @foreach($memo->chatMessages as $message)
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
                                <div class="chat-input-wrapper">
                                    <div class="chat-input">
                                        <textarea id="message-input" 
                                                  name="message" 
                                                  placeholder="Type your message..." 
                                                  rows="1" 
                                                  required></textarea>
                                        <div class="chat-input-actions">
                                            <label for="file-input" class="btn btn-sm btn-outline-secondary">
                                                <i class="icofont-paperclip"></i>
                                            </label>
                                            <input type="file" id="file-input" name="attachments[]" multiple style="display: none;">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="icofont-send"></i>
                                            </button>
                                        </div>
                                    </div>
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
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background: #fff;
    border-bottom: 1px solid #e9ecef;
    border-radius: 8px 8px 0 0;
    margin-bottom: 0;
}

.chat-header-left {
    display: flex;
    align-items: center;
    gap: 15px;
}

.chat-title h4 {
    margin: 0;
    color: #333;
}

.chat-participants {
    display: flex;
    gap: 5px;
    margin-top: 5px;
}

.participant-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.chat-header-right {
    display: flex;
    align-items: center;
    gap: 15px;
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
    gap: 10px;
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
    background: #fff;
    border: 1px solid #e9ecef;
    border-top: none;
    border-radius: 0 0 8px 8px;
    padding: 20px;
}

.chat-input-wrapper {
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

.chat-input {
    flex: 1;
    display: flex;
    align-items: flex-end;
    gap: 10px;
    background: #f8f9fa;
    border-radius: 25px;
    padding: 10px 15px;
}

.chat-input textarea {
    flex: 1;
    border: none;
    background: transparent;
    resize: none;
    outline: none;
    font-family: inherit;
    line-height: 1.4;
}

.chat-input-actions {
    display: flex;
    gap: 5px;
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
