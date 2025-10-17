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
                        <div class="dashboard__section__title">
                            <h4>📱 Memos Portal - Chat-Based Management</h4>
                            <p class="text-muted mb-3">Real-time memo conversations with assignment workflow</p>
                        </div>

                        {{-- Memo Status Cards --}}
                        <div class="row mb-4">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__card uimms-card pending" onclick="loadMemos('pending')">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-chat"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>💬 Active Chats</h5>
                                            <h3 class="count">{{ $pendingCount }}</h3>
                                            <p>Pending conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__card uimms-card suspended" onclick="loadMemos('suspended')">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-pause"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>⏸️ Suspended</h5>
                                            <h3 class="count">{{ $suspendedCount }}</h3>
                                            <p>Paused conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__card uimms-card completed" onclick="loadMemos('completed')">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-check-circled"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>✅ Completed</h5>
                                            <h3 class="count">{{ $completedCount }}</h3>
                                            <p>Finished conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                                <div class="dashboard__card uimms-card archived" onclick="loadMemos('archived')">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-archive"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>📦 Archive</h5>
                                            <h3 class="count">{{ $archivedCount }}</h3>
                                            <p>Old conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Memos List Container --}}
                        <div class="dashboard__card">
                            <div class="dashboard__card__header">
                                <h5 id="memos-section-title">💬 Active Chats</h5>
                                <div class="dashboard__card__actions">
                                    <button class="btn btn-sm btn-outline-primary" onclick="refreshMemos()">
                                        <i class="icofont-refresh"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="dashboard__card__body">
                                <div id="memos-container">
                                    <div class="text-center py-5">
                                        <i class="icofont-chat" style="font-size: 48px; color: #ddd;"></i>
                                        <p class="text-muted mt-3">Click on a status card above to load memos</p>
                                    </div>
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
.uimms-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.uimms-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.uimms-card.pending {
    border-color: #007bff;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
}

.uimms-card.suspended {
    border-color: #ffc107;
    background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
}

.uimms-card.completed {
    border-color: #28a745;
    background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
}

.uimms-card.archived {
    border-color: #6c757d;
    background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
}

.dashboard__card__content {
    display: flex;
    align-items: center;
    padding: 20px;
}

.dashboard__card__icon {
    font-size: 48px;
    margin-right: 20px;
    opacity: 0.8;
}

.dashboard__card__text h5 {
    margin: 0 0 10px 0;
    font-weight: 600;
}

.dashboard__card__text h3 {
    margin: 0 0 5px 0;
    font-size: 2.5rem;
    font-weight: 700;
}

.dashboard__card__text p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.memo-item {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.memo-item:hover {
    border-color: #007bff;
    box-shadow: 0 4px 12px rgba(0,123,255,0.15);
}

.memo-item.active {
    border-color: #007bff;
    background-color: #f8f9ff;
}

.memo-header {
    padding: 15px;
    border-bottom: 1px solid #e9ecef;
}

.memo-participants {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.participant-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.memo-subject {
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.memo-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: #666;
}

.memo-status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-pending { background: #e3f2fd; color: #1976d2; }
.status-suspended { background: #fff8e1; color: #f57c00; }
.status-completed { background: #e8f5e8; color: #388e3c; }
.status-archived { background: #f5f5f5; color: #616161; }
</style>

<script>
let currentStatus = null;

function loadMemos(status) {
    currentStatus = status;
    
    // Update active card
    document.querySelectorAll('.uimms-card').forEach(card => {
        card.classList.remove('active');
    });
    document.querySelector(`.uimms-card.${status}`).classList.add('active');
    
    // Update section title
    const titles = {
        'pending': '💬 Active Chats',
        'suspended': '⏸️ Suspended Conversations',
        'completed': '✅ Completed Conversations',
        'archived': '📦 Archived Conversations'
    };
    document.getElementById('memos-section-title').textContent = titles[status];
    
    // Show loading
    document.getElementById('memos-container').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-muted mt-3">Loading memos...</p>
        </div>
    `;
    
    // Fetch memos
    fetch(`/dashboard/uimms/memos/${status}`)
        .then(response => response.json())
        .then(memos => {
            displayMemos(memos);
        })
        .catch(error => {
            console.error('Error loading memos:', error);
            document.getElementById('memos-container').innerHTML = `
                <div class="text-center py-5">
                    <i class="icofont-warning" style="font-size: 48px; color: #dc3545;"></i>
                    <p class="text-danger mt-3">Error loading memos. Please try again.</p>
                </div>
            `;
        });
}

function displayMemos(memos) {
    if (memos.length === 0) {
        document.getElementById('memos-container').innerHTML = `
            <div class="text-center py-5">
                <i class="icofont-chat" style="font-size: 48px; color: #ddd;"></i>
                <p class="text-muted mt-3">No memos found in this section</p>
            </div>
        `;
        return;
    }
    
    const memosHtml = memos.map(memo => {
        const lastMessage = memo.last_message;
        const lastMessageTime = lastMessage ? new Date(lastMessage.created_at).toLocaleDateString() : 'No messages';
        const participants = memo.active_participants || [];
        
        return `
            <div class="memo-item" onclick="openMemoChat(${memo.id})">
                <div class="memo-header">
                    <div class="memo-participants">
                        ${participants.map(p => `
                            <img src="${p.user.profile_picture_url || '/profile_pictures/default-profile.png'}" 
                                 alt="${p.user.first_name}" 
                                 class="participant-avatar"
                                 title="${p.user.first_name} ${p.user.last_name}">
                        `).join('')}
                    </div>
                    <div class="memo-subject">${memo.subject}</div>
                    <div class="memo-meta">
                        <span>Last activity: ${lastMessageTime}</span>
                        <span class="memo-status-badge status-${memo.memo_status || 'pending'}">
                            ${memo.memo_status || 'pending'}
                        </span>
                    </div>
                </div>
            </div>
        `;
    }).join('');
    
    document.getElementById('memos-container').innerHTML = memosHtml;
}

function openMemoChat(memoId) {
    window.location.href = `/dashboard/uimms/chat/${memoId}`;
}

function refreshMemos() {
    if (currentStatus) {
        loadMemos(currentStatus);
    }
}

// Auto-refresh every 30 seconds
setInterval(() => {
    if (currentStatus) {
        loadMemos(currentStatus);
    }
}, 30000);
</script>
@endsection
